<?php
namespace system\Core;

use system\Core\Singleton;
use system\Support\Util;
use system\Support\Arr;
use ArrayAccess;

/**
 * 
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Config extends Singleton implements ArrayAccess
{

    /**
     *
     * @tutorial All of the configuration items.
     * @var array
     */
    protected $items = [];

    /**
     *
     * @tutorial Create a new configuration repository.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param array $items            
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = & get_config();
        // Set the base_url automatically if none was provided
        if (empty($this->items['base_url'])) {
            if (isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST'])) {
                $baseUrl = (is_https() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
            } else {
                $baseUrl = 'http://localhost/';
            }
            $this->set('base_url', $baseUrl);
        }
    }

    /**
     *
     * @tutorial Assign the main url of the site
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {9/09/2015}
     * @param string $uri            
     * @param string $protocol            
     * @return string
     */
    public function siteUrl($uri = '', $protocol = NULL)
    {
        $baseUrl = $this->slashItem('base_url');
        if (isset($protocol)) {
            $baseUrl = $protocol . substr($baseUrl, strpos($baseUrl, '://'));
        }
        if (empty($uri)) {
            return $baseUrl . $this->get('index_page');
        }
        $uri = $this->uriString($uri);
        if ($this->get('enable_query_strings') === FALSE) {
            $suffix = isset($this->items['url_suffix']) ? $this->items['url_suffix'] : '';
            if ($suffix !== '') {
                if (($offset = strpos($uri, '?')) !== FALSE) {
                    $uri = substr($uri, 0, $offset) . $suffix . substr($uri, $offset);
                } else {
                    $uri .= $suffix;
                }
            }
            return $baseUrl . $this->slashItem('index_page') . $uri;
        } elseif (strpos($uri, '?') === FALSE) {
            $uri = '?' . $uri;
        }
        return $baseUrl . $this->get('index_page') . $uri;
    }

    /**
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {9/09/2015}
     * @param string $uri            
     * @param string $protocol            
     * @return string
     */
    public function baseUrl($uri = '', $protocol = NULL)
    {
        $baseUrl = $this->slashItem('base_url');
        
        if (isset($protocol)) {
            $baseUrl = $protocol . substr($baseUrl, strpos($baseUrl, '://'));
        }
        return $baseUrl . ltrim($this->uriString($uri), '/');
    }

    /**
     *
     * @tutorial Validates the main url
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {9/09/2015}
     * @param mixed $item            
     * @return mixed
     */
    public function slashItem($item)
    {
        if (! isset($this->items[$item])) {
            return NULL;
        } elseif (trim($this->items[$item]) === '') {
            return '';
        }
        return rtrim($this->items[$item], '/') . '/';
    }

    /**
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {9/09/2015}
     * @param string $uri            
     * @return string
     */
    public function uriString($uri)
    {
        if ($this->get('enable_query_strings') === FALSE) {
            if (Arr::isArray($uri)) {
                $uri = Arr::implode($uri, '/');
            }
            return Util::trim($uri, '/');
        } elseif (Arr::isArray($uri)) {
            return http_build_query($uri);
        }
        return $uri;
    }

    /**
     *
     * @tutorial Fetch a config file item
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @param string $item            
     * @param string $index            
     * @return Ambigous <NULL, multitype:>|NULL
     */
    public function item($item, $index = '')
    {
        if ($index == '') {
            return isset($this->items[$item]) ? $this->items[$item] : NULL;
        }
        return isset($this->items[$index], $this->items[$index][$item]) ? $this->items[$index][$item] : NULL;
    }

    /**
     *
     * @tutorial Determine if the given configuration value exists.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @return boolean
     */
    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    /**
     *
     * @tutorial Get the specified configuration value.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @param string $default            
     * @return Ambigous <\Support\mixed, array, unknown, mixed, Closure>
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     *
     * @tutorial Set a given configuration value.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @param string $value            
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->items, $innerKey, $innerValue);
            }
        } else {
            Arr::set($this->items, $key, $value);
        }
    }

    /**
     *
     * @tutorial Prepend a value onto an array configuration value.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @param mixed $value            
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);
        array_unshift($array, $value);
        $this->set($key, $array);
    }

    /**
     *
     * @tutorial Push a value onto an array configuration value.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @param mixed $value            
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key);
        $array[] = $value;
        $this->set($key, $array);
    }

    /**
     *
     * @tutorial Get all of the configuration items for the application.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @tutorial Determine if the given configuration option exists.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @return boolean
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @tutorial Get a configuration option.
     *          
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param unknown $key            
     * @return Ambigous <\Config\mixed, \Support\mixed, array, unknown, mixed, Closure>
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @tutorial Set a configuration option.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @param mixed $value            
     * @return void
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @tutorial Unset a configuration option.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/08/2015
     * @param string $key            
     * @return void
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($key)
    {
        return $this->set($key, null);
    }
}