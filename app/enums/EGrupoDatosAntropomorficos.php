<?php
namespace app\enums;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {18/12/2016}
 */
class EGrupoDatosAntropomorficos extends AEnum
{

    protected static $array = array();

    const PESO = 'N_1';

    const IMC = 'N_2';

    const PORCENTAJE_GRASA = 'N_3';

    const PORCENTAJE_MUSCULO = 'N_4';

    const TECUMSEH = 'N_5';

    const SEAT_REACH = 'N_6';

    //const MONTGOMERY = 'N_7';

    const PUSH_UP = 'N_8';

    const PUENTE_PRONTO = 'N_9';

    //const FC_ZONA_AEROBICA = 'N_10';

    //const TENSION_ARTERIAL = 'N_11';

    //const FC_INICIO = 'N_12';

    const F_RESPIRATORIA = 'N_13';

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/12/2016}
     */
    protected static function values()
    {
        static::$array[static::PESO] = new EGrupoDatosAntropomorficos(1, lang('general.peso'), 'getPeso', 'rgba(33,150,243,0.5)');
        static::$array[static::IMC] = new EGrupoDatosAntropomorficos(2, lang('general.imc'), 'getIMC', 'rgba(0,150,136,0.5)');
        static::$array[static::PORCENTAJE_GRASA] = new EGrupoDatosAntropomorficos(3, lang('general.porcentaje_grasa'), 'getPorcentaje_grasa', 'rgba(238,110,115,0.5)');
        static::$array[static::PORCENTAJE_MUSCULO] = new EGrupoDatosAntropomorficos(4, lang('general.porcentaje_musculo'), 'getPorcentaje_musculo', 'rgba(144,164,174,0.5)');
        static::$array[static::TECUMSEH] = new EGrupoDatosAntropomorficos(5, lang('general.tecumseh'), 'getTecumseh', 'rgba(63,81,181,0.5)');
        static::$array[static::SEAT_REACH] = new EGrupoDatosAntropomorficos(6, lang('general.seat_reach'), 'getSeat_reach', 'rgba(33,150,243,0.5)');
        //static::$array[static::MONTGOMERY] = new EGrupoDatosAntropomorficos(7, lang('general.montgomery'), 'getMontgomery', 'rgba(0,150,136,0.5)');
        static::$array[static::PUSH_UP] = new EGrupoDatosAntropomorficos(8, lang('general.push_up'), 'getPush_up', 'rgba(238,110,115,0.5)');
        static::$array[static::PUENTE_PRONTO] = new EGrupoDatosAntropomorficos(9, lang('general.puente_pronto'), 'getPuente_pronto', 'rgba(144,164,174,0.5)');
        //static::$array[static::FC_ZONA_AEROBICA] = new EGrupoDatosAntropomorficos(10, lang('general.frecuencia_cardiaca_zona_aerobica'), 'getFrecuencia_cardiaca_zona_aerobica', 'rgba(63,81,181,0.5)');
        //static::$array[static::TENSION_ARTERIAL] = new EGrupoDatosAntropomorficos(11, lang('general.tension_arterial'), 'getTension_arterial', 'rgba(33,150,243,0.5)');
        //static::$array[static::FC_INICIO] = new EGrupoDatosAntropomorficos(12, lang('general.frecuencia_cardiaca_inicio'), 'getFrecuencia_cardiaca_inicio', 'rgba(0,150,136,0.5)');
        static::$array[static::F_RESPIRATORIA] = new EGrupoDatosAntropomorficos(13, lang('general.frecuencia_respiratoria'), 'getFrecuencia_respiratoria', 'rgba(238,110,115,0.5)');
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/12/2016}
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
     * @since {18/12/2016}
     * @param unknown $search            
     * @return Ambigous <\app\enums\EGrupoDatosAntropomorficos, unknown>
     */
    public static function result($search)
    {
        static::values();
        $result = new EGrupoDatosAntropomorficos(NULL, NULL);
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
     * @since {18/12/2016}
     * @return multitype:
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}