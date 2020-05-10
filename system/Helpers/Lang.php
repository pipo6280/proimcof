<?php
namespace system\Helpers;

use system\Core\Singleton;
use system\Support\Arr;
use system\Support\Util;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Lang extends Singleton
{

    /**
     *
     * @var array
     */
    protected $is_loaded = array();

    /**
     *
     * @var array
     */
    protected $language = array();

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @return void
     */
    public function __construct()
    {
        log_message('info', 'Language Class Initialized');
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @param unknown $langFile            
     * @param string $idiom            
     * @param string $return            
     * @param string $addSuffix            
     * @param string $altPath            
     * @return void|multitype:|unknown|boolean
     */
    public function load($langFile, $idiom = '', $return = FALSE, $addSuffix = TRUE, $altPath = '')
    {
        if (is_array($langFile)) {
            foreach ($langFile as $value) {
                $this->load($value, $idiom, $return, $addSuffix, $altPath);
            }
            return;
        }
        $langFile = str_replace('.php', '', $langFile);
        $temporalLang = $langFile;
        if ($addSuffix === TRUE) {
            $langFile = preg_replace('/_lang$/', '', $langFile) . '_lang';
        }
        $langFile .= '.php';
        if (empty($idiom) or ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $config = & get_config();
            $idiom = empty($config['language']) ? 'english' : $config['language'];
        }
        if ($return === FALSE && isset($this->is_loaded[$langFile]) && $this->is_loaded[$langFile] === $idiom) {
            return;
        }
        // Load the base file, so any others found can override it
        $basePath = EM_BASEPATH . 'resources/lang/' . $idiom . '/' . $langFile;
        if (($found = file_exists($basePath)) === TRUE) {
            $lang = include ($basePath);
        }
        // Do we have an alternative path to look in?
        if ($altPath !== '') {
            $altPath .= 'resources/lang/' . $idiom . '/' . $langFile;
            if (file_exists($altPath)) {
                include ($altPath);
                $found = TRUE;
            }
        }
        if ($found !== TRUE) {
            show_error('Unable to load the requested language file: language/' . $idiom . '/' . $langFile);
        }
        if (! isset($lang) or ! is_array($lang)) {
            log_message('error', 'Language file contains no data: language/' . $idiom . '/' . $langFile);
            if ($return === TRUE) {
                return array();
            }
            return;
        }
        if ($return === TRUE) {
            return $lang;
        }
        $this->is_loaded[$langFile] = $idiom;
        if (Arr::isNullArray($temporalLang, $this->language)) {
            $this->language[$temporalLang] = array();
        }
        $this->language[$temporalLang] = array_merge($this->language[$temporalLang], $lang);
        
        log_message('info', 'Language file loaded: language/' . $idiom . '/' . $langFile);
        return TRUE;
    }

    /**
     *
     * @tutorial Method Description: Fetches a single line of text from the language array
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @param unknown $line            
     * @param string $log_errors            
     * @return Ambigous <boolean, multitype:>
     */
    public function line($line, $parameters = array(), $log_errors = TRUE)
    {
        $index = NULL;
        if (strpos($line, '.') !== FALSE) {
            list ($index, $line) = Arr::explode($line, '.');
        }
        if (! Util::isVacio($index)) {
            $value = isset($this->language[strtolower($index)][$line]) ? $this->language[$index][$line] : FALSE;
        } else {
            $value = isset($this->language[$line]) ? $this->language[$line] : FALSE;
        }
        $i = 0;
        foreach ($parameters as $par) {
            $value = str_replace('{' . $i . '}', $par, $value);
            $i ++;
        }
        unset($var);
        // Because killer robots like unicorns!
        if ($value === FALSE && $log_errors === TRUE) {
            log_message('error', 'Could not find the language line "' . $line . '"');
        }
        return $value;
    }
}