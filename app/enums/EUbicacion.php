<?php
namespace app\enums;

/**
 *
 * @class app\enums\EUbicacion
 * 
 * @tutorial
 *
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 20/09/2015
 */
class EUbicacion extends AEnum
{

    protected static $array = array();

    const VERTICAL = 'N_1';

    const HORIZONTAL = 'N_2';

    const HORIZONTAL_INTERNAL = 'N_3';

    const NO_SHOW = 'N_4';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::VERTICAL] = new EUbicacion(1, lang('general.vertical_location'));
        self::$array[self::HORIZONTAL] = new EUbicacion(2, lang('general.horizontal_location'));
        self::$array[self::HORIZONTAL_INTERNAL] = new EUbicacion(3, lang('general.horizontal_internal_location'));
        self::$array[self::NO_SHOW] = new EUbicacion(4, lang('general.none_location'));
    }

    /**
     *
     * @tutorial search for EUbicacion index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return array
     */
    public static function index($search)
    {
        self::values();
        return self::$array[$search];
    }

    /**
     *
     * @tutorial get result of the EUbicacion values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\EUbicacion, EUbicacion>
     */
    public static function result($search)
    {
        self::values();
        $result = new EUbicacion(NULL, NULL);
        foreach (self::$array as $dato) {
            if ($dato->getId() == $search) {
                $result = $dato;
                break;
            }
        }
        return $result;
    }

    /**
     *
     * @tutorial get data values EUbicacion listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return array
     */
    public static function data()
    {
        self::values();
        return self::$array;
    }
}