<?php
namespace app\enums;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 29/11/2016
 */
class ETipoPaquete extends AEnum
{

    protected static $array = array();

    const GRUPAL = 'N_1';

    const PERSONALIZADO = 'N_2';

    const SEMIPERSONALIZADO = 'N_3';

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2017}
     */
    public static function values()
    {
        self::$array[self::GRUPAL] = new ETipoPaquete(1, lang('general.tipo_paquete_grupal'));
        self::$array[self::PERSONALIZADO] = new ETipoPaquete(2, lang('general.tipo_paquete_personalizado'));
        self::$array[self::SEMIPERSONALIZADO] = new ETipoPaquete(3, lang('general.tipo_paquete_semipersonalizado'));
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/02/2017}
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
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2017}
     * @param unknown $search            
     * @return Ambigous <\app\enums\ETipoPaquete, AEnum>
     */
    public static function result($search)
    {
        self::values();
        $result = new ETipoPaquete(NULL, NULL);
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
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2017}
     * @return AEnum
     */
    public static function data()
    {
        self::values();
        return self::$array;
    }
}