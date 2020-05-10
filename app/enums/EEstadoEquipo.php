<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {4/01/2017}
 */
class EEstadoEquipo extends AEnum
{

    protected static $array = array();

    const SIN_ASIGNAR = 'N_1';

    const ALQUILER = 'N_2';
    
    const REPARACION = 'N_3';

    const INACTIVO = 'N_4';
    

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/01/2017}
     */
    protected static function values()
    {
        static::$array[static::SIN_ASIGNAR] = new EEstadoEquipo(1, lang('general.estado_equipo_sin_asignar'));
        static::$array[static::ALQUILER] = new EEstadoEquipo(2, lang('general.estado_equipo_alquiler'));
        static::$array[static::REPARACION] = new EEstadoEquipo(3, lang('general.estado_equipo_reparacion'));
        static::$array[static::INACTIVO] = new EEstadoEquipo(4, lang('general.estado_equipo_inactivo'));
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/01/2017}
     * @param unknown $search
     * @return multitype:
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param unknown $search
     * @return Ambigous <\app\enums\EEstadoEquipo, unknown>
     */     
    public static function result($search)
    {
        static::values();
        $result = new EEstadoEquipo(NULL, NULL);
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
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     * @return unknown
     */
    public static function dataCombo()
    {
        static::values();
        foreach (static::$array as $dato) {
            if($dato->getId() == self::index(self::SIN_ASIGNAR)->getId()) {
                continue;
            }
            $result[] = $dato;
        }
        return $result;
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/01/2017}
     */     
    public static function data()
    {
        static::values();
        return static::$array;
    }
}