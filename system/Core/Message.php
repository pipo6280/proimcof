<?php
namespace system\Core;

use system\Session\Session;
use system\Helpers\Lang;
use system\Support\Util;
use system\Support\Str;
use system\Support\Arr;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since {29/09/2015}
 */
class Message extends Singleton
{

    /**
     *
     * @tutorial Method Description: limpia los errores
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     */
    protected static function initialize()
    {
        Session::setRemoveData('LISTA_ERRORES');
    }

    /**
     *
     * @tutorial Method Description: agrega un error
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @param string $campo            
     * @param string $mensaje            
     * @throws \Exception
     */
    final public static function addError($campo, $mensaje)
    {
        $errores = array();
        try {
            if (Session::getData('LISTA_ERRORES') !== FALSE) {
                $errores = Session::getData('LISTA_ERRORES');
            }
            $mensaje = Str::strReplace("\r\n", "", $mensaje);
            $mensaje = Str::strReplace('{field}', $campo, $mensaje);
            $errores[] = addslashes($mensaje);
        } catch (\Exception $e) {
            $errores[] = lang('general.error_no_manejado') . ' - ' . $e->getMessage();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        Session::setData('LISTA_ERRORES', $errores);
        unset($errores);
        unset($mensaje);
        unset($campo);
    }

    /**
     *
     * @tutorial Method Description: add a message
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @param string $campo            
     * @param string $mensaje            
     * @param string $_tipoMensaje            
     * @throws \Exception
     */
    final public static function addMessage($campo, $mensaje, $_tipoMensaje = 'SUCCESS')
    {
        $messages = array();
        try {
            if (Session::getData('LISTA_MESSAGES') !== FALSE) {
                $messages = Session::getData('LISTA_MESSAGES');
            }
            $messages[] = "{$campo} {$mensaje}";
        } catch (\Exception $e) {
            $messages[] = lang('general.error_campo_mensaje', array(
                lang('general.error_no_manejado'),
                $e->getMessage()
            ));
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        Session::setData('LISTA_MESSAGES', $messages);
        unset($_tipoMensaje);
        unset($errores);
        unset($mensaje);
        unset($campo);
    }

    /**
     *
     * @tutorial Method Description: get errors
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @return Ambigous <multitype:, unknown>
     */
    final public static function messageError()
    {
        $messages = array();
        if (static::isError()) {
            $messages = (Session::getData('LISTA_ERRORES')) ? Session::getData('LISTA_ERRORES') : $messages;
        }
        return $messages;
    }

    /**
     *
     * @tutorial Method Description: get messages
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @return multitype:
     */
    final public static function messages()
    {
        $messages = (Session::getData('LISTA_MESSAGES')) ? Session::getData('LISTA_MESSAGES') : array();
        
        return $messages;
    }

    /**
     *
     * @tutorial Method Description: view message
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @return mixed
     */
    final public static function viewMessages()
    {
        $listaErrores = array();
        $listaMessages = array();
        $view = array();
        
        $errores = Message::messageError();
        foreach ($errores as $error) {
            $listaErrores[] = '<li>' . preg_replace("#[\n]+#", ' ', $error) . '</li>';
        }
        if (! empty($listaErrores)) {
            $view[] = static::toastMessage($listaErrores);
        }
        
        $messages = Message::messages();
        foreach ($messages as $men) {
            $listaMessages[] = '<li>' . $men . '</li>';
        }
        $tipoMensaje = NULL;
        if (! empty($listaMessages)) {
            $view[] = static::toastMessage($listaMessages, lower($tipoMensaje));
        }
        return Arr::implode($view, '');
    }

    final public static function clean()
    {
        Session::setData('LISTA_MESSAGES', array());
        Session::setData('LISTA_ERRORES', array());
    }

    /**
     *
     * @tutorial Method Description: Empleado para visualizar el componentes de errores
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @param string $mensaje            
     * @param string $type            
     * @return string
     */
    public static function toastMessage($mensaje, $type = NULL)
    {
        $toastmessage = 'Framework.setAlerta("<ul>' . implode(' ', $mensaje) . '</ul>");';
        return $toastmessage;
    }

    /**
     *
     * @tutorial Method Description: verifica si tiene errores
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {5/11/2015}
     * @return boolean
     */
    final public static function isError()
    {
        $hayErrores = FALSE;
        try {
            if (Session::getData('LISTA_ERRORES') !== FALSE) {
                $errores = Session::getData('LISTA_ERRORES');
                if (! Util::isVacio($errores)) {
                    $hayErrores = true;
                }
            }
        } catch (\Exception $e) {
            static::addError($e->getCode(), $e->getMessage());
        }
        return $hayErrores;
    }
}