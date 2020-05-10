<?php
namespace app\enums;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 18, 2016
 */
class ETipoPublicacion extends AEnum
{

    protected static $array = array();

    const TEXTO = 'N_1';

    const TEXTO_IMAGEN = 'N_2';

    const TEXTO_VIDEO = 'N_3';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    public static function values()
    {
        self::$array[self::TEXTO] = new ETipoPublicacion(1, lang('general.publicacion_texto'));
        self::$array[self::TEXTO_IMAGEN] = new ETipoPublicacion(2, lang('general.publicacion_texto_imagen'));
        self::$array[self::TEXTO_VIDEO] = new ETipoPublicacion(3, lang('general.publicacion_texto_video'));
    }

    /**
     *
     * @tutorial search for ETipoPublicacion index
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
     * @tutorial get result of the ETipoPublicacion values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ETipoPublicacion, ETipoPublicacion>
     */
    public static function result($search)
    {
        self::values();
        $result = new ETipoPublicacion(NULL, NULL);
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
     * @tutorial get data values ETipoPublicacion listed
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