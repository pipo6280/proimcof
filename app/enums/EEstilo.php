<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {6/12/2017}
 */
class EEstilo extends AEnum
{

    protected static $array = array();

    const BLANCO_NEGRO = 'N_1';

    const COLOR = 'N_2';

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {6/12/2017}
     */
    protected static function values()
    {
        static::$array[static::BLANCO_NEGRO] = new EEstilo(1, lang('general.eestilo_blaco_negro'));
        static::$array[static::COLOR] = new EEstilo(2, lang('general.eestilo_color'));
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
     * @since {24/01/2018}
     * @param unknown $search
     * @return Ambigous <\app\enums\EEstilo, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new EEstilo(NULL, NULL);
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