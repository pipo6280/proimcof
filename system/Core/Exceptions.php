<?php
namespace system\Core;

use system\Support\Arr;
use system\Support\Str;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Exceptions extends Singleton
{

    /**
     *
     * @tutorial Nesting level of the output buffering mechanism
     * @var integer
     */
    public $obLevel;

    /**
     * List of available error levels
     *
     * @var array
     */
    public $levels = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice'
    );

    /**
     *
     * @tutorial Class constructor
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @return void
     */
    public function __construct()
    {
        $this->obLevel = ob_get_level();
    }

    /**
     *
     * @tutorial Logs PHP generated error messages
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @param integer $severity            
     * @param string $message            
     * @param string $filepath            
     * @param integer $line            
     * @return string
     */
    public function logException($severity, $message, $filepath, $line)
    {
        $severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;
        log_message('error', 'Severity: ' . $severity . ' --> ' . $message . ' ' . $filepath . ' ' . $line);
    }

    /**
     *
     * @tutorial Native PHP error handler
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @param unknown $severity            
     * @param unknown $message            
     * @param unknown $filepath            
     * @param unknown $line            
     */
    public function showPhpError($severity, $message, $filepath, $line)
    {
        $templatesPath = config_item('error_views_path');
        if (empty($templatesPath)) {
            $templatesPath = EM_VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
        }
        $severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;
        if (! is_cli()) {
            $filepath = Str::strReplace('\\', '/', $filepath);
            if (FALSE !== Str::strpos($filepath, '/')) {
                $x = Arr::explode($filepath, '/');
                $filepath = $x[Arr::count($x) - 2] . '/' . Arr::end($x);
            }
            
            $template = 'html' . DIRECTORY_SEPARATOR . 'error_php';
        } else {
            $template = 'cli' . DIRECTORY_SEPARATOR . 'error_php';
        }
        
        if (ob_get_level() > $this->obLevel + 1) {
            ob_end_flush();
        }
        ob_start();
        include ($templatesPath . $template . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        \system\Core\Output::instance()->setFinalOutput($buffer);
    }

    /**
     *
     * @tutorial Takes an error message as input (either as a string or an array) and displays it using the specified template.
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @param mixed $heading            
     * @param string $message            
     * @param string $template            
     * @param number $statusCode            
     * @return string
     */
    public function showError($heading, $message, $template = 'error_general', $statusCode = 500)
    {
        $templatesPath = config_item('error_views_path');
        if (empty($templatesPath)) {
            $templatesPath = E_VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
        }
        if (is_cli()) {
            $message = "\t" . (is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli' . DIRECTORY_SEPARATOR . $template;
        } else {
            set_status_header($statusCode);
            $message = '<p>' . (is_array($message) ? implode('</p><p>', $message) : $message) . '</p>';
            $template = 'html' . DIRECTORY_SEPARATOR . $template;
        }
        if (ob_get_level() > $this->obLevel + 1) {
            ob_end_flush();
        }
        ob_start();
        include ($templatesPath . $template . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     *
     * @tutorial 404 Error Handler
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @param string $page            
     * @param string $logError            
     * @uses Exceptions::show_error()
     * @return mixed
     */
    public function showPage404($page = '', $logError = TRUE)
    {
        if (is_cli()) {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        } else {
            $heading = '404 Page Not Found';
            $message = 'The page you requested was not found.';
        }
        if ($logError) {
            log_message('error', $heading . ': ' . $page);
        }
        echo $this->showError($heading, $message, 'error_404', 404);
        // \system\Core\Output::instance()->setFinalOutput($return);
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/09/2015}
     * @param \Exception $exception            
     */
    public function showException(\Exception $exception)
    {
        $templatesPath = config_item('error_views_path');
        if (empty($templatesPath)) {
            $templatesPath = VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
        }
        $message = $exception->getMessage();
        if (empty($message)) {
            $message = '(null)';
        }
        if (is_cli()) {
            $templatesPath .= 'cli' . DIRECTORY_SEPARATOR;
        } else {
            set_status_header(500);
            $templatesPath .= 'html' . DIRECTORY_SEPARATOR;
        }
        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include ($templatesPath . 'error_exception.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        \system\Core\Output::instance()->setFinalOutput($buffer);
    }
}