<?php
namespace app\enums;

use system\Helpers\Lang;

/**
 *
 * @class app\enums\EVistaServicio
 * 
 * @tutorial clase principal del enumerado ESiNo
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 20/09/2015
 */
class EVistaServicio extends AEnum
{

    protected static $array = array();

    const SERVICE_1 = 'N_1';

    const SERVICE_2 = 'N_2';
    
    const SERVICE_3 = 'N_3';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::SERVICE_1] = new ESiNo(1, lang('general.evistaservicio_1'));
        self::$array[self::SERVICE_2] = new ESiNo(2, lang('general.evistaservicio_2'));
        self::$array[self::SERVICE_3] = new ESiNo(3, lang('general.evistaservicio_3'));
    }

    /**
     *
     * @tutorial search for EVistaServicio index
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
     * @tutorial get result of the EVistaServicio values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\EVistaServicio, ESiNo>
     */
    public static function result($search)
    {
        self::values();
        $result = new EVistaServicio(NULL, NULL);
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
     * @tutorial get data values EVistaServicio listed
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