<?php
namespace system\Core;

use system\Support\Str;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Utf8 extends Singleton
{

    /**
     *
     * @tutorial {Determines if UTF-8 support is to be enabled}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @return void
     */
    public function __construct()
    {
        if (Str::upper(config_item('charset')) === 'UTF-8') {
            define('UTF8_ENABLED', TRUE);
            log_message('debug', 'UTF-8 Support Enabled');
        } else {
            define('UTF8_ENABLED', FALSE);
            log_message('debug', 'UTF-8 Support Disabled');
        }
    }

    /**
     *
     * @tutorial {Ensures strings contain only valid UTF-8 characters}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $str            
     * @return string
     */
    public function cleanString($str)
    {
        if ($this->isAscii($str) === FALSE) {            
            if (MB_ENABLED) {
                $str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
            } elseif (ICONV_ENABLED) {
                $str = @iconv('UTF-8', 'UTF-8//IGNORE', $str);
            }
        }
        return $str;
    }

    /**
     *
     * @tutorial {
     *           Removes all ASCII control characters except
     *           horizontal tabs, line feeds, and carriage
     *           returns, as all others can cause
     *           problems in XML.
     *           }
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $str            
     * @return mixed
     */
    public function safeAsciiXml($str)
    {
        return remove_invisible_characters($str, FALSE);
    }

    /**
     *
     * @tutorial {Attempts to convert a string to UTF-8}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $str            
     * @param string $encoding            
     * @return string|boolean
     */
    public function convertUtf8($str, $encoding)
    {
        if (MB_ENABLED) {
            return mb_convert_encoding($str, 'UTF-8', $encoding);
        } elseif (ICONV_ENABLED) {
            return @iconv($encoding, 'UTF-8', $str);
        }
        return FALSE;
    }

    /**
     *
     * @tutorial {Tests if a string is standard 7-bit ASCII or not}
     * @author {Rodolfo Perez || pipo6280@gmail.com}
     * @since {4/08/2015}
     * @param string $str            
     * @return boolean
     * @return boolean
     */
    public function isAscii($str)
    {
        return (preg_match('/[^\x00-\x7F]/S', $str) === 0);
    }
}