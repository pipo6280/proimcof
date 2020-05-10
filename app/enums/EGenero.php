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
class EGenero extends AEnum
{

    protected static $array = array();

    const MALE = 'N_1';

    const FEMALE = 'N_2';

    const COMPANY = 'N_3';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $show            
     * @return void
     */
    public static function values($show = FALSE)
    {
        self::$array[self::MALE] = new EGenero(1, lang('general.male_gender'));
        self::$array[self::FEMALE] = new EGenero(2, lang('general.female_gender'));
        if ($show) {
            self::$array[self::COMPANY] = new EGenero(3, lang('general.company_gender'));
        }
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
     * @return Ambigous <\app\enums\EGenero, EGenero>
     */
    public static function result($search)
    {
        self::values();
        $result = new EGenero(NULL, NULL);
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
     * @tutorial get data values EGenero listed
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