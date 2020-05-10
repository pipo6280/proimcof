<?php
use system\Routing\Router;
use system\Core\Benchmark;
use system\Core\Security;
use system\Core\Doctrine;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Config;
use system\Core\Output;
use system\Routing\Uri;
use system\Support\Str;
use system\Support\Arr;
use system\Core\Utf8;
use system\Core\Input;
use system\Core\Message;

set_error_handler('_error_handler');
set_exception_handler('_exception_handler');
register_shutdown_function('_shutdown_handler');

try {
    Benchmark::mark('total_execution_time_start');
    Benchmark::mark('loading_time:_base_classes_start');
    
    $charset = Str::lower(config_item('charset'));
    ini_set('default_charset', $charset);
    if (extension_loaded('mbstring')) {
        define('MB_ENABLED', TRUE);
        @ini_set('mbstring.internal_encoding', $charset);
        mb_substitute_character('none');
    }
    if (extension_loaded('iconv')) {
        define('ICONV_ENABLED', TRUE);
        @ini_set('iconv.internal_encoding', $charset);
    }
    date_default_timezone_set(config_item('time_reference'));
    
    $config = Config::instance();
    $utf8 = Utf8::instance();
    $uri = Uri::instance();
    $router = Router::instance();
    $outPut = Output::instance();
    
    Security::instance();
    Input::instance();
    Str::instance();
    Util::instance();
    
    // system\Session\Session::destroy();
    system\Session\Session::_sess_run();
    
    // time expiration cache
    $outPut->setCacheExpiration(0);
    if ($outPut->cache() === TRUE) {
        exit();
    }
    // Se instancia doctrine
    new Doctrine();
    
    $class = $router->getClass();
    $directory = $router->getDirectory();
    $method = $router->getMethod();
    $class = str_replace([
        '{0}',
        '{1}'
    ], [
        $directory,
        $class
    ], 'app\controllers\{0}{1}Controller');
    $error = FALSE;
    if (Util::isVacio($class) || ! Util::fileExists($class)) {
        if (! class_exists($class, TRUE) || $method[0] === '_' || method_exists('Controller', $method)) {
            $error = TRUE;
        } elseif (method_exists($class, '_reallocation')) {
            Lang::instance()->load('general');
            $params = array(
                $method,
                array_slice($uri->rsegments, 2)
            );
            $method = '_reallocation';
        } elseif (! Arr::inArray(strtolower($method), array_map('strtolower', get_class_methods($class)), TRUE)) {
            $error = TRUE;
        }
    }
    if ($error === TRUE) {
        show_404($router->getDirectory() . $router->getClass() . '/' . $method);
    }
    if ($method !== '_reallocation') {
        $params = array_slice($uri->rsegments, 2);
    }
    Benchmark::mark('controller_execution_time_( ' . $class . ' / ' . $method . ' )_start');
    $controller = new $class();
    call_user_func_array(array(
        &$controller,
        $method
    ), $params);
    Benchmark::mark('controller_execution_time_( ' . $class . ' / ' . $method . ' )_end');
    $outPut->display();
    Message::clean();
} catch (\Exception $e) {
    foreach ($e->getTrace() as $tra) {
        if (! Arr::isNullArray('file', $tra)) {
            log_message('error', $tra['function'] . ": " . $tra['file'] . ' Line: ' . $tra['line']);
        }
    }
    show_error($e->getMessage());
}