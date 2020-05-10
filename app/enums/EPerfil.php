<?php
namespace app\enums;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 17, 2016
 */
class EPerfil extends AEnum
{

    protected static $array = array();

    const TALENTO_HUMANO = 'N_1';

    const CLIENTE = 'N_2';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    protected static function values()
    {
        static::$array[static::TALENTO_HUMANO] = new EPerfil(1, lang('general.talento_humano'));
        static::$array[static::CLIENTE] = new EPerfil(2, lang('general.cliente'));
    }

    /**
     *
     * @tutorial search for EPerfil index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return array
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     *
     * @tutorial get result of the EPerfil values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\EPerfil, EPerfil>
     */
    public static function result($search)
    {
        static::values();
        $result = new EPerfil(NULL, NULL);
        foreach (static::$array as $dato) {
            if ($dato->getId() == $search) {
                $result = $dato;
                break;
            }
        }
        return $result;
    }

    /**
     *
     * @tutorial get data values EPerfil listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return array
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}