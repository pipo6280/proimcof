<?php
namespace app\enums;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {4/12/2016}
 */
class EDuracionPaquete extends AEnum
{

    protected static $array = array();

    const DIA = 'N_1';

    const SEMANA = 'N_2';

    const MES = 'N_3';

    const BIMESTRE = 'N_4';

    const CUATRIMESTRE = 'N_5';

    const TRIMESTRE = 'N_6';

    const SEMESTRE = 'N_7';

    const ANUAL = 'N_8';

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/12/2016}
     */
    protected static function values()
    {
        static::$array[static::DIA] = new EDuracionPaquete(1, lang('general.paquete_dia'), ['d' => 1]);
        static::$array[static::SEMANA] = new EDuracionPaquete(2, lang('general.paquete_semana'), ['d' => 8]);
        static::$array[static::MES] = new EDuracionPaquete(3, lang('general.paquete_mes'), ['m' => 1]);
        static::$array[static::BIMESTRE] = new EDuracionPaquete(4, lang('general.paquete_bimestre'), ['m' => 2]);
        static::$array[static::TRIMESTRE] = new EDuracionPaquete(5, lang('general.paquete_trimestre'), ['m' => 3]);
        static::$array[static::CUATRIMESTRE] = new EDuracionPaquete(6, lang('general.paquete_cuatrimestre'), ['m' => 4]);
        static::$array[static::SEMESTRE] = new EDuracionPaquete(7, lang('general.paquete_semestre'), ['m' => 6]);
        static::$array[static::ANUAL] = new EDuracionPaquete(8, lang('general.paquete_anual'), ['Y' => 1]);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/12/2016}
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
     * @since {4/12/2016}
     * @param unknown $search            
     * @return Ambigous <\app\enums\EPerfil, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new EDuracionPaquete(NULL, NULL);
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
     * @since {4/12/2016}
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}