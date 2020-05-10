<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {6/12/2017}
 */
class ETipoEquipo extends AEnum
{

    protected static $array = array();

    const IMPRESORA = 'N_1';

    const MULTIFUNCION = 'N_2';

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {6/12/2017}
     */
    protected static function values()
    {
        static::$array[static::IMPRESORA] = new ETipoEquipo(1, lang('general.etipoequipo_impresora'));
        static::$array[static::MULTIFUNCION] = new ETipoEquipo(2, lang('general.etipoequipo_multifuncion'));
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {6/12/2017}
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
     * @since {6/12/2017}
     * @param unknown $search
     * @return Ambigous <\app\enums\ETipoEquipo, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new ETipoEquipo(NULL, NULL);
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
     * @since {6/12/2017}
     * @return multitype:
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}