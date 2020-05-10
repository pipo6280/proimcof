<?php
namespace system\Core;

use system\Support\Util;
use system\Routing\Uri;
use system\Support\Str;
use system\Support\Arr;

class Output extends Singleton
{

    /**
     *
     * @tutorial Final output string
     * @var string
     */
    public $finalOutput;

    /**
     *
     * @tutorial Cache expiration time
     * @var integer
     */
    public $cacheExpiration = 0;

    /**
     *
     * @tutorial List of server headers
     * @var array
     */
    public $headers = array();

    /**
     *
     * @tutorial List of mime types
     * @var array
     */
    public $listMimes = array();

    /**
     *
     * @tutorial Mime-type for the current page
     * @var string
     */
    protected $mimeType = 'text/html';

    /**
     *
     * @tutorial Enable Profiler flag
     * @var bool
     */
    public $enableProfiler = FALSE;

    /**
     *
     * @tutorial php.ini zlib.output_compression flag
     * @var bool
     */
    protected $zlibOc = FALSE;

    /**
     *
     * @tutorial Output compression flag
     * @var bool
     */
    protected $compressOutput = FALSE;

    /**
     *
     * @tutorial List of profiler sections
     * @var array
     */
    protected $profilerSections = array();

    /**
     *
     * @tutorial Whether or not to parse variables like {elapsed_time} and {memory_usage}
     * @var bool
     */
    public $parseExecuteVars = TRUE;

    /**
     *
     * @var string
     */
    protected $cachePath = NULL;

    /**
     *
     * @var Config
     */
    protected $config;

    /**
     *
     * @var Uri
     */
    protected $uri;

    /**
     *
     * @tutorial {Class constructor and determines whether zLib output compression will be used}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     */
    public function __construct()
    {
        $this->config = Config::instance();
        $this->uri = Uri::instance();
        $this->zlibOc = (bool) ini_get('zlib.output_compression');
        $this->compressOutput = ($this->zlibOc === FALSE && config_item('compress_output') === TRUE && extension_loaded('zlib'));
        $this->listMimes = & get_mimes();
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    public function cache()
    {
        $this->setCachePath(($this->config->get('cache_path') === '') ? $this->getCachePath() : $this->config->get('cache_path'));
        // Build the file path. The file name is an MD5 hash of the full URI
        $uriClass = $this->config->get('base_url') . $this->config->get('index_page') . $this->uri->getUriString();
        if ($this->config->get('cache_query_string') && ! empty($_SERVER['QUERY_STRING'])) {
            $uriClass .= '?' . $_SERVER['QUERY_STRING'];
        }
        if (! Util::fileExists($this->getCachePath())) {
            return FALSE;
        }
        Util::fileExists($this->getCachePath()) or mkdir($this->getCachePath(), 0755, TRUE);
        
        $filepath = rtrim($this->getCachePath(), '/') . '/' . Util::md5($uriClass);
        if (($fp = @fopen($filepath, 'ab')) === FALSE) {
            return FALSE;
        }
        if (! file_exists($filepath) or ! $fp = @fopen($filepath, 'rb')) {
            return FALSE;
        }
        flock($fp, LOCK_SH);
        $cache = (filesize($filepath) > 0) ? fread($fp, filesize($filepath)) : '';
        flock($fp, LOCK_UN);
        fclose($fp);
        // Look for embedded serialized file info.
        if (! preg_match('/^(.*)ENDCI--->/', $cache, $match)) {
            return FALSE;
        }
        $cacheInfo = Util::unserialize($match[1]);
        $expire = $cacheInfo['expire'];
        $last_modified = filemtime($this->getCachePath());
        // Has the file expired?
        if ($_SERVER['REQUEST_TIME'] >= $expire && is_really_writable($this->getCachePath())) {
            // If so we'll delete it.
            @unlink($filepath);
            log_message('debug', 'Cache file has expired. File deleted.');
            return FALSE;
        } else {
            // Or else send the HTTP cache control headers.
            $this->cacheHeader($last_modified, $expire);
        }
        // Add headers from cache file.
        foreach ($cacheInfo['headers'] as $header) {
            $this->setHeaders($header[0], $header[1]);
        }
        // Display the cache
        $this->display(substr($cache, strlen($match[0])));
        log_message('debug', 'Cache file is current. Sending it to browser.');
        return TRUE;
    }

    public function display($output = '')
    {
        // Set the output data
        if ($output === '') {
            $output = & $this->finalOutput;
        }
        // Do we need to write a cache file? Only if the controller does not have its
        // own _output() method and we are not dealing with a cache file, which we can determine by the existence of the $CI object above
        if (! Util::isVacio($output) && $this->getCacheExpiration() > 0) {
            $this->writeCache($output);
        }
        // Parse out the elapsed time and memory usage, then swap the pseudo-variables with the data
        $elapsed = Benchmark::elapsedTime('total_execution_time_start', 'total_execution_time_end');
        if ($this->parseExecuteVars === TRUE) {
            $memory = Util::round(memory_get_usage() / 1024 / 1024, 2) . 'MB';
            $output = Str::strReplace(array(
                '{elapsed_time}',
                '{memory_usage}'
            ), array(
                $elapsed,
                $memory
            ), $output);
        }
        // Is compression requested?
        // This means that we're not serving a cache file, if we were, it would already be compressed
        if ($this->compressOutput === TRUE && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
            ob_start('ob_gzhandler');
        }
        // Are there any server headers to send?
        if (Arr::count($this->headers) > 0) {
            foreach ($this->headers as $header) {
                @header($header[0], $header[1]);
            }
        }
        // Does the $CI object exist?
        // If not we know we are dealing with a cache file so we'll simply echo out the data and exit.
        if (! isset($instances)) {
            if ($this->compressOutput === TRUE) {
                if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && Str::strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
                    header('Content-Encoding: gzip');
                    header('Content-Length: ' . Str::strlen($output));
                } else {
                    // User agent doesn't support gzip compression, so we'll have to decompress our cache
                    $output = gzinflate(substr($output, 10, - 8));
                }
            }
            echo $output; // Send it to the browser!
            log_message('info', 'Final output sent to browser');
            log_message('debug', 'Total execution time: ' . $elapsed);
            return;
        }
    }

    protected function writeCache($output)
    {
        $path = $this->config->get('cache_path');
        $cachePath = ($path === '') ? 'storage/cache/' : $path;
        if (! is_dir($cachePath) or ! is_really_writable($cachePath)) {
            log_message('error', 'Unable to write cache file: ' . $cachePath);
            return;
        }
        $uriClass = $this->config->get('base_url') . $this->config->get('index_page') . $this->uri->getUriString();
        if ($this->config->get('cache_query_string') && ! empty($_SERVER['QUERY_STRING'])) {
            $uriClass .= '?' . $_SERVER['QUERY_STRING'];
        }
        $cachePath .= Util::md5($uriClass);
        if (! $fp = @fopen($cachePath, 'w+b')) {
            log_message('error', 'Unable to write cache file: ' . $cachePath);
            return;
        }
        if (flock($fp, LOCK_EX)) {
            // If output compression is enabled, compress the cache itself, so that we don't have to do that each time we're serving it
            if ($this->compressOutput === TRUE) {
                $output = gzencode($output);
                if ($this->getHeaders('content-type') === NULL) {
                    $this->contentType($this->mimeType);
                }
            }
            $expire = time() + ($this->cacheExpiration * 60);
            // Put together our serialized info.
            $cacheInfo = Util::serialize(array(
                'expire' => $expire,
                'headers' => $this->headers
            ));
            $output = $cacheInfo . 'ENDCI--->' . $output;
            for ($written = 0, $length = strlen($output); $written < $length; $written += $result) {
                if (($result = fwrite($fp, substr($output, $written))) === FALSE) {
                    break;
                }
            }
            flock($fp, LOCK_UN);
        } else {
            log_message('error', 'Unable to secure a file lock for file at: ' . $cachePath);
            return;
        }
        fclose($fp);
        if (is_int($result)) {
            chmod($cachePath, 0640);
            log_message('debug', 'Cache file written: ' . $cachePath);
            // Send HTTP cache-control headers to browser to match file cache settings.
            $this->cacheHeader($_SERVER['REQUEST_TIME'], $expire);
        } else {
            // var_dump($cachePath);
            @unlink($cachePath);
            log_message('error', 'Unable to write the complete cache content at: ' . $cachePath);
        }
    }

    /**
     *
     * @tutorial {Set Content-Type Header}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param unknown $mimeType            
     * @param string $charset            
     * @return \system\Core\Output
     */
    public function contentType($mimeType, $charset = NULL)
    {
        if (Str::strpos($mimeType, '/') === FALSE) {
            $extension = Util::ltrim($mimeType, '.');
            
            // Is this extension supported?
            if (isset($this->listMimes[$extension])) {
                $mimeType = & $this->listMimes[$extension];
                if (Arr::isArray($mimeType)) {
                    $mimeType = Arr::current($mimeType);
                }
            }
        }
        $this->mimeType = $mimeType;
        if (empty($charset)) {
            $charset = config_item('charset');
        }
        $header = 'Content-Type: ' . $mimeType . (empty($charset) ? '' : '; charset=' . $charset);
        $this->headers[] = array(
            $header,
            TRUE
        );
        return $this;
    }

    /**
     *
     * @tutorial {}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @return unknown|string
     */
    public function getContent_type()
    {
        for ($i = 0, $c = count($this->headers); $i < $c; $i ++) {
            if (sscanf($this->headers[$i][0], 'Content-Type: %[^;]', $content_type) === 1) {
                return $content_type;
            }
        }
        return 'text/html';
    }

    /**
     *
     * @tutorial {Set the HTTP headers to match the server-side file cache settings in order to reduce bandwidth.}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $last_modified            
     * @param integer $expiration            
     */
    protected function cacheHeader($last_modified, $expiration)
    {
        $max_age = $expiration - $_SERVER['REQUEST_TIME'];
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $last_modified <= strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $this->statusHeader(304);
            exit();
        } else {
            header('Pragma: public');
            header('Cache-Control: max-age=' . $max_age . ', public');
            header('Expires: ' . gmdate('D, d M Y H:i:s', $expiration) . ' GMT');
            header('Last-modified: ' . gmdate('D, d M Y H:i:s', $last_modified) . ' GMT');
        }
    }

    /**
     * Delete cache
     *
     * @param string $uri            
     * @return bool
     */
    public function setDelete_cache($uri = '')
    {
        $cachePath = $this->config->get('cache_path');
        if ($cachePath === '') {
            $cachePath = $this->getCachePath();
        }
        if (! is_dir($cachePath)) {
            log_message('error', 'Unable to find cache path: ' . $cachePath);
            return FALSE;
        }
        if (empty($uri)) {
            $uri = $this->uri->uri_string();
            
            if ($this->config->get('cache_query_string') && ! empty($_SERVER['QUERY_STRING'])) {
                $uri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }
        $cachePath .= md5($this->config->get('base_url') . $this->config->get('index_page') . $uri);
        if (! @unlink($cachePath)) {
            log_message('error', 'Unable to delete cache file for ' . $uri);
            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * @tutorial {Set HTTP Status Header}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param number $code            
     * @param string $text            
     * @return \system\Core\Output
     */
    public function statusHeader($code = 200, $text = '')
    {
        set_status_header($code, $text);
        return $this;
    }

    /**
     *
     * @tutorial {Enable/disable Profiler}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $val            
     * @return \system\Core\Output
     */
    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param boolean $enableProfiler            
     */
    public function setEnableProfiler($enableProfiler = TRUE)
    {
        $this->enableProfiler = is_bool($enableProfiler) ? $enableProfiler : TRUE;
        return $this;
    }

    /**
     *
     * @tutorial {Set Profiler Sections Allows override of default/config settings for Profiler section display}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param multitype: $profilerSections            
     */
    public function setProfilerSections($profilerSections)
    {
        if (isset($profilerSections['query_toggle_count'])) {
            $this->profilerSections['query_toggle_count'] = (int) $profilerSections['query_toggle_count'];
            unset($sections['query_toggle_count']);
        }
        foreach ($profilerSections as $section => $enable) {
            $this->profilerSections[$section] = ($enable !== FALSE);
        }
        return $this;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param number $cacheExpiration            
     */
    public function setCacheExpiration($cacheExpiration)
    {
        $this->cacheExpiration = is_numeric($cacheExpiration) ? $cacheExpiration : 0;
        return $this;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param multitype: $headers            
     */
    public function setHeaders($headers, $replace = TRUE)
    {
        if ($this->zlibOc && strncasecmp($headers, 'content-length', 14) === 0) {
            return $this;
        }
        $this->headers[] = array(
            $headers,
            $replace
        );
        return $this;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return multitype:
     */
    public function getHeaders($header)
    {
        // Combine headers already sent with our batched headers
        $headers = array_merge(
            // We only need [x][0] from our multi-dimensional array
            Util::arrayMap('array_shift', $this->headers), headers_list());
        
        if (empty($headers) or empty($header)) {
            return NULL;
        }
        
        for ($i = 0, $c = count($headers); $i < $c; $i ++) {
            if (strncasecmp($header, $headers[$i], $l = strlen($header)) === 0) {
                return trim(substr($headers[$i], $l + 1));
            }
        }
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $finalOutput            
     */
    public function setFinalOutput($finalOutput)
    {
        $this->finalOutput .= $finalOutput;
        return $this;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    public function getFinalOutput()
    {
        return $this->finalOutput;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return number
     */
    public function getCacheExpiration()
    {
        return $this->cacheExpiration;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return multitype:
     */
    public function getListMimes()
    {
        return $this->listMimes;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    public function getEnableProfiler()
    {
        return $this->enableProfiler;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    public function getZlibOc()
    {
        return $this->zlibOc;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    public function getCompressOutput()
    {
        return $this->compressOutput;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return multitype:
     */
    public function getProfilerSections()
    {
        return $this->profilerSections;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    public function getParseExecuteVars()
    {
        return $this->parseExecuteVars;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param multitype: $listMimes            
     */
    public function setListMimes($listMimes)
    {
        $this->listMimes = $listMimes;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $mimeType            
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param boolean $zlibOc            
     */
    public function setZlibOc($zlibOc)
    {
        $this->zlibOc = $zlibOc;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param boolean $compressOutput            
     */
    public function setCompressOutput($compressOutput)
    {
        $this->compressOutput = $compressOutput;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param boolean $parseExecuteVars            
     */
    public function setParseExecuteVars($parseExecuteVars)
    {
        $this->parseExecuteVars = $parseExecuteVars;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    public function getCachePath()
    {
        return $this->cachePath;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $cachePath            
     */
    public function setCachePath($cachePath)
    {
        $this->cachePath = $cachePath;
    }
}