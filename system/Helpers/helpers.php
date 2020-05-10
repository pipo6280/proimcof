<?php
use system\Core\Exceptions;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Config;
use system\Support\Arr;
use system\Routing\Uri;
use system\Support\Str;
use system\Log\Log;

if (! function_exists('diff')) {

    function diff(array $items)
    {
        return Arr::diff($items);
    }
}
if (! function_exists('utf8_converter')) {

    /**
     *
     * @tutorial Method Description: convert to utf8_encode
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/08/2016}
     * @param array $array            
     * @return array
     */
    function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key)
        {
            if (! is_object($item) && ! mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        
        return $array;
    }
}

if (! function_exists('upper')) {

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {22/08/2016}
     * @param unknown $value            
     * @return string
     */
    function upper($value)
    {
        return Str::upper($value);
    }
}

if (! function_exists('lower')) {

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {22/08/2016}
     * @param unknown $value            
     * @return string
     */
    function lower($value)
    {
        return Str::lower($value);
    }
}
if (! function_exists('title')) {

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {22/08/2016}
     * @param string $value            
     * @return string
     */
    function title($value)
    {
        return Str::title($value);
    }
}

if (! function_exists('lang')) {

    /**
     *
     * @tutorial Method Description: Fetches a language variable and optionally outputs a form label
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @param string $line            
     * @param array $attributes            
     * @param string $for            
     * @return string
     */
    function lang($line, $attributes = array(), $for = '')
    {
        $attributes = is_array($attributes) ? $attributes : array(
            $attributes
        );
        $line = Lang::instance()->line($line, $attributes);
        if ($for != '') {
            $line = '<label for="' . $for . '"' . _stringify_attributes($attributes) . '>' . $line . '</label>';
        }
        
        return $line;
    }
}
if (! function_exists('ipAddress')) {

    function ipAddress()
    {
        foreach (array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ipAddress) {
                    $ipAddress = trim($ipAddress); // Just to be safe
                    if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ipAddress;
                    }
                }
            }
        }
    }
}

if (! function_exists('_stringify_attributes')) {

    /**
     *
     * @tutorial Method Description: Stringify attributes for use in HTML tags.
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @param array $attributes            
     * @param string $js            
     * @return NULL|string
     */
    function _stringify_attributes($attributes, $js = FALSE)
    {
        $atts = NULL;
        if (empty($attributes)) {
            return $atts;
        }
        if (is_string($attributes)) {
            return ' ' . $attributes;
        }
        $attributes = (array) $attributes;
        foreach ($attributes as $key => $val) {
            $atts .= ($js) ? $key . '=' . $val . ',' : ' ' . $key . '="' . $val . '"';
        }
        return rtrim($atts, ',');
    }
}

if (! function_exists('append_config')) {

    function url_exists($uri)
    {
        return preg_match('#^(\w+:)?//#i', $uri);
    }
}

if (! function_exists('append_config')) {

    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param array $array            
     * @return array
     */
    function append_config(array $array)
    {
        $start = 9999;
        
        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $start ++;
                
                $array[$start] = Arr::pull($array, $key);
            }
        }
        
        return $array;
    }
}

if (! function_exists('array_add')) {

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param array $array            
     * @param string $key            
     * @param mixed $value            
     * @return array
     */
    function array_add($array, $key, $value)
    {
        return Arr::add($array, $key, $value);
    }
}

if (! function_exists('array_build')) {

    /**
     * Build a new array using a callback.
     *
     * @param array $array            
     * @param callable $callback            
     * @return array
     */
    function array_build($array, callable $callback)
    {
        return Arr::build($array, $callback);
    }
}

if (! function_exists('array_collapse')) {

    /**
     * Collapse an array of arrays into a single array.
     *
     * @param array|\ArrayAccess $array            
     * @return array
     */
    function array_collapse($array)
    {
        return Arr::collapse($array);
    }
}

if (! function_exists('array_divide')) {

    /**
     * Divide an array into two arrays.
     * One with keys and the other with values.
     *
     * @param array $array            
     * @return array
     */
    function array_divide($array)
    {
        return Arr::divide($array);
    }
}

if (! function_exists('array_dot')) {

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array $array            
     * @param string $prepend            
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        return Arr::dot($array, $prepend);
    }
}

if (! function_exists('array_except')) {

    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param array $array            
     * @param array|string $keys            
     * @return array
     */
    function array_except($array, $keys)
    {
        return Arr::except($array, $keys);
    }
}

if (! function_exists('array_fetch')) {

    /**
     * Fetch a flattened array of a nested array element.
     *
     * @param array $array            
     * @param string $key            
     * @return array
     *
     * @deprecated since version 5.1. Use array_pluck instead.
     */
    function array_fetch($array, $key)
    {
        return Arr::fetch($array, $key);
    }
}

if (! function_exists('array_first')) {

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param array $array            
     * @param callable $callback            
     * @param mixed $default            
     * @return mixed
     */
    function array_first($array, callable $callback, $default = null)
    {
        return Arr::first($array, $callback, $default);
    }
}

if (! function_exists('array_last')) {

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param array $array            
     * @param callable $callback            
     * @param mixed $default            
     * @return mixed
     */
    function array_last($array, $callback, $default = null)
    {
        return Arr::last($array, $callback, $default);
    }
}

if (! function_exists('array_flatten')) {

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array            
     * @return array
     */
    function array_flatten($array)
    {
        return Arr::flatten($array);
    }
}

if (! function_exists('array_forget')) {

    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param array $array            
     * @param array|string $keys            
     * @return void
     */
    function array_forget(&$array, $keys)
    {
        return Arr::forget($array, $keys);
    }
}

if (! function_exists('array_get')) {

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array            
     * @param string $key            
     * @param mixed $default            
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if (! function_exists('array_has')) {

    /**
     * Check if an item exists in an array using "dot" notation.
     *
     * @param array $array            
     * @param string $key            
     * @return bool
     */
    function array_has($array, $key)
    {
        return Arr::has($array, $key);
    }
}

if (! function_exists('array_only')) {

    /**
     * Get a subset of the items from the given array.
     *
     * @param array $array            
     * @param array|string $keys            
     * @return array
     */
    function array_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (! function_exists('array_pluck')) {

    /**
     * Pluck an array of values from an array.
     *
     * @param array $array            
     * @param string $value            
     * @param string $key            
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}

if (! function_exists('array_pull')) {

    /**
     * Get a value from the array, and remove it.
     *
     * @param array $array            
     * @param string $key            
     * @param mixed $default            
     * @return mixed
     */
    function array_pull(&$array, $key, $default = null)
    {
        return Arr::pull($array, $key, $default);
    }
}

if (! function_exists('array_set')) {

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param array $array            
     * @param string $key            
     * @param mixed $value            
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        return Arr::set($array, $key, $value);
    }
}

if (! function_exists('array_sort')) {

    /**
     * Sort the array using the given callback.
     *
     * @param array $array            
     * @param callable $callback            
     * @return array
     */
    function array_sort($array, callable $callback)
    {
        return Arr::sort($array, $callback);
    }
}

if (! function_exists('array_sort_recursive')) {

    /**
     * Recursively sort an array by keys and values.
     *
     * @param array $array            
     * @return array
     */
    function array_sort_recursive($array)
    {
        return Arr::sortRecursive($array);
    }
}

if (! function_exists('array_where')) {

    /**
     * Filter the array using the given callback.
     *
     * @param array $array            
     * @param callable $callback            
     * @return array
     */
    function array_where($array, callable $callback)
    {
        return Arr::where($array, $callback);
    }
}

if (! function_exists('camel_case')) {

    /**
     * Convert a value to camel case.
     *
     * @param string $value            
     * @return string
     */
    function camel_case($value)
    {
        return Str::camel($value);
    }
}

if (! function_exists('class_basename')) {

    /**
     * Get the class "basename" of the given object / class.
     *
     * @param string|object $class            
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        
        return basename(str_replace('\\', '/', $class));
    }
}

if (! function_exists('class_uses_recursive')) {

    /**
     * Returns all traits used by a class, its subclasses and trait of their traits.
     *
     * @param string $class            
     * @return array
     */
    function class_uses_recursive($class)
    {
        $results = [];
        
        foreach (array_merge([
            $class => $class
        ], class_parents($class)) as $class) {
            $results += trait_uses_recursive($class);
        }
        
        return array_unique($results);
    }
}

if (! function_exists('data_get')) {

    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param mixed $target            
     * @param string|array $key            
     * @param mixed $default            
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }
        
        $key = is_array($key) ? $key : explode('.', $key);
        
        foreach ($key as $segment) {
            if (is_array($target)) {
                if (! array_key_exists($segment, $target)) {
                    return value($default);
                }
                
                $target = $target[$segment];
            } elseif ($target instanceof ArrayAccess) {
                if (! isset($target[$segment])) {
                    return value($default);
                }
                
                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (! isset($target->{$segment})) {
                    return value($default);
                }
                
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }
        
        return $target;
    }
}

if (! function_exists('ends_with')) {

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack            
     * @param string|array $needles            
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        return Str::endsWith($haystack, $needles);
    }
}

if (! function_exists('head')) {

    /**
     * Get the first element of an array.
     * Useful for method chaining.
     *
     * @param array $array            
     * @return mixed
     */
    function head($array)
    {
        return reset($array);
    }
}

if (! function_exists('last')) {

    /**
     * Get the last element from an array.
     *
     * @param array $array            
     * @return mixed
     */
    function last($array)
    {
        return end($array);
    }
}

if (! function_exists('object_get')) {

    /**
     * Get an item from an object using "dot" notation.
     *
     * @param object $object            
     * @param string $key            
     * @param mixed $default            
     * @return mixed
     */
    function object_get($object, $key, $default = null)
    {
        if (is_null($key) || trim($key) == '') {
            return $object;
        }
        
        foreach (explode('.', $key) as $segment) {
            if (! is_object($object) || ! isset($object->{$segment})) {
                return value($default);
            }
            
            $object = $object->{$segment};
        }
        
        return $object;
    }
}

if (! function_exists('preg_replace_sub')) {

    /**
     * Replace a given pattern with each value in the array in sequentially.
     *
     * @param string $pattern            
     * @param array $replacements            
     * @param string $subject            
     * @return string
     */
    function preg_replace_sub($pattern, &$replacements, $subject)
    {
        return preg_replace_callback($pattern, function ($match) use(&$replacements)
        {
            foreach ($replacements as $key => $value) {
                return array_shift($replacements);
            }
        }, $subject);
    }
}

if (! function_exists('snake_case')) {

    /**
     * Convert a string to snake case.
     *
     * @param string $value            
     * @param string $delimiter            
     * @return string
     */
    function snake_case($value, $delimiter = '_')
    {
        return Str::snake($value, $delimiter);
    }
}

if (! function_exists('starts_with')) {

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack            
     * @param string|array $needles            
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        return Str::startsWith($haystack, $needles);
    }
}

if (! function_exists('str_contains')) {

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string $haystack            
     * @param string|array $needles            
     * @return bool
     */
    function str_contains($haystack, $needles)
    {
        return Str::contains($haystack, $needles);
    }
}

if (! function_exists('str_finish')) {

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param string $value            
     * @param string $cap            
     * @return string
     */
    function str_finish($value, $cap)
    {
        return Str::finish($value, $cap);
    }
}

if (! function_exists('str_is')) {

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param string $pattern            
     * @param string $value            
     * @return bool
     */
    function str_is($pattern, $value)
    {
        return Str::is($pattern, $value);
    }
}

if (! function_exists('str_limit')) {

    /**
     * Limit the number of characters in a string.
     *
     * @param string $value            
     * @param int $limit            
     * @param string $end            
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        return Str::limit($value, $limit, $end);
    }
}

if (! function_exists('str_plural')) {

    /**
     * Get the plural form of an English word.
     *
     * @param string $value            
     * @param int $count            
     * @return string
     */
    function str_plural($value, $count = 2)
    {
        return Str::plural($value, $count);
    }
}

if (! function_exists('str_random')) {

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length            
     * @return string
     *
     * @throws \RuntimeException
     */
    function str_random($length = 16)
    {
        return Str::random($length);
    }
}

if (! function_exists('str_replace_array')) {

    /**
     * Replace a given value in the string sequentially with an array.
     *
     * @param string $search            
     * @param array $replace            
     * @param string $subject            
     * @return string
     */
    function str_replace_array($search, array $replace, $subject)
    {
        foreach ($replace as $value) {
            $subject = preg_replace('/' . $search . '/', $value, $subject, 1);
        }
        
        return $subject;
    }
}

if (! function_exists('str_singular')) {

    /**
     * Get the singular form of an English word.
     *
     * @param string $value            
     * @return string
     */
    function str_singular($value)
    {
        return Str::singular($value);
    }
}

if (! function_exists('str_slug')) {

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $title            
     * @param string $separator            
     * @return string
     */
    function str_slug($title, $separator = '-')
    {
        return Str::slug($title, $separator);
    }
}

if (! function_exists('studly_case')) {

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value            
     * @return string
     */
    function studly_case($value)
    {
        return Str::studly($value);
    }
}

if (! function_exists('title_case')) {

    /**
     * Convert a value to title case.
     *
     * @param string $value            
     * @return string
     */
    function title_case($value)
    {
        return Str::title($value);
    }
}

if (! function_exists('trait_uses_recursive')) {

    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param string $trait            
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait);
        
        foreach ($traits as $trait) {
            $traits += trait_uses_recursive($trait);
        }
        
        return $traits;
    }
}

if (! function_exists('value')) {

    /**
     * Return the default value of the given value.
     *
     * @param mixed $value            
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('with')) {

    /**
     * Return the given object.
     * Useful for chaining.
     *
     * @param mixed $object            
     * @return mixed
     */
    function with($object)
    {
        return $object;
    }
}

if (! function_exists('config_path')) {

    /**
     * Get the configuration path.
     *
     * @param string $path            
     * @return string
     */
    function config_path($path = '')
    {
        return config_item('base_url') . $path;
    }
}
if (! function_exists('log_message')) {

    function log_message($level, $message, $extra = '')
    {
        static $_log;
        
        if ($_log === NULL) {
            // references cannot be directly assigned to static variables, so we use an array
            $_log[0] = Log::instance();
        }
        
        $_log[0]->write($level, $message, $extra);
    }
}

if (! function_exists('_error_handler')) {

    /**
     * Error Handler
     *
     * This is the custom error handler that is declared at the (relative)
     * top of CodeIgniter.php. The main reason we use this is to permit
     * PHP errors to be logged in our own log files since the user may
     * not have access to server logs. Since this function effectively
     * intercepts PHP errors, however, we also need to display errors
     * based on the current error_reporting level.
     * We do that with the use of a PHP error template.
     *
     * @param int $severity            
     * @param string $message            
     * @param string $filePath            
     * @param int $line            
     * @return void
     */
    function _error_handler($severity, $message, $filePath, $line)
    {
        $isError = (((E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);
        if ($isError) {
            set_status_header(500);
        }
        if (($severity & error_reporting()) !== $severity) {
            return;
        }
        $error = Exceptions::instance();
        $error->logException($severity, $message, $filePath, $line);
        if (str_ireplace(array(
            'off',
            'none',
            'no',
            'false',
            'null'
        ), '', ini_get('display_errors'))) {
            $error->showPhpError($severity, $message, $filePath, $line);
        }
        if ($isError) {
            exit(1);
        }
    }
}

if (! function_exists('show_404')) {

    function show_404($page = '', $logError = TRUE)
    {
        $error = Exceptions::instance();
        $error->showPage404($page, $logError);
        exit(4);
    }
}

if (! function_exists('_exception_handler')) {

    function _exception_handler($exception)
    {
        $error = Exceptions::instance();
        $error->setLogException('error', 'Exception: ' . $exception->getMessage(), $exception->getFile(), $exception->getLine());
        if (str_ireplace(array(
            'off',
            'none',
            'no',
            'false',
            'null'
        ), '', ini_get('display_errors'))) {
            $error->showException($exception);
        }
        exit(1);
    }
}

if (! function_exists('_shutdown_handler')) {

    function _shutdown_handler()
    {
        $last_error = error_get_last();
        if (isset($last_error) && ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))) {
            _error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }
}

if (! function_exists('set_status_header')) {

    function set_status_header($code = 200, $text = '')
    {
        if (is_cli()) {
            return;
        }
        
        if (empty($code) or ! is_numeric($code)) {
            show_error('Status codes must be numeric', 500);
        }
        
        if (empty($text)) {
            is_int($code) or $code = (int) $code;
            $stati = array(
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                307 => 'Temporary Redirect',
                
                400 => 'Bad Request',
                401 => 'Unauthorized',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported'
            );
            
            if (isset($stati[$code])) {
                $text = $stati[$code];
            } else {
                show_error('No status text available. Please check your status code number or supply your own message text.', 500);
            }
        }
        
        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header('Status: ' . $code . ' ' . $text, TRUE);
        } else {
            $serverProtocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($serverProtocol . ' ' . $code . ' ' . $text, TRUE, $code);
        }
    }
}

if (! function_exists('show_error')) {

    function show_error($message, $statusCode = 500, $heading = ' Un error fue encontrado')
    {
        $statusCode = abs($statusCode);
        if ($statusCode < 100) {
            $exitStatus = $statusCode + 9;
            if ($exitStatus > 125) {
                $exitStatus = 1;
            }
            
            $statusCode = 500;
        } else {
            $exitStatus = 1;
        }
        $error = Exceptions::instance();
        echo $error->showError($heading, $message, 'error_general', $statusCode);
        exit($exitStatus);
    }
}
if (! function_exists('is_really_writable')) {

    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @link https://bugs.php.net/bug.php?id=54709
     * @param
     *            string
     * @return bool
     */
    function is_really_writable($file)
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or ! ini_get('safe_mode'))) {
            return is_writable($file);
        }
        
        /*
         * For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === FALSE) {
                return FALSE;
            }
            
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return TRUE;
        } elseif (! is_file($file) or ($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }
        
        fclose($fp);
        return TRUE;
    }
}
if (! function_exists('microtime_float')) {

    function microtime_float()
    {
        list ($useg, $seg) = explode(" ", microtime());
        return ((float) $useg + (float) $seg);
    }
}

if (! function_exists('config_item')) {

    function config_item($item)
    {
        static $_config;
        if (empty($_config)) {
            $_config[0] = & get_config();
        }
        if ($item == 'language') {
            $session = Util::userSessionDto();
            if ($session) {
                return $session->getLang();
            }
        }
        return isset($_config[0][$item]) ? $_config[0][$item] : NULL;
    }
}

if (! function_exists('get_config')) {

    function &get_config(Array $replace = array())
    {
        static $config;
        
        if (empty($config)) {
            $file_path = EM_APPPATH . 'config/config.php';
            $found = FALSE;
            if (file_exists($file_path)) {
                $found = TRUE;
                require $file_path;
            }
            
            // Is the config file in the environment folder?
            if (file_exists($file_path = EM_APPPATH . 'config/' . ENVIRONMENT . '/config.php')) {
                require ($file_path);
            } elseif (! $found) {
                echo 'The configuration file does not exist.';
                exit(3);
            }
            
            if (! isset($config) or ! Arr::isArray($config)) {
                
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3);
            }
        }
        foreach ($replace as $key => $val) {
            $config[$key] = $val;
        }
        return $config;
    }
}

if (! function_exists('is_cli')) {

    function is_cli()
    {
        return (PHP_SAPI === 'cli' or defined('STDIN'));
    }
}

if (! function_exists('remove_invisible_characters')) {

    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();
        
        // every control character except newline (dec 10),
        // carriage return (dec 13) and horizontal tab (dec 09)
        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/'; // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/'; // url encoded 16-31
        }
        
        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'; // 00-08, 11, 12, 14-31, 127
        
        do {
            $str = preg_replace($non_displayables, '', $str, - 1, $count);
        } while ($count);
        
        return $str;
    }
}

if (! function_exists('is_loaded')) {

    function &is_loaded($class = '')
    {
        static $_is_loaded = array();
        if ($class !== '') {
            $classReal = explode('\\', $class);
            $classReal = mb_strtolower(end($classReal));
            
            $_is_loaded[strtolower($classReal)] = $class;
        }
        return $_is_loaded;
    }
}
if (! function_exists('get_mimes')) {

    /**
     * Returns the MIME types array from config/mimes.php
     *
     * @return array
     */
    function &get_mimes()
    {
        static $_mimes;
        
        if (empty($_mimes)) {
            if (file_exists(EM_APPPATH . 'config/' . ENVIRONMENT . '/mimes.php')) {
                $_mimes = include (EM_APPPATH . 'config/' . ENVIRONMENT . '/mimes.php');
            } elseif (file_exists(EM_APPPATH . 'config/mimes.php')) {
                $_mimes = include (EM_APPPATH . 'config/mimes.php');
            } else {
                $_mimes = array();
            }
        }
        return $_mimes;
    }
}
if (! function_exists('is_https')) {

    function is_https()
    {
        if (! empty($_SERVER['HTTPS']) && mb_strtolower($_SERVER['HTTPS']) !== 'off') {
            return TRUE;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return TRUE;
        } elseif (! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && mb_strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return TRUE;
        }
        
        return FALSE;
    }
}
if (! function_exists('is_php')) {

    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param
     *            string
     * @return bool if the current version is $version or higher
     */
    function is_php($version)
    {
        static $_is_php;
        $version = (string) $version;
        
        if (! isset($_is_php[$version])) {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }
        
        return $_is_php[$version];
    }
}

if (! function_exists('site_url')) {

    /**
     * Site URL
     *
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $uri            
     * @param string $protocol            
     * @return string
     */
    function site_url($uri = '', $protocol = NULL)
    {
        return Config::instance()->siteUrl($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('base_url')) {

    /**
     * Base URL
     *
     * Create a local URL based on your basepath.
     * Segments can be passed in as a string or an array, same as site_url
     * or a URL to a file can be passed in, e.g. to an image file.
     *
     * @param string $uri            
     * @param string $protocol            
     * @return string
     */
    function base_url($uri = '', $protocol = NULL)
    {
        if (! preg_match('#^([a-z]+:)?//#i', $uri)) {
            $uri = Config::instance()->baseUrl($uri, $protocol);
        }
        
        return $uri;
    }
}

// ------------------------------------------------------------------------

if (! function_exists('current_url')) {

    /**
     * Current URL
     *
     * Returns the full URL (including segments) of the page where this
     * function is placed
     *
     * @return string
     */
    function current_url()
    {
        return Config::instance()->siteUrl(Uri::instance()->uriString());
    }
}

// ------------------------------------------------------------------------

if (! function_exists('uri_string')) {

    /**
     * URL String
     *
     * Returns the URI segments.
     *
     * @return string
     */
    function uri_string()
    {
        return Uri::instance()->uriString();
    }
}

// ------------------------------------------------------------------------

if (! function_exists('index_page')) {

    /**
     * Index page
     *
     * Returns the "index_page" from your config file
     *
     * @return string
     */
    function index_page()
    {
        return Config::instance()->item('index_page');
    }
}

if (! function_exists('redirect')) {

    function redirect($uri = '', $method = 'auto', $code = NULL)
    {
        if (! preg_match('#^(\w+:)?//#i', $uri)) {
            $uri = site_url($uri);
        }
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && (empty($code) or ! is_numeric($code))) {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 : 307;
            } else {
                $code = 302;
            }
        }
        switch ($method) {
            case 'refresh':
                header('Refresh:0;url=' . $uri);
                break;
            default:
                header('Location: ' . $uri, TRUE, $code);
                break;
        }
        exit();
    }
}
if (! function_exists('set_attributes')) {

    function set_attributes($attributes, $defaults)
    {
        if (Arr::isArray($attributes)) {
            foreach ($defaults as $key => $val) {
                $var = array_key_exists($key, $attributes) && ! Arr::isArray($attributes[$key]) ? $attributes[$key] : NULL;
                if (! empty($var)) {
                    $defaults[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }
            
            if (count($attributes) > 0) {
                $defaults = Arr::arrayMerge($defaults, $attributes);
            }
        }
        
        $att = '';
        foreach ($defaults as $key => $val) {
            if ($key == 'value') {
                $val = validate_attributes($val, $defaults['name']);
            }
            $att .= $key . '="' . $val . '" ';
        }
        unset($attributes);
        unset($defaults);
        return $att;
    }
}

if (! function_exists('validate_attributes')) {

    function validate_attributes($str = '', $campo = '')
    {
        static $campoValido = array();
        if (Arr::isArray($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = validate_attributes($val);
            }
            return $str;
        }
        if ($str === '') {
            return '';
        }
        if (array_key_exists($campo, $campoValido) && ! empty($campoValido[$campo])) {
            return $str;
        }
        $str = htmlSpecialChars($str);
        $str = Str::strReplace(array(
            "'",
            '"'
        ), array(
            "&#39;",
            "&quot;"
        ), $str);
        if ($campo != '') {
            $campoValido[$campo] = $campo;
        }
        unset($campoValido);
        unset($campo);
        return $str;
    }
}