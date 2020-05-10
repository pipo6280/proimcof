<?php
namespace app\enums;

/**
 *
 * @tutorial Method Description:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 14/11/2016
 */
class ETarget extends AEnum
{

    protected static $array = array();

    const T_SELF = 'N_1';

    const T_BLANK = 'N_2';

    const T_PARENT = 'N_3';

    const T_TOP = 'N_4';

    const T_FRAMENAME = 'N_5';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::T_SELF] = new ETarget(1, lang('general.self_target'));
        self::$array[self::T_BLANK] = new ETarget(2, lang('general.blank_target'));
        self::$array[self::T_PARENT] = new ETarget(3, lang('general.parent_target'));
        self::$array[self::T_TOP] = new ETarget(4, lang('general.top_target'));
        self::$array[self::T_FRAMENAME] = new ETarget(5, lang('general.framename_target'));
    }

    /**
     *
     * @tutorial search for ETarget index
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
     * @tutorial get result of the ETarget values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ETarget, ETarget>
     */
    public static function result($search)
    {
        self::values();
        $result = new ETarget(NULL, NULL);
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
     * @tutorial get data values ETarget listed
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