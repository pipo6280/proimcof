<?php
namespace app\controllers;

use app\models\RepresentanteModel;
use app\dtos\RhRepresentanteDto;
use system\Libraries\Template;
use system\Session\Session;
use system\Core\Persistir;
use app\models\CargoModel;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\SessionDto;
use system\Core\Message;
use system\Core\Output;
use system\Support\Arr;

/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {17/01/2018}
 */
class RepresentanteController extends \system\Core\Controller
{

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function __construct()
    {
        parent::__construct();
        $this->object = new RhRepresentanteDto();
        $this->model = new RepresentanteModel();
        $this->template = 'admin';
        $this->module = 'representante';
        Lang::instance()->load($this->module);
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     * @param string $method
     * @param string $action
     * @param string $keyData
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
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 13);
        $this->_array['menu']['tituloPadre'] = NULL;
    }

   /**
    * 
    * @tutorial Method Description:
    * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
    * @since {17/01/2018}
    */
    public function representante()
    {
        $this->view = 'representante';
        $this->object->setList($this->model->getListRepresentantes());
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function edit()
    {
        $this->view = 'edit';
        $cargoModel = new CargoModel();
        $this->object->setListCargos($cargoModel->getCargosEnumerado());
        if (! Util::isVacio($this->object->getId_representante())) {
            $dto = $this->model->getListRepresentantes($this->object->getId_representante());
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new RhRepresentanteDto();
            $this->object->setId_persona($dto->getId_persona());
            $this->object->setId_representante($dto->getId_representante());
            $this->object->setDto($dto);
        }
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function save()
    {
        $this->_array['contenido'] = FALSE;
        if (! Util::isVacio($this->object->getDto()
            ->getPersonaDto()
            ->getPrimer_nombre())) {
            $this->_array['contenido'] = $this->model->setGuardarRepresentante($this->object->getDto());
        }
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function eliminar_representante()
    {
        $this->_array['contenido'] = $this->model->setDeleteRepresentante($this->object);
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function validate_documento()
    {
        $idPersona = $this->object->getDto()
            ->getPersonaDto()
            ->getId_persona();
        $numeroIdentificacion = $this->object->getDto()
            ->getPersonaDto()
            ->getNumero_identificacion();
        
        $hayDuplicate = FALSE;
        if (! Util::isVacio($numeroIdentificacion)) {
            $listPersonas = $this->model->getDatosPersona(NULL, $numeroIdentificacion);
            foreach ($listPersonas as $lis) {
                if ($lis->getId_persona() != $idPersona && $lis->getNumero_identificacion() == $numeroIdentificacion) {
                    $hayDuplicate = TRUE;
                    break;
                }
            }
        }
        $this->_array['contenido'] = $hayDuplicate;
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function validate_email()
    {
        $idPersona = $this->object->getDto()
            ->getPersonaDto()
            ->getEmail();
        $email = $this->object->getDto()
            ->getPersonaDto()
            ->getEmail();
        
        $hayDuplicate = FALSE;
        if (! Util::isVacio($email)) {
            $listPersonas = $this->model->getDatosPersona(NULL, NULL, $email);
            foreach ($listPersonas as $lis) {
                if ($lis->getId_persona() != $idPersona && $lis->getEmail() == $email) {
                    $hayDuplicate = TRUE;
                    break;
                }
            }
        }
        $this->_array['contenido'] = $hayDuplicate;
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function representante_datos()
    {
        $this->edit();
        $this->_array['contenido'] = FALSE;
        $numeroIdentificacion = $this->object->getDto()
            ->getPersonaDto()
            ->getNumero_identificacion();
        if (! Util::isVacio($numeroIdentificacion)) {
            $representante = $this->model->getListRepresentantes(NULL, $numeroIdentificacion);
            if (! Util::isVacio($representante)) {
                $this->object->setDto(Arr::current($representante));
            }
        }
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function user_profile()
    {
        $this->view = 'user_profile';
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function save_datos()
    {
        $this->_array['contenido'] = FALSE;
        $personaDto = $this->object->getDto()->getPersonaDto();
        if (! Util::isVacio($personaDto->getPrimer_nombre())) {
            $this->_array['contenido'] = $this->model->setGuardarDatosRepresentante($personaDto);
            $sessionDto = Util::userSessionDto();
            $sessionDto = $sessionDto instanceof SessionDto ? $sessionDto : new SessionDto();
            $sessionDto->setPersonaDto($personaDto);
            Session::setData('sessionDto', Util::serialize($sessionDto));
        }
    }

    /**
     *
     * @tutorial Method Description: valida si la contraseña coincide con la que esta en base
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {20/12/2015}
     * @return void
     */
    public function validate_password()
    {
        $idUsuarioC = Persistir::getParam('txtId_usuario');
        $passwordC = Util::sha1(Persistir::getParam('txtPassword'));
        $listUsuarios = $this->model->getDatosUsuarios($idUsuarioC);
        $result = false;
        foreach ($listUsuarios as $lis) {
            if ($passwordC == $lis->getClave()) {
                $result = true;
                break;
            }
        }
        $this->_array['contenido'] = $result;
    }

    /**
     *
     * @tutorial Method Description: modifica la clave del usuario
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {20/12/2015}
     * @return void
     */
    public function save_password()
    {
        $result = false;
        $idUsuarioC = Persistir::getParam('txtId_usuario');
        $passwordC = Util::sha1(Persistir::getParam('txtPassword_new'));
        $passwordReviewC = Util::sha1(Persistir::getParam('txtPassword_new_review'));
        if ($passwordC == $passwordReviewC) {
            $result = $this->model->setPassword($idUsuarioC, $passwordC);
        }
        $this->_array['contenido'] = $result;
    }

    public function user_config()
    {
        $this->view = 'user_config';
    }

    public function reset_password()
    {
        $nuevoPassword = Util::rand(1000, 9999);
        $result = $this->model->setPasswordRepresentante(Persistir::getParam('txtId_usuario'), $nuevoPassword);
        $this->_array['contenido'] = $result ? $nuevoPassword : $result;
    }
}