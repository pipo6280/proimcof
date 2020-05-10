<?php
namespace app\enums;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 26/11/2016
 */
class EInstruccion extends AEnum
{

    protected static $array = array();

    const INSERT = 'N_1';

    const UPDATE = 'N_2';

    const DELETE = 'N_3';

    const REPLACE = 'N_4';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since 26/11/2016
     * @return void
     */
    protected static function values()
    {
        static::$array[static::INSERT] = new EInstruccion(1, 'Insert');
        static::$array[static::UPDATE] = new EInstruccion(2, 'Update');
        static::$array[static::DELETE] = new EInstruccion(3, 'Delete');
        static::$array[static::REPLACE] = new EInstruccion(4, 'Replace');
    }

    /**
     *
     * @tutorial search for EInstruccion index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since 26/11/2016
     * @param string $search            
     * @return AEnum
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     *
     * @tutorial get result of the EInstruccion values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since 26/11/2016
     * @param string $search            
     * @return Ambigous <\app\enums\EInstruccion, AEnum>
     */
    public static function result($search)
    {
        static::values();
        $result = new EInstruccion(NULL, NULL);
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
     * @tutorial get data values EInstruccion listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since 26/11/2016
     * @return array
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}