<?php
namespace system\Core;

use Doctrine\DBAL\Logging\EchoSQLLogger;
use system\Support\Util;
use app\enums\EInstruccion;
use system\Support\Arr;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since {24/09/2016}
 */
class Doctrine
{

    private static $conexion = null;

    private static $config = null;

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {24/04/2014}
     */
    public function __construct()
    {
        try {
            $params = include EM_APPPATH . 'config/database.php';
            $config = new \Doctrine\DBAL\Configuration();
            global $connectionParams;
            $connectionParams = array(
                'driver' => $params['dbdriver'],
                'host' => $params['hostname'],
                'user' => $params['username'],
                'password' => $params['password'],
                'dbname' => $params['database'],
                'charset' => $params['charset'],
                'driverOptions' => array(
                    1002 => 'SET NAMES utf8'
                )
            );
            $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
            $logger = new EchoSQLLogger();
            $config->setSQLLogger($logger);
            self::$conexion = $conn;
            self::$config = $config;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function beginTransaction()
    {
        Doctrine::$conexion->beginTransaction();
    }

    public static function prepare($statement)
    {
        return Doctrine::$conexion->prepare($statement);
    }

    public static function commit()
    {
        Doctrine::$conexion->commit();
    }

    public static function rollBack()
    {
        Doctrine::$conexion->rollBack();
    }

    public static function close()
    {
        Doctrine::$conexion->close();
    }

    public static function exec($statement)
    {
        Doctrine::$conexion->exec($statement);
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param unknown $tableExpression            
     * @param array $data            
     * @param string $log            
     * @param array $types            
     * @throws Exception
     * @return number
     */
    public static function insert($tableExpression, array $data, $log = TRUE, array $types = array())
    {
        try {
            $result = FALSE;
            $result = Doctrine::$conexion->insert($tableExpression, $data, $types);
            $lastInsert = Doctrine::$conexion->lastInsertId();
            if ($result != 0 && $log) {
                Doctrine::$conexion->insert('auditoria', [
                    'instruccion' => EInstruccion::index(EInstruccion::INSERT)->getId(),
                    'id_usuario' => Util::userSessionDto()->getIdUsuario(),
                    'descripcion' => "Insert {$tableExpression} data:" . var_export($data, TRUE),
                    'nombre_tabla' => $tableExpression,
                    'id_registro' => ($lastInsert > 0 ? $lastInsert : NULL),
                    'direccion_ip' => ipAddress()
                ]);
            }
            if ($result > 0 && $lastInsert > 0) {
                $result = $lastInsert;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param unknown $tableExpression            
     * @param array $data            
     * @param array $identifier            
     * @param array $types            
     * @param string $log            
     * @throws Exception
     * @return number
     */
    public static function update($tableExpression, array $data, array $identifier, $log = TRUE, array $types = array())
    {
        try {
            $result = Doctrine::$conexion->update($tableExpression, $data, $identifier, $types);
            if ($result != 0 && $log) {
                Doctrine::$conexion->insert('auditoria', [
                    'instruccion' => EInstruccion::index(EInstruccion::UPDATE)->getId(),
                    'id_usuario' => Util::userSessionDto()->getIdUsuario(),
                    'descripcion' => "Update {$tableExpression} data:" . var_export($data, TRUE),
                    'nombre_tabla' => $tableExpression,
                    'id_registro' => current($identifier),
                    'direccion_ip' => ipAddress()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param unknown $tableExpression            
     * @param array $identifier            
     * @param array $types            
     * @param string $log            
     * @throws Exception
     * @return number
     */
    public static function delete($tableExpression, array $identifier, $log = TRUE, array $types = array())
    {
        try {
            $result = Doctrine::$conexion->delete($tableExpression, $identifier, $types);
            if ($result > 0 && $log) {
                $identifier = Arr::values($identifier);
                $identifier = Arr::current($identifier);
                return Doctrine::$conexion->insert('auditoria', [
                    'instruccion' => EInstruccion::index(EInstruccion::DELETE)->getId(),
                    'id_usuario' => Util::userSessionDto()->getIdUsuario(),
                    'descripcion' => "Delete {$tableExpression} data:row({$identifier})",
                    'nombre_tabla' => $tableExpression,
                    'id_registro' => $identifier,
                    'direccion_ip' => ipAddress()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/09/2016}
     */
    public static function getConexion()
    {
        return Doctrine::$conexion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/09/2016}
     */
    public static function getConfig()
    {
        return Doctrine::$config;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/09/2016}
     * @param \Doctrine\DBAL\Connection $conexion            
     */
    public static function setConexion($conexion)
    {
        Doctrine::$conexion = $conexion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/09/2016}
     * @param \Doctrine\DBAL\Configuration $config            
     */
    public static function setConfig($config)
    {
        Doctrine::$config = $config;
    }
}