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
use app\dtos\ServicioDto;
use app\dtos\MantenimientoDto;
use app\models\MantenimientoModel;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class MantenimientoController extends Controller
{
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function __construct()
    {
        parent::__construct();
        $this->object = new MantenimientoDto();
        $this->model = new MantenimientoModel();
        $this->template = 'admin';
        $this->module = 'mantenimiento';
        Lang::instance()->load($this->module);
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
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
        //$this->view ="servicio";
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 59);
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function inicio(){
        $this->view ="mantenimiento";
        $this->object->setList_clientes_enum($this->model->getListClientesEnum());
    }
    
    /**
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {23/05/2020}
     */
    public function buscar_equipos() {
        $this->inicio();
        $this->object->setList($this->model->getEquipos($this->object->getSearch_equipo(), $this->object->getId_cliente()));
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function edit()
    {
        $this->view = 'edit';
        $dto = new ServicioDto();
        if (Persistir::getParam('txtId_servicio')) {
            $dto = $this->model->getServicios(Persistir::getParam('txtId_servicio'));
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ServicioDto();
        }
        
        $this->object->setDto($dto);
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function save() {
        $this->_array['contenido'] = false;
        $this->object->setDto(new ServicioDto());
        Persistir::postADto($this->object);
        if (! Util::isVacio($this->object->getDto()->getDescripcion())) {
            $this->_array['contenido'] = $this->model->save($this->object->getDto());
        }
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function delete()
    {
        $this->_array['contenido'] = false;
        if (Persistir::getParam('txtId_servicio')) {
            $this->_array['contenido'] = $this->model->setDeleteServicio(Persistir::getParam('txtId_servicio'));
        }
    }
    
}