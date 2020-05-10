<?php
namespace system\Core;

use system\Support\Util;
use system\Support\Arr;
use system\Support\Str;
use system\Session\Session;

class Persistir
{

    public static function postADto($objeto)
    {
        $var = NULL;
        $value = NULL;
        $array = Input::instance()->getRequest(TRUE);
        $files = static::files();
        
        foreach ($array as $var) {
            $metodos = '';
            $tempo = $var;
            $var = Arr::explode($var, '-');
            $indexVal = $var[Arr::count($var) - 1];
            $cantidad = Arr::count($var) - 1;
            $value = Input::instance()->getPost($tempo);
            if (Input::instance()->getPost($tempo) == 0 || Input::instance()->getPost($tempo) && Str::substr($var[0], 0, 3) == 'txt') {
                $obj = $objeto;
                for ($i = 0; $i < $cantidad; $i ++) {
                    $metodos = Str::replaceWord('txt', 'get', $var[$i]);
                    if (method_exists($obj, $metodos)) {
                        $obj = $obj->$metodos();
                    }
                }
                $llamada = Str::replaceWord('txt', 'set', $indexVal);
                if (! Util::isVacio($value) && method_exists($obj, $llamada)) {
                    $obj->$llamada($value);
                }
            }
            unset($cantidad);
            unset($tempo);
            unset($metodos);
        }
        foreach ($files as $key => $f) {
            if (substr($key, 0, 4) == 'File') {
                if (! Arr::isNullArray($key, $files) && ! Util::isVacio($f['tmp_name'])) {
                    $file = new Files();
                    $virus = NULL;
                    $retcode = NULL;
                    if (! defined('CL_VIRUS')) {
                        define('CL_VIRUS', NULL);
                    }
                    if (function_exists('cl_scanfile')) {
                        $retcode = cl_scanfile($f['tmp_name'], $virus);
                    } else {
                        $virus = NULL;
                        $retcode = 'valido';
                    }
                    
                    if (CL_VIRUS != $retcode) {
                        $retorna = $file->addUpload($f);
                        if ($retorna) {
                            $llamada = Str::replaceWord('File', 'set', $key);
                            if (method_exists($objeto, $llamada)) {
                                $objeto->$llamada($file);
                            }
                        }
                    } else {
                        unlink($f['tmp_name']);
                        Message::addError(NULL, 'EL ARCHIVO QUE DESEA AGREGAR ES UN VIRUS ' . cl_pretcode($retcode) . " Virus found name : " . $virus);
                    }
                }
                unset($atributo);
            }
        }
        unset($array);
        unset($value);
        unset($var);
    }

    public static function addDto($dto, $prefijo = NULL, $sufijo = NULL, $conPrefijo = TRUE)
    {
        $files = static::files();
        $metodos = get_class_methods($dto);
        $prefijo = Util::isVacio($prefijo) ? 'set' : $prefijo;
        $sufijo = Util::isVacio($sufijo) ? 'txt' : $sufijo;
        if (! $conPrefijo) {
            $sufijo = '';
        }
        $temporal = NULL;
        foreach ($metodos as $metodo) {
            $temporal = Str::replaceWord($prefijo, $sufijo, $metodo);
            if (! $conPrefijo) {
                $temporal = Str::lower($temporal);
            }
            if (static::getParam($temporal) != NULL) {
                $dto->$metodo(static::getParam($temporal));
            }
        }
        
        foreach ($files as $key => $f) {
            if (substr($key, 0, 4) == 'File') {
                $tempT = Str::lower(substr($key, 4, 1)) . substr($key, 5);
                if (! Arr::isNullArray($key, $files) && ! Util::isVacio($f['tmp_name'])) {
                    $file = new Files();
                    $virus = NULL;
                    $retcode = NULL;
                    if (! defined('CL_VIRUS')) {
                        define('CL_VIRUS', NULL);
                    }
                    if (function_exists('cl_scanfile')) {
                        $retcode = cl_scanfile($f['tmp_name'], $virus);
                    } else {
                        $virus = NULL;
                        $retcode = 'valido';
                    }
                    
                    if (CL_VIRUS != $retcode) {
                        $retorna = $file->addUpload($f);
                        if ($retorna) {
                            $dto->$tempT = $file;
                        }
                    } else {
                        unlink($f['tmp_name']);
                        Message::addError(NULL, 'EL ARCHIVO QUE DESEA AGREGAR ES UN VIRUS ' . cl_pretcode($retcode) . " Virus found name : " . $virus);
                    }
                }
                unset($atributo);
            }
        }
        unset($reflection);
        unset($temp);
        unset($key);
        unset($val);
    }

    public static function dtoArray($array, $dto)
    {
        $objeto = NULL;
        if (Util::isString($dto)) {
            $objeto = new $dto();
        } else 
            if (Util::isObject($dto)) {
                $class = get_class($dto);
                $objeto = new $class();
                unset($class);
            }
        
        foreach ($array as $key => $var) {
            if (! empty($var)) {
                $objeto->{$key} = $var;
            }
        }
        unset($array);
        unset($key);
        unset($var);
        return $objeto;
    }

    public static function arrayDto($objeto, $array, $formato = '24')
    {
        foreach ($array as $key => $var) {
            if (! Util::isNumeric($key)) {
                if ($var instanceof \DateTime) {
                    $key = 'set' . Str::ucwords($key);
                    if (method_exists($objeto, $key)) {
                        if (! empty($var)) {
                            $fecha = $var->format('Y-m-d H:i:s');
                            if (Str::strrpos($fecha, ' 00:00:00') === FALSE) {
                                $fecha = $var->format('Y-m-d ' . ($formato == 12 ? ' h' : 'H') . ':i:s' . ($formato == 12 ? ' A' : ''));
                            }
                            
                            $fecha = Str::strReplace(array(
                                ' 00:00:00',
                                '0000-00-00'
                            ), '', $fecha);
                            $objeto->{$key}($fecha);
                        }
                    }
                } else {
                    $key = 'set' . Str::ucwords($key);
                    if (method_exists($objeto, $key)) {
                        if (! empty($var)) {
                            $objeto->{$key}($var);
                        }
                    }
                }
            }
        }
        unset($key);
        unset($var);
    }

    public static function getParam($param)
    {
        $request = static::request();
        if (! Arr::isNullArray($param, $request)) {
            return $request[$param];
        }
        return NULL;
    }

    public static function setParam($name, $param)
    {
        $_REQUEST[$name] = $param;
    }

    public static function exits($name)
    {
        return ! Arr::isNullArray($name, $_REQUEST);
    }

    public static function files()
    {
        return $_FILES;
    }

    public static function setSession($name, $param)
    {
        Session::setData($name, $param);
    }

    public static function getSession($name)
    {
        return Session::getData($name);
    }

    protected static function request()
    {
        return Arr::arrayMerge($_REQUEST, Arr::arrayMerge($_POST, $_GET));
    }
}