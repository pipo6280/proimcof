<?php
namespace system\Core;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 15/03/2015
 */
abstract class Singleton
{

    private static $_instances = array();

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/03/2015
     * @throws \Exception
     */
    public function __construct()
    {
        if (array_key_exists(get_called_class(), self::$_instances)) {
            throw new \Exception('Already one instance of ' . get_called_class());
        }
        static::initialize();
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @return multitype:
     */
    final public static function instance()
    {
        $class = get_called_class();
        if (! array_key_exists($class, self::$_instances)) {
            self::$_instances[$class] = new $class();
            log_message('info', $class, 'Initialized');
        }
        return self::$_instances[$class];
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/03/2015
     * @throws \Exception
     */
    final public function __clone()
    {
        throw new \Exception('Class type ' . get_called_class() . ' cannot be cloned');
    }
}