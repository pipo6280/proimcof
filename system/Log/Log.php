<?php
namespace system\Log;

use system\Core\Singleton;
use system\Support\Util;
use system\Support\Str;
use system\Support\Arr;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since {28/11/2015}
 */
class Log extends Singleton
{

    /**
     *
     * @tutorial Path to save log files
     * @var string
     */
    protected $logPath;

    /**
     *
     * @tutorial File permissions
     * @var int
     */
    protected $filePermissions = 0644;

    /**
     *
     * @tutorial Level of logging
     * @var int
     */
    protected $threshold = 1;

    /**
     *
     * @tutorial Array of threshold levels to log
     * @var array
     */
    protected $thresholdArray = array();

    /**
     *
     * @tutorial Format of timestamp for log files
     * @var string
     */
    protected $dateFmt = 'Y-m-d H:i:s';

    /**
     *
     * @tutorial Filename extension
     * @var string
     */
    protected $fileExt;

    /**
     *
     * @tutorial Whether or not the logger can write to the log files
     * @var bool
     */
    protected $enabled = TRUE;

    /**
     *
     * @tutorial Predefined logging levels
     * @var array
     */
    protected $levels = array(
        'ERROR' => 1,
        'DEBUG' => 2,
        'INFO' => 3,
        'DOCTRINE' => 4,
        'ALL' => 5
    );

    /**
     *
     * @tutorial {Class constructor}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     */
    public function __construct()
    {
        $config = & get_config();
        
        $this->setLogPath(($config['log_path'] !== '') ? $config['log_path'] : EM_BASEPATH . 'storage/logs/');
        $this->setFileExt((isset($config['log_file_extension']) && $config['log_file_extension'] !== '') ? ltrim($config['log_file_extension'], '.') : 'php');
        
        file_exists($this->getLogPath()) or mkdir($this->getLogPath(), 0755, TRUE);
        
        if (! is_dir($this->getLogPath()) or ! is_really_writable($this->getLogPath())) {
            $this->enabled = FALSE;
        }
        if (is_numeric($config['log_threshold'])) {
            $this->setThreshold((int) $config['log_threshold']);
        } elseif (Arr::isArray($config['log_threshold'])) {
            $this->setThreshold(0);
            $this->setThresholdArray(array_flip($config['log_threshold']));
        }
        if (! Util::isVacio($config['log_date_format'])) {
            $this->setDateFmt($config['log_date_format']);
        }
        if (! Util::isVacio($config['log_file_permissions']) && is_int($config['log_file_permissions'])) {
            $this->setFilePermissions($config['log_file_permissions']);
        }
    }

    public function write($level, $msg, $msgExtra = '')
    {
        if (! $this->getEnabled()) {
            return FALSE;
        }
        $level = Str::upper($level);
        if ((! isset($this->levels[$level]) or ($this->levels[$level] > $this->getThreshold())) && ! isset($this->thresholdArray[$this->levels[$level]])) {
            return FALSE;
        }
        
        $filePath = $this->getLogPath() . 'log-' . date('Y-m-d') . '.' . $this->getFileExt();
        $message = '';
        
        if (! file_exists($filePath)) {
            $newFile = TRUE;
            if ($this->getFileExt() === 'php') {
                $message .= "<?php defined('EM_BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
            }
        }
        if (! $fp = @fopen($filePath, 'ab')) {
            return FALSE;
        }
        // Instantiating DateTime with microseconds appended to initial date is needed for proper support of this format
        if (Str::strpos($this->getDateFmt(), 'u') !== FALSE) {
            $microtime_full = microtime(TRUE);
            $microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
            $date = new \DateTime(date('Y-m-d H:i:s.' . $microtime_short, $microtime_full));
            $date = $date->format($this->getDateFmt());
        } else {
            $date = date($this->getDateFmt());
        }
        $message .= $level . ' - ' . $date . ' --> ' . $msg . ' ' . $msgExtra . "\n";
        flock($fp, LOCK_EX);
        for ($written = 0, $length = Str::strlen($message); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($message, $written))) === FALSE) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        if (isset($newFile) && $newFile === TRUE) {
            chmod($filePath, $this->getFilePermissions());
        }
        return is_int($result);
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    protected function getLogPath()
    {
        return $this->logPath;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return number
     */
    protected function getFilePermissions()
    {
        return $this->filePermissions;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return number
     */
    protected function getThreshold()
    {
        return $this->threshold;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return multitype:
     */
    protected function getThresholdArray()
    {
        return $this->thresholdArray;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    protected function getDateFmt()
    {
        return $this->dateFmt;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return string
     */
    protected function getFileExt()
    {
        return $this->fileExt;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return boolean
     */
    protected function getEnabled()
    {
        return $this->enabled;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $logPath            
     */
    protected function setLogPath($logPath)
    {
        $this->logPath = $logPath;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param number $filePermissions            
     */
    protected function setFilePermissions($filePermissions)
    {
        $this->filePermissions = $filePermissions;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param number $threshold            
     */
    protected function setThreshold($threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param multitype: $thresholdArray            
     */
    protected function setThresholdArray($thresholdArray)
    {
        $this->thresholdArray = $thresholdArray;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $dateFmt            
     */
    protected function setDateFmt($dateFmt)
    {
        $this->dateFmt = $dateFmt;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $fileExt            
     */
    protected function setFileExt($fileExt)
    {
        $this->fileExt = $fileExt;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param boolean $enabled            
     */
    protected function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
