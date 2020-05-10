<?php
namespace system\Routing;

use system\Core\Singleton;
use system\Core\Config;
use system\Support\Util;
use system\Support\Arr;
use system\Support\Str;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 30, 2016
 */
class Router extends Singleton
{

    private $config;

    private $uri;

    public $routes = array();

    public $class = '';

    public $method = 'init';

    public $directory = '';

    public $defaultController;

    public $translateUriDashes = FALSE;

    public $enableQueryStrings = FALSE;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 30, 2016}
     * @param string $routing            
     */
    public function __construct($routing = NULL)
    {
        $this->config = Config::instance();
        $this->uri = Uri::instance();
        $this->uri = $this->uri instanceof Uri ? $this->uri : new Uri();
        
        $this->setEnableQueryStrings((! is_cli() && $this->config->get('enable_query_strings') === TRUE));
        $this->routing();
        
        // Set any routing overrides that may exist in the main index file
        if (Arr::isArray($routing)) {
            if (isset($routing['directory'])) {
                $this->setDirectory($routing['directory']);
            }
            if (! empty($routing['controller'])) {
                $this->setClass($routing['controller']);
            }
            if (! empty($routing['function'])) {
                $this->setMethod($routing['function']);
            }
        }
    }

    /**
     *
     * @tutorial {
     *           Determines what should be served based on the URI request,
     *           as well as any "routes" that have been set in the routing config file.
     *           }
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return mixed
     */
    protected function routing()
    {
        if ($this->getEnableQueryStrings()) {
            $_d = $this->config->get('directory_trigger');
            $_d = isset($_GET[$_d]) ? trim($_GET[$_d], " \t\n\r\0\x0B/") : '';
            if ($_d !== '') {
                $this->uri->setFilter_uri($_d);
                $this->setDirectory($_d);
            }
            
            $_c = trim($this->config->get('controller_trigger'));
            if (! empty($_GET[$_c])) {
                $this->uri->setFilter_uri($_GET[$_c]);
                $this->setClass($_GET[$_c]);
                
                $_f = trim($this->config->get('function_trigger'));
                if (! empty($_GET[$_f])) {
                    $this->uri->setFilter_uri($_GET[$_f]);
                    $this->setMethod($_GET[$_f]);
                }
                
                $this->uri->rsegments = array(
                    1 => $this->getClass(),
                    2 => $this->getMethod()
                );
            } else {
                $this->setdefaultController();
            }
            // Routing rules don't apply to query strings and we don't need to detect
            // directories, so we're done here
            return;
        }
        $route = NULL;
        // Load the routes.php file.
        if (file_exists(EM_APPPATH . 'config/routes.php')) {
            include (EM_APPPATH . 'config/routes.php');
        }
        
        if (file_exists(EM_APPPATH . 'config/' . ENVIRONMENT . '/routes.php')) {
            include (EM_APPPATH . 'config/' . ENVIRONMENT . '/routes.php');
        }
        
        // Validate & get reserved routes
        if (isset($route) && Arr::isArray($route)) {
            isset($route['default_controller']) && $this->setDefaultController($route['default_controller']);
            isset($route['translate_uri_dashes']) && $this->setTranslateUriDashes($route['translate_uri_dashes']);
            unset($route['default_controller'], $route['translate_uri_dashes']);
            $this->setRoutes($route);
        }
        // Is there anything to parse?
        if ($this->uri->uriString !== '') {
            $this->parseRoutes();
        } else {
            $this->setDefaultController();
        }
    }

    /**
     *
     * @tutorial {
     *           Matches any routes that may exist in the config/routes.php file
     *           against the URI to determine if the class/method need to be remapped.
     *           }
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     */
    protected function parseRoutes()
    {
        // Turn the segment array into a URI string
        $uri = Arr::implode($this->uri->segments, '/');
        // Get HTTP verb
        $http_verb = isset($_SERVER['REQUEST_METHOD']) ? Str::lower($_SERVER['REQUEST_METHOD']) : 'cli';
        // Is there a literal match? If so we're done
        if (isset($this->routes[$uri])) {
            // Check default routes format
            if (Util::isString($this->routes[$uri])) {
                $this->setRequest(explode('/', $this->routes[$uri]));
                return;
            } elseif (Arr::isArray($this->routes[$uri]) && isset($this->routes[$uri][$http_verb])) {
                $this->setRequest(explode('/', $this->routes[$uri][$http_verb]));
                return;
            }
        }
        // Loop through the route array looking for wildcards
        foreach ($this->routes as $key => $val) {
            // Check if route format is using http verb
            if (Arr::isArray($val)) {
                if (isset($val[$http_verb])) {
                    $val = $val[$http_verb];
                } else {
                    continue;
                }
            }
            
            // Convert wildcards to RegEx
            $key = Str::strReplace(array(
                ':any',
                ':num'
            ), array(
                '[^/]+',
                '[0-9]+'
            ), $key);
            
            // Does the RegEx match?
            if (preg_match('#^' . $key . '$#', $uri, $matches)) {
                // Are we using callbacks to process back-references?
                if (! Util::isString($val) && is_callable($val)) {
                    // Remove the original string from the matches array.
                    Util::arrayShift($matches);
                    // Execute the callback using the values in matches as its parameters.
                    $val = call_user_func_array($val, $matches);
                } elseif (Util::strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }
                $this->request(Util::explode($val, '/'));
                return;
            }
        }
        $this->request(Arr::values($this->uri->segments));
    }

    /**
     *
     * @tutorial {Takes an array of URI segments as input and sets the class/method to be called.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param array $segments            
     */
    protected function request($segments = array())
    {
        $segments = $this->validateRequest($segments);
        if (empty($segments)) {
            $this->setDefaultController();
            return;
        }
        if ($this->getTranslateUriDashes() === TRUE) {
            $temporalRutes = Arr::explode($segments[0], '-');
            $temporal = NULL;
            foreach ($temporalRutes as $temp) {
                $temporal .= Str::title($temp);
            }
            $segments[0] = $temporal;
            $segments[0] = Str::strReplace('-', '', $segments[0]);
            if (isset($segments[1])) {
                $segments[1] = Str::strReplace('-', '_', $segments[1]);
            }
        }
        $this->setClass($segments[0]);
        if (isset($segments[1])) {
            $this->setMethod($segments[1]);
        } else {
            $segments[1] = 'index';
        }
        array_unshift($segments, NULL);
        unset($segments[0]);
        $this->uri->rsegments = $segments;
    }

    /**
     *
     * @tutorial {Attempts validate the URI request and determine the controller path.}
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     *        @used-by Router::request()
     * @param array $segments            
     * @return mixed
     */
    protected function validateRequest($segments)
    {
        $c = Arr::count($segments);
        while ($c -- > 0) {
            $test = $this->getDirectory() . ucfirst($this->getTranslateUriDashes() === TRUE ? Str::strReplace('-', '_', $segments[0]) : $segments[0]);
            if (! file_exists(EM_APPPATH . 'controllers/' . $test . '.php') && is_dir(EM_APPPATH . 'controllers/' . $this->getDirectory() . $segments[0])) {
                $this->setDirectory(Arr::arrayShift($segments), TRUE);
                continue;
            }
            return $segments;
        }
        // This means that all segments were actually directories
        return $segments;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return field_type
     */
    public function getDefaultController()
    {
        return $this->defaultController;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param field_type $defaultController            
     */
    public function setDefaultController($defaultController = '')
    {
        if ($defaultController == '') {
            if (empty($this->defaultController)) {
                throw new \Exception('No se puede determinar lo que se debe mostrar . Una ruta por defecto no se ha especificado en el archivo de enrutamiento.');
            }
            // Is the method being specified?
            if (sscanf($this->defaultController, '%[^/]/%s', $class, $method) !== 2) {
                $method = 'index';
            }
            $class = ucfirst($class);
            $directory = $this->getDirectory();
            if (! file_exists("app/controllers/{$directory}{$class}Controller.php")) {
                // This will trigger 404 later
                return;
            }
            $this->setClass($class);
            $this->setMethod($method);
            
            // Assign routed segments, index starting from 1
            $this->uri->rsegments = array(
                1 => $class,
                2 => $method
            );
            log_message('debug', 'No URI presentes. Conjunto controlador predeterminado.');
        } else {
            $this->defaultController = $defaultController;
        }
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $directory            
     */
    public function setDirectory($directory, $append = FALSE)
    {
        if ($append !== TRUE or empty($this->directory)) {
            $this->directory = Str::strReplace('.', '', Util::trim($directory, '/')) . '/';
        } else {
            $this->directory .= Str::strReplace('.', '', Util::trim($directory, '/')) . '/';
        }
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return multitype:
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param multitype: $routes            
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $class            
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param string $method            
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return boolean
     */
    public function getTranslateUriDashes()
    {
        return $this->translateUriDashes;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param boolean $translateUriDashes            
     */
    public function setTranslateUriDashes($translateUriDashes)
    {
        $this->translateUriDashes = $translateUriDashes;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @return boolean
     */
    public function getEnableQueryStrings()
    {
        return $this->enableQueryStrings;
    }

    /**
     *
     * @tutorial
     *
     * @author {Rodolfo Perez ~ pipo6280@gmail.com}
     * @since {26/08/2015}
     * @param boolean $enableQueryStrings            
     */
    public function setEnableQueryStrings($enableQueryStrings)
    {
        $this->enableQueryStrings = $enableQueryStrings;
    }
}