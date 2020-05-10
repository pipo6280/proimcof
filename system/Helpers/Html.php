<?php
namespace system\Helpers;

use system\Core\Config;
use system\Support\Str;
use system\Support\Arr;
use system\Support\Util;
use system\Core\Singleton;

class Html extends Singleton
{

    protected static $resourcesPath = 'public/';

    protected static function initialize()
    {}

    public static function title($title)
    {
        return "<title>$title</title>\n";
    }

    public static function charset($charset = null)
    {
        return "<meta charset=\"" . (trim($charset) != null ? $charset : config_item('charset')) . "\"/>\n";
    }

    public static function favicon($favicon = NULL, $attributes = array())
    {
        $href = array(
            Config::instance()->get('base_url'),
            static::imgPath(($favicon != '' ? $favicon : 'favicon.ico'))
        );
        $defaults = [
            'rel' => 'shortcut icon',
            'sizes' => '32x32',
            'href' => Arr::implode($href, '')
        ];
        return "<link " . set_attributes($attributes, $defaults) . "/>\n";
    }

    public static function meta($name = '', $content = '', array $attributes = array())
    {
        $defaults = array(
            'name' => $name,
            'content' => $content
        );
        return "<meta " . set_attributes($attributes, $defaults) . " />\n";
    }

    public static function style($href = '', array $attributes = array())
    {
        if (! url_exists($href)) {
            $href = array(
                Config::instance()->get('base_url'),
                static::$resourcesPath . $href
            );
            $href = Arr::implode($href, '');
        }
        $defaults = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => $href
        );
        return "<link " . set_attributes($attributes, $defaults) . "/>\n";
    }

    public static function script($src, $attributes = array())
    {
        $src = array(
            Config::instance()->get('base_url'),
            static::$resourcesPath . $src
        );
        $defaults = array(
            'type' => 'text/javascript',
            'src' => Arr::implode($src, '')
        );
        return "<script " . set_attributes($attributes, $defaults) . "></script>\n";
    }

    public static function image($src = NULL, $alt = '', $attributes = NULL)
    {
        if (! url_exists($src)) {
            $src = array(
                Config::instance()->get('base_url'),
                static::imgPath($src)
            );
            $src = Arr::implode($src, '');
        }
        $defaults = array(
            'src' => $src,
            'alt' => $alt
        );
        if (! Arr::isArray($attributes) && ! Util::isVacio($attributes)) {
            $defaults['class'] = $attributes;
        }
        return '<img ' . set_attributes($attributes, $defaults) . '/>';
    }

    public static function link($href = '', $content = '', $attributes = array(), $index_page = TRUE)
    {
        $defaults = array();
        if (! Arr::isArray($href)) {
            $defaults['href'] = $href;
            if (strpos($href, 'javascript') === false) {
                if (preg_match('#^([a-z]+:)?//#i', $href)) {
                    $defaults['href'] = $href;
                } elseif ($index_page === FALSE) {
                    $defaults['href'] = Config::instance()->siteUrl($href);
                } else {
                    $defaults['href'] = Config::instance()->get('base_url') . $href;
                }
            }
        }
        return '<a ' . set_attributes($attributes, $defaults) . '>' . $content . '</a>';
    }

    public static function linkImg($href, $img, $content, $attributes = array())
    {
        $defaults = array();
        if (! Arr::isArray($href)) {
            if (preg_match('#^([a-z]+:)?//#i', $href)) {
                $defaults['href'] = $href;
            } else {
                $defaults['href'] = Config::instance()->get('base_url') . $href;
            }
        }
        return '<a ' . set_attributes($attributes, $defaults) . '>' . $img . $content . '</a>';
    }

    public static function linkAction($href = '', $content = '', $parameter = '', $attributes = array())
    {
        if (Str::strpos($href, '@')) {
            $href = Str::lower($href);
            $href = Arr::explode($href, '@');
            $href = Arr::implode($href, '/');
            if (! Arr::isArray($parameter) && ! Util::isVacio($parameter)) {
                $href .= DIRECTORY_SEPARATOR . $parameter;
            }
            $href = Util::trim($href, '/');
            $defaults = array(
                'href' => Config::instance()->get('base_url') . $href
            );
            unset($href);
        } else {
            $defaults = array(
                'href' => $href
            );
        }
        return '<a ' . set_attributes($attributes, $defaults) . '>' . $content . '</a>';
    }

    public static function entities($string)
    {
        return htmlentities($string);
    }

    public static function decode($string)
    {
        return html_entity_decode($string);
    }

    public static function startHtml()
    {
        return ob_start();
    }

    public static function stopHtml()
    {
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @return string
     */
    public static function getResourcesPath()
    {
        return Html::$resourcesPath;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 15, 2016}
     * @param string $resourcesPath            
     */
    public static function setResourcesPath($resourcesPath)
    {
        Html::$resourcesPath = $resourcesPath;
    }

    public static function imgPath($img = NULL)
    {
        return static::getResourcesPath() . 'img/' . $img;
    }

    public static function jsPath($js = NULL)
    {
        return static::getResourcesPath() . 'js/' . $js;
    }

    public static function cssPath($css = NULL)
    {
        return static::getResourcesPath() . 'css/' . $css;
    }

    public static function pluginsPath($plugins = NULL)
    {
        return static::getResourcesPath() . 'plugins/' . $plugins;
    }
}