<?php
namespace app\enums;

/**
 *
 * @class app\enums\ESiNo
 *
 * @tutorial clase principal del enumerado ESiNo
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 20/09/2015
 */
class EDateFormat extends AEnum
{

    protected static $array = array();

    const MES_DIA_ANO = 'N_1';

    const MES_DIA_ANO_HORA = 'N_2';

    const MES_DIA_ANO_HORA_SLASH = 'N_3';

    const FORMAT_ABBREVIATED = 'N_4';

    const SOLO_FECHA = 'N_5';

    const SOLO_ANO = 'N_6';

    const SOLO_MES = 'N_7';

    const SOLO_DIA = 'N_8';

    const DIA_MES_ANO_LETTER = 'N_9';

    const DIA_MES = 'N_10';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::MES_DIA_ANO] = new EDateFormat(1, 'dd mm de YYYY');
        self::$array[self::MES_DIA_ANO_HORA] = new EDateFormat(2, 'mm dd de YYYY H:i:s');
        self::$array[self::MES_DIA_ANO_HORA_SLASH] = new EDateFormat(3, 'mm dd de YYYY H:i:s');
        self::$array[self::FORMAT_ABBREVIATED] = new EDateFormat(4, 'mm dd de YYYY H:i:s');
        self::$array[self::SOLO_FECHA] = new EDateFormat(5, 'mm dd de YYYY H:i:s');
        self::$array[self::SOLO_ANO] = new EDateFormat(6, 'mm dd de YYYY H:i:s');
        self::$array[self::SOLO_MES] = new EDateFormat(7, 'mm dd de YYYY H:i:s');
        self::$array[self::SOLO_DIA] = new EDateFormat(8, 'mm dd de YYYY H:i:s');
        self::$array[self::DIA_MES_ANO_LETTER] = new EDateFormat(9, 'mm dd de YYYY H:i:s');
        self::$array[self::DIA_MES] = new EDateFormat(10, 'dd mm');
    }

    /**
     *
     * @tutorial search for ESiNo index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return AEnum
     */
    public static function index($search)
    {
        self::values();
        return self::$array[$search];
    }

    /**
     *
     * @tutorial get result of the ESiNo values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ESiNo, AEnum>
     */
    public static function result($search)
    {
        self::values();
        $result = new ESiNo(NULL, NULL);
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
     * @tutorial get data values ESiNo listed
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