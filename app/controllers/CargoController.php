<?php
namespace app\controllers;

use system\Libraries\Template;
use system\Core\Persistir;
use system\Support\Util;
use system\Core\Output;
use system\Core\Controller;
use system\Helpers\Lang;
use system\Core\Doctrine;
use system\Core\Message;
use system\Support\Arr;
use app\dtos\RhCargoDto;
use app\models\CargoModel;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 20/11/2016
 */
class CargoController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new RhCargoDto();
        $this->model = new CargoModel();
        $this->template = 'admin';
        $this->module = 'cargo';
        Lang::instance()->load($this->module);
    }

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
     * @tutorial Metodo Descripcion: carga el menu del cargo
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 10);
    }

    /**
     *
     * @tutorial Metodo Descripcion: carga la lista de cargos disponibles
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function cargo()
    {
        $this->view = 'cargo';
        $this->object->setList($this->model->getCargos());
    }

    /**
     *
     * @tutorial Metodo Descripcion: cambia el estado de los cargos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function change_state()
    {
        $this->_array['contenido'] = $this->model->setChangeState($this->object);
    }

    /**
     *
     * @tutorial Metodo Descripcion: carga la vista para crear o editar los cargos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function edit()
    {
        $this->view = 'edit';
        if (Persistir::getParam('txtId_cargo')) {
            $dto = $this->model->getCargos(Persistir::getParam('txtId_cargo'));
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new RhCargoDto();
            $this->object->setDto($dto);
        }
    }

    /**
     *
     * @tutorial Metodo Descripcion: guarda cada uno de los cargos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function save()
    {
        $this->_array['contenido'] = $this->model->setGuardarCargo($this->object->getDto());
    }

    /**
     *
     * @tutorial Metodo Descripcion: elimina los cargos siempre y cuando no tengan representantes asociados
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function delete()
    {
        $this->_array['contenido'] = false;
        if (Persistir::getParam('txtId_cargo')) {
            $this->_array['contenido'] = $this->model->setDeleteCargo(Persistir::getParam('txtId_cargo'));
        }
    }

    /**
     *
     * @tutorial Metodo Descripcion: asocia los representantes con los cargos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function asociar()
    {
        $this->view = 'asociar';
        if (! Util::isVacio(Persistir::getParam('txtId_representante'))) {
            $this->validatePermisos();
            $list = $this->model->getCargosRepresentanteAsociados(Persistir::getParam('txtId_representante'));
            $this->object->setList($list);
        }
    }

    /**
     *
     * @tutorial Metodo Descripcion: guarda la asociacion entre el representante y los cargos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function save_asociar()
    {
        $this->_array['contenido'] = false;
        if (! Util::isVacio(Persistir::getParam('txtId_representante'))) {
            $this->_array['contenido'] = $this->model->setSaveAsociar(Persistir::getParam('txtId_representante'), Persistir::getParam('txtListaCargo'), Persistir::getParam('txtListaActivo'));
        }
    }
}