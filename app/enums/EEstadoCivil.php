<?php
namespace app\enums;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 21/11/2016
 */
class EEstadoCivil extends AEnum
{

    protected static $array = array();

    const SOLTERO = 'N_1';

    const CASADO = 'N_2';

    const DIVORCIADO = 'N_3';

    const VIUDO = 'N_4';

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 21/11/2016
     */
    public static function values()
    {
        self::$array[self::SOLTERO] = new EEstadoCivil(1, lang('general.estado_civil_soltero'));
        self::$array[self::CASADO] = new EEstadoCivil(2, lang('general.estado_civil_casado'));
        self::$array[self::DIVORCIADO] = new EEstadoCivil(3, lang('general.estado_civil_divorciado'));
        self::$array[self::VIUDO] = new EEstadoCivil(4, lang('general.estado_civil_viudo'));
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 21/11/2016
     * @param string $search            
     * @return AEnum
     */
    public static function index($search)
    {
        self::values();
        return self::$array[$search];
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 21/11/2016
     * @param string $search            
     * @return Ambigous <\app\enums\EEstadoCivil, AEnum>
     */
    public static function result($search)
    {
        self::values();
        $result = new EEstadoCivil(NULL, NULL);
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
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 21/11/2016
     * @return multitype:AEnum
     */
    public static function data()
    {
        self::values();
        return self::$array;
    }
}