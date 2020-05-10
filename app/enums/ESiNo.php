<?php
namespace app\enums;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 17, 2016
 */
class ESiNo extends AEnum
{

    protected static $array = array();

    const SI = 'N_1';

    const NO = 'N_2';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    protected static function values()
    {
        static::$array[static::SI] = new ESiNo(1, lang('general.esino_si'));
        static::$array[static::NO] = new ESiNo(2, lang('general.esino_no'));
    }

    /**
     *
     * @tutorial search for ESiNo index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return array
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     *
     * @tutorial get result of the ESiNo values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ESiNo, ESiNo>
     */
    public static function result($search)
    {
        static::values();
        $result = new ESiNo(NULL, NULL);
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
     * @tutorial get data values ESiNo listed
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