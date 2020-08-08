<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {4/01/2017}
 */
class EEstadoMantenimiento extends AEnum
{

    protected static $array = array();

    const SOLICITADO = 'N_1';

    const REVISADO = 'N_2';
    
    const PENDIENTE = 'N_3';

    const SOLUCIONADO = 'N_4';
    
    const CERRADO = 'N_5';
    

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/01/2017}
     */
    protected static function values()
    {
        static::$array[static::SOLICITADO] = new EEstadoMantenimiento(1, lang('general.estado_mantenimieno_solicitado'));
        static::$array[static::REVISADO] = new EEstadoMantenimiento(2, lang('general.estado_mantenimieno_revisado'));
        static::$array[static::PENDIENTE] = new EEstadoMantenimiento(3, lang('general.estado_mantenimieno_pendiente'));
        static::$array[static::SOLUCIONADO] = new EEstadoMantenimiento(4, lang('general.estado_mantenimieno_solucionado'));
        static::$array[static::CERRADO] = new EEstadoMantenimiento(5, lang('general.estado_mantenimieno_cerrado'));
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
     * @return Ambigous <\app\enums\EEstadoMantenimiento, EEstadoMantenimiento>
     */     
    public static function result($search)
    {
        static::values();
        $result = new EEstadoMantenimiento(NULL, NULL);
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
     * @return EEstadoMantenimiento
     */
    public static function dataCombo()
    {
        static::values();
        $result[] = null;
        foreach (static::$array as $dato) {
            if($dato->getId() == self::index(self::PENDIENTE)->getId() || $dato->getId() == self::index(self::SOLUCIONADO)->getId() ) {
                $result[] = $dato;
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