<?php
namespace app\enums;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 17, 2016
 */
class EEstadoCuenta extends AEnum
{

    protected static $array = array();

    /**
     *
     * @tutorial cuando el cliente asiste a todas las sessiones
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     */
    const ACTIVA = 'N_1';

    /**
     *
     * @tutorial cuando el cliente asiste a todas las sessiones
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     */
    const VENCIDA = 'N_2';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    protected static function values()
    {
        static::$array[static::ACTIVA] = new EEstadoCuenta(1, 'Activo');
        static::$array[static::VENCIDA] = new EEstadoCuenta(2, 'Vencida');
    }

    /**
     *
     * @tutorial search for EEstadoCuenta index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return AEnum
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     *
     * @tutorial get result of the EEstadoCuenta values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\EEstadoCuenta, AEnum>
     */
    public static function result($search)
    {
        static::values();
        $result = new EEstadoCuenta(NULL, NULL);
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
     * @tutorial get data values EEstadoCuenta listed
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