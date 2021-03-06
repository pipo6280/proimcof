<?php
namespace app\controllers;

use system\Core\Controller;
use system\Helpers\Lang;
use system\Core\Doctrine;
use system\Core\Persistir;
use system\Support\Util;
use system\Core\Message;
use system\Support\Arr;
use system\Core\Output;
use system\Libraries\Template;
use app\enums\EEstadoCuenta;
use app\enums\ESiNo;
use app\enums\ETipoPaquete;
use app\dtos\RegistroDto;
use app\models\RegistroModel;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {13/02/2017}
 */
class RegistroController extends Controller
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function __construct()
    {
        parent::__construct();
        $this->object = new RegistroDto();
        $this->model = new RegistroModel();
        $this->template = 'admin';
        $this->module = 'registro';
        Lang::instance()->load($this->module);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
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
     * @since {13/02/2017}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 37);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function inicio()
    {
        $this->view = "registro";
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function save()
    {
        $fecha = Util::fechaActual();
        $this->_array['contenido'] = false;
        if ($this->object->getId_cliente()) {
            list ($edita, $errors, $mensaje) = $this->model->setCambiarEstadoSesion($this->object->getId_cliente(), $fecha, EEstadoCuenta::index(EEstadoCuenta::ACTIVA)->getId());
             $nombrecliente = $this->model->getPersonaCliente($this->object->getId_cliente());
            if (! Util::isVacio($nombrecliente)) {
                $this->_array['nombre']= $nombrecliente;
                $this->_array['contenido'] = $edita;
                $this->_array['error'] = $errors;
                $this->_array['mensaje'] = $mensaje;
            } else {
                $this->_array['error'] = lang('registro.no_cliente_documento');
            }
        }
    }
}

?>