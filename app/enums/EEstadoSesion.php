<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {4/01/2017}
 */
class EEstadoSesion extends AEnum
{

    protected static $array = array();

    const ACTIVA = 'N_1';

    const PENDIENTE = 'N_2';

    const CONNFIRMADA = 'N_3';
    
    const MODIFICADA = 'N_4';

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/01/2017}
     */
    protected static function values()
    {
        static::$array[static::ACTIVA] = new EEstadoSesion(1, lang('general.estado_activo'));
        static::$array[static::PENDIENTE] = new EEstadoSesion(2, lang('general.estado_activo'));
        static::$array[static::CONNFIRMADA] = new EEstadoSesion(3, lang('general.estado_activo'));
        static::$array[static::MODIFICADA] = new EEstadoSesion(4, lang('general.estado_activo'));
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
     * @since {4/01/2017}
     * @param unknown $search
     * @return Ambigous <\app\enums\EEstadoSesion, unknown>
     */        
    public static function result($search)
    {
        static::values();
        $result = new EEstadoSesion(NULL, NULL);
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
     * @since {4/01/2017}
     */     
    public static function data()
    {
        static::values();
        return static::$array;
    }
}