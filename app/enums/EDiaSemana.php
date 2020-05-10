<?php
namespace app\enums;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {21/01/2017}
 */
class EDiaSemana extends AEnum
{

    protected static $array = array();

    const LUNES = 'N_1';

    const MARTES = 'N_2';

    const MIERCOLES = 'N_3';

    const JUEVES = 'N_4';

    const VIERNES = 'N_5';

    const SABADO = 'N_6';

    const DOMINGO = 'N_7';


    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/01/2017}
     */
    protected static function values()
    {
        static::$array[static::LUNES] = new EDiaSemana(1, lang('general.lunes'));
        static::$array[static::MARTES] = new EDiaSemana(2, lang('general.martes'));
        static::$array[static::MIERCOLES] = new EDiaSemana(3, lang('general.miercoles'));
        static::$array[static::JUEVES] = new EDiaSemana(4, lang('general.jueves'));
        static::$array[static::VIERNES] = new EDiaSemana(5, lang('general.viernes'));
        static::$array[static::SABADO] = new EDiaSemana(6, lang('general.sabado'));
        static::$array[static::DOMINGO] = new EDiaSemana(7, lang('general.domingo'));
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/01/2017}
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
     * @since {21/01/2017}
     * @param unknown $search
     * @return Ambigous <\app\enums\EDiaSemana, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new EDiaSemana(NULL, NULL);
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
     * @since {21/01/2017}
     * @return multitype:
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}