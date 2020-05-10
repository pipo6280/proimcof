<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {6/12/2017}
 */
class ETipoEmpresa extends AEnum
{

    protected static $array = array();

    const PERSONA_NATURAL = 'N_1';

    const EMPRESA = 'N_2';

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {6/12/2017}
     */
    protected static function values()
    {
        static::$array[static::PERSONA_NATURAL] = new ETipoEmpresa(1, lang('general.etipoempresa_persona'));
        static::$array[static::EMPRESA] = new ETipoEmpresa(2, lang('general.etipoempresa_empresa'));
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
     * @since {19/01/2018}
     * @param unknown $search
     * @return Ambigous <\app\enums\ETipoEmpresa, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new ETipoEmpresa(NULL, NULL);
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