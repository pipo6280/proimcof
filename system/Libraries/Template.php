<?php
namespace system\Libraries;

use system\Support\Util;
use system\Core\Singleton;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since {6/12/2015}
 */
class Template extends Singleton
{

    protected static function initialize()
    {}

    /**
     *
     * @tutorial load view master page
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/09/2015}
     * @param string $layout            
     * @param string $module            
     * @param string $view            
     * @param array $data            
     */
    public static function load($layout, $module, $view, $data = array())
    {
        $data['content'] = NULL;
        if ($view != '') {
            $data['content'] = self::module($module, $view, $data);
        }
        self::template($data, $layout);
    }

    /**
     *
     * @tutorial set data to internal view
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/09/2015}
     * @param array $data            
     * @param string $layout            
     * @throws \ErrorException
     */
    protected static function template($data, $layout = NULL, $addSuffix = TRUE)
    {
        if (Util::isVacio($layout)) {
            $layout = 'admin';
        }
        if ($addSuffix === TRUE) {
            $layout = preg_replace('/_layout$/', '', $layout) . '_layout';
        }
        $ruta = EM_VIEWPATH . 'layouts/' . $layout . '.php';
        try {
            extract($data);
            ob_start();
            require $ruta;
            \system\Core\Output::instance()->setFinalOutput(ob_get_contents());
            @ob_end_clean();
            log_message('info', 'File loaded: ' . $ruta);
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getPrevious());
        }
    }

    /**
     *
     * @tutorial set data to internal view
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/09/2015}
     * @param string $module            
     * @param string $view            
     * @param array $data            
     * @throws \ErrorException
     * @return string
     */
    public static function module($module, $view, array $data = array())
    {
        $buffer = NULL;
        $ruta = EM_VIEWPATH . $module . DIRECTORY_SEPARATOR . $view . '.php';
        try {
            extract($data);
            ob_start();
            include $ruta;
            $buffer = ob_get_contents();
            @ob_end_clean();
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getPrevious());
        }
        log_message('info', 'File loaded: ' . $ruta);
        return $buffer;
    }
}