<?php
namespace app\enums;

/**
 *
 * @class app\enums\EGenero
 *
 * @tutorial
 *
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 20/09/2015
 */
class EestadoListaChequeo extends AEnum
{

    protected static $array = array();

    const INSPECCIONAR = 'N_1';

    const LIMPIAR = 'N_2';

    const CAMBIAR = 'N_3';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $show            
     * @return void
     */
    public static function values()
    {
        self::$array[self::INSPECCIONAR] = new EestadoListaChequeo(1, lang('general.estado_inspeccionar'));
        self::$array[self::LIMPIAR] = new EestadoListaChequeo(2, lang('general.estado_limpiar'));
        self::$array[self::CAMBIAR] = new EestadoListaChequeo(3, lang('general.estado_cambiar'));
        
    }

    /**
     *
     * @tutorial search for EGenero index
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
     * @tutorial get result of the EGenero values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\EestadoListaChequeo, EestadoListaChequeo>
     */
    public static function result($search)
    {
        self::values();
        $result = new EestadoListaChequeo(NULL, NULL);
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
     * @tutorial get data values EestadoListaChequeo listed
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