<?php
namespace app\controllers;

use system\Libraries\Template;
use system\Session\Session;
use system\Libraries\Email;
use system\Core\Persistir;
use system\Helpers\Lang;
use system\Support\Util;
use app\dtos\UsuarioDto;
use system\Core\Output;
use app\dtos\LoginDto;
use system\Support\Arr;
use system\Core\Doctrine;
use system\Core\Message;
use app\models\LoginModel;

/**
 *
 * @tutorial Class Work
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 01/05/2016
 */
class LoginController extends \system\Core\Controller
{

    /**
     *
     * @var bool
     */
    private $loguea;

    /**
     *
     * @tutorial Method Description: Constructor Class
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new LoginModel();
        $this->object = new LoginDto();
        $this->template = 'login';
        $this->module = 'login';
        $this->loguea = FALSE;
        Lang::instance()->load($this->module);
    }

    /**
     *
     * @tutorial Method Description: init Class
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     * @param string $method            
     * @param string $action            
     * @param string $keyData            
     * @throws \Exception
     */
    public function init($method = '', $action = '', $keyData = '')
    {
        try {
            Doctrine::beginTransaction();
            $params = array(
                $action,
                $keyData
            );
            Persistir::arrayDto($this->object, array(
                'method' => $method,
                'id_usuario' => $keyData
            ));
            if (! Util::isVacio($method)) {
                $this->methodClass($this, $params);
            }
            if (! Message::isError()) {
                Doctrine::commit();
            } else {
                Doctrine::rollBack();
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            Doctrine::rollback();
            if ($this->object->getAjax()) {
                $this->_array['error'] = lang('general.error_proccess_controller');
            } else {
                Message::addError(NULL, lang('general.error_proccess_controller'));
            }
            if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) {
                foreach ($e->getTrace() as $tra) {
                    if (! Arr::isNullArray('file', $tra)) {
                        log_message('error', $tra['function'] . ": " . $tra['file'] . ' Line: ' . $tra['line']);
                    }
                }
            }
        }
        Doctrine::close();
        if ($this->object->getAjax()) {
            $this->_array['object'] = $this->object;
            if ($this->view) {
                $this->_array['contenido'] = Template::module($this->module, $this->view, $this->_array);
            }
            Output::instance()->contentType('application/json')->setFinalOutput(json_encode($this->_array));
        } else {
            $this->_array['object'] = $this->object;
            Template::load($this->template, $this->module, $this->view, $this->_array);
        }
    }

    /**
     *
     * @tutorial Method Description: load view login
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     */
    public function index()
    {
        $this->view = 'login';
    }

    /**
     *
     * @tutorial Method Description: valida si el usuario existe
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     */
    public function login()
    {
        if (! Util::isVacio($this->object->getLogin()) && ! Util::isVacio($this->object->getPassword())) {
            $this->loguea = $this->model->setLogin($this->object->getLogin(), $this->object->getPassword());
            $this->_array['contenido'] = $this->loguea;
        }
    }

    /**
     *
     * @tutorial Method Description: load view forgot_password
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     */
    public function forgot_password()
    {
        $this->view = 'forgot_password';
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {03/05/2016}
     */
    public function change_password($login = null)
    {
        Persistir::setParam('txtValida_clave', false);
        Persistir::setParam('txtId_usuario', $this->model->getUsuariologin($login));
        $this->view = 'change_password';
    }

    /**
     *
     * @tutorial Method Description: modifica la clave del usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 17, 2016}
     */
    public function save_password()
    {
        $result = FALSE;
        $valida = TRUE;
        $idUsuarioC = Persistir::getParam('txtId_usuario');
        $passwordC = Util::sha1(Persistir::getParam('txtPassword_new'));
        $passwordActual = Util::sha1(Persistir::getParam('txtPassword'));
        $passwordReviewC = Util::sha1(Persistir::getParam('txtPassword_new_review'));
        if (! Util::isVacio(Persistir::getParam('txtValida_clave')) && $passwordActual != Util::userSessionDto()->getPassword()) {
            $valida = FALSE;
        }
        if ($passwordC == $passwordReviewC && $valida) {
            $result = $this->model->setPassword($idUsuarioC, $passwordC);
        }
        $this->_array['contenido'] = $result;
    }

    /**
     *
     * @tutorial Method Description: envia email para el cambio de clave
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {01/05/2016}
     */
    public function send_email()
    {
        $message = null;
        if (! Util::isVacio($this->object->getEmail())) {
            $result = $this->model->getPersonaDatos(NULL, $this->object->getEmail());
            if (count($result) == 1) {
                $usuarioDto = Arr::current($result);
                $usuarioDto = $usuarioDto instanceof UsuarioDto ? $usuarioDto : new UsuarioDto();
                if (! Util::isVacio($usuarioDto->getPersonaDto()->getEmail())) {
                    $passwordC = Util::rand(1000, 9999);
                    $return = $this->model->setPasswordEmail($usuarioDto->getId_usuario(), $passwordC);
                    if ($return) {
                        $usuarioDto->setPassword($passwordC);
                        if (Util::isVacio($usuarioDto->getFecha_modificacion())) {
                            $usuarioDto->setFecha_modificacion(Util::fechaActual(TRUE));
                        }
                        $this->object->setDto($usuarioDto);
                        $this->_array['object'] = $this->object;
                        $config = array();
                        Lang::instance()->load('email');
                        $email = Email::instance();
                        $result = $email->sendMail(array(
                            'subject' => lang('login.asunto_cuenta_recupera'),
                            'message' => Template::module($this->module, 'forgot_password_message', $this->_array),
                            'to' => array(
                                $usuarioDto->getPersonaDto()
                                    ->getEmail() => $usuarioDto->getPersonaDto()
                                    ->getNombreCompleto()
                            )
                        ));
                        if ($result) {
                            $message = lang('login.sent_mail', $usuarioDto->getPersonaDto()->getEmail());
                        } else {
                            $message = $email->getLog_errors();
                        }
                        
                        
                        log_message('debug', $message);
                    } else {
                        $message = lang('general.operation_message');
                    }
                } else {
                    $message = lang('login.no_email');
                }
            } else {
                $message = lang('login.no_user');
            }
        }
        $this->_array['contenido'] = $message;
    }

    public function close()
    {
        Session::setData('sessionDto', NULL);
        Session::destroy();
        redirect('login');
    }
}