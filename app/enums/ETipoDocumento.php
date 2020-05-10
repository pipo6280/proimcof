<?php
namespace app\enums;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 29/11/2016
 */
class ETipoDocumento extends AEnum
{

    protected static $array = array();

    const TARJETA_IDENTIDAD = 'N_1';

    const CEDULA_CIUDADANIA = 'N_2';

    const CEDULA_EXTRANJERIA = 'N_3';

    const REGISTRO_CIVIL = 'N_4';

    const NUIP = 'N_5';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::TARJETA_IDENTIDAD] = new ETipoDocumento(1, lang('general.tipo_documento_ti'));
        self::$array[self::CEDULA_CIUDADANIA] = new ETipoDocumento(2, lang('general.tipo_documento_cc'));
        self::$array[self::CEDULA_EXTRANJERIA] = new ETipoDocumento(3, lang('general.tipo_documento_ce'));
        self::$array[self::REGISTRO_CIVIL] = new ETipoDocumento(4, lang('general.tipo_documento_rc'));
        self::$array[self::NUIP] = new ETipoDocumento(5, lang('general.tipo_documento_nuip'));
    }

    /**
     *
     * @tutorial search for ETipoDocumento index
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
     * @tutorial get result of the ETipoDocumento values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ETipoDocumento, ETipoDocumento>
     */
    public static function result($search)
    {
        self::values();
        $result = new ETipoDocumento(NULL, NULL);
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
     * @tutorial get data values ETipoDocumento listed
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