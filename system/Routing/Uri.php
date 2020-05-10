<?php
namespace system\Routing;

use system\Support\Util;
use system\Core\Config;
use system\Core\Singleton;
use system\Support\Arr;
use system\Support\Str;

class Uri extends Singleton
{

    public $keyval = array();

    public $uriString = '';

    public $segments = array();

    public $rsegments = array();

    protected $permittedUriChars;

    public function __construct()
    {
        $this->config = Config::instance();
        $this->config = $this->config instanceof Config ? $this->config : new Config();
        if (is_cli() or $this->config->get('enable_query_strings') !== TRUE) {
            $this->setPermittedUriChars($this->config->get('permitted_uri_chars'));
            if (is_cli()) {
                $uri = $this->parseArgv();
            } else {
                $protocol = $this->config->get('uri_protocol');
                empty($protocol) && $protocol = 'REQUEST_URI';
                switch ($protocol) {
                    case 'AUTO':
                    case 'REQUEST_URI':
                        $uri = $this->parseRequestUri();
                        break;
                    case 'QUERY_STRING':
                        $uri = $this->parseQueryString();
                        break;
                    case 'PATH_INFO':
                    default:
                        $uri = isset($_SERVER[$protocol]) ? $_SERVER[$protocol] : $this->parseRequestUri();
                        break;
                }
            }
            $this->uriString($uri);
        }
    }

    /**
     *
     * @tutorial {Take each command line argument and assume it is a URI segment.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    protected function parseArgv()
    {
        $args = array_slice($_SERVER['argv'], 1);
        return $args ? Arr::implode($args, '/') : '';
    }

    /**
     *
     * @tutorial {will parse REQUEST_URI and automatically detect the URI from it, while fixing the query string if necessary.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    protected function parseRequestUri()
    {
        if (! isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
            return '';
        }
        
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $query = isset($uri['query']) ? $uri['query'] : '';
        $uri = isset($uri['path']) ? $uri['path'] : '';
        
        if (isset($_SERVER['SCRIPT_NAME'][0])) {
            if (Str::strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
                $uri = (string) substr($uri, Str::strlen($_SERVER['SCRIPT_NAME']));
            } elseif (Str::strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
                $uri = (string) substr($uri, Str::strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }
        }
        
        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (trim($uri, '/') === '' && Str::strncmp($query, '/', 1) === 0) {
            $query = Arr::explode($query, '?', 2);
            $uri = $query[0];
            $_SERVER['QUERY_STRING'] = isset($query[1]) ? $query[1] : '';
        } else {
            $_SERVER['QUERY_STRING'] = $query;
        }
        
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        
        if ($uri === '/' or $uri === '') {
            return '/';
        }
        
        // Do some final cleaning of the URI and return it
        return $this->removeRelativeDirectory($uri);
    }

    /**
     *
     * @tutorial {Will parse QUERY_STRING and automatically detect the URI from it.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    protected function parseQueryString()
    {
        $uri = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
        if (Util::trim($uri, '/') === '') {
            return '';
        } elseif (strncmp($uri, '/', 1) === 0) {
            $uri = explode('?', $uri, 2);
            $_SERVER['QUERY_STRING'] = isset($uri[1]) ? $uri[1] : '';
            $uri = $uri[0];
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        return $this->removeRelativeDirectory($uri);
    }

    /**
     *
     * @tutorial {
     *           Remove relative directory (../) and multi slashes (///),
     *           Do some final cleaning of the URI and return it, currently only used in self::setParseRequest_uri()
     *           }
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $uri            
     * @return string
     */
    protected function removeRelativeDirectory($uri)
    {
        $uris = array();
        $tok = strtok($uri, '/');
        while ($tok !== FALSE) {
            if ((! empty($tok) or $tok === '0') && $tok !== '..') {
                $uris[] = $tok;
            }
            $tok = strtok('/');
        }
        
        return Arr::implode($uris, '/');
    }

    /**
     * Set URI String
     *
     * @param string $str            
     * @return void
     */
    protected function uriString($str)
    {
        // Filter out control characters and trim slashes
        $this->uriString = Util::trim(remove_invisible_characters($str, FALSE), '/');
        if ($this->uriString !== '') {
            // Remove the URL suffix, if present
            if (($suffix = (string) $this->config->get('url_suffix')) !== '') {
                $slen = Str::strlen($suffix);
                if (substr($this->uriString, - $slen) === $suffix) {
                    $this->uriString = substr($this->uriString, 0, - $slen);
                }
            }
            $this->segments[0] = NULL;
            // Populate the segments array
            foreach (Arr::explode(Util::trim($this->uriString, '/'), '/') as $val) { //
                $val = Util::trim($val);
                // Filter segments for security
                $this->setFilterUri($val);
                if ($val !== '') {
                    $this->segments[] = $val;
                }
            }
            unset($this->segments[0]);
        }
    }

    /**
     *
     * @tutorial {Filters segments for malicious characters.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $str            
     * @throws \Exception
     */
    protected function setFilterUri(&$str)
    {
        if (! empty($str) && ! empty($this->permittedUriChars) && ! preg_match('/^[' . $this->permittedUriChars . ']+$/i' . (UTF8_ENABLED ? 'u' : ''), $str)) {
            show_error('The URI you submitted has disallowed characters.', 400);
            // throw new \Exception('The URI you submitted has disallowed characters', 400);
        }
    }

    /**
     *
     * @tutorial {Fetch URI string}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    public function getUriString()
    {
        return $this->uriString;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $uriString            
     */
    public function setUriString($uriString)
    {
        return ltrim(Router::getInstance()->directory, '/') . Arr::implode($this->rsegments, '/');
        $this->uriString = $uriString;
    }

    /**
     *
     * @tutorial {Fetch re-routed uri string}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @return string
     */
    public function getRuriString()
    {
        return Util::lTrim(Router::getInstance()->getDirectory(), '/') . Arr::implode($this->rsegments, '/');
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return multitype:
     */
    public function getKeyval()
    {
        return $this->keyval;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param multitype: $keyval            
     */
    public function setKeyval($keyval)
    {
        $this->keyval = $keyval;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return multitype:
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param multitype: $segments            
     */
    public function setSegments($segments)
    {
        $this->segments = $segments;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return multitype:
     */
    public function getRsegments()
    {
        return $this->rsegments;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param multitype: $rsegments            
     */
    public function setRsegments($rsegments)
    {
        $this->rsegments = $rsegments;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return field_type
     */
    public function getPermittedUriChars()
    {
        return $this->permittedUriChars;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param field_type $permittedUriChars            
     */
    public function setPermittedUriChars($permittedUriChars)
    {
        $this->permittedUriChars = $permittedUriChars;
    }
}
