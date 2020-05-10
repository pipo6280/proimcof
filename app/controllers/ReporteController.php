<?php
namespace app\controllers;

use system\Core\Controller;
use app\dtos\ReporteDto;
use app\models\ReporteModel;
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

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {22/12/2016}
 */
class ReporteController extends Controller
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/12/2016}
     */
    public function __construct()
    {
        parent::__construct();
        $this->object = new ReporteDto();
        $this->model = new ReporteModel();
        $this->template = 'admin';
        $this->module = 'reporte';
        Lang::instance()->load($this->module);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/12/2016}
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
     * @since {29/11/2016}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 26);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/12/2016}
     */
    public function clientes_activos()
    {
        $this->view = 'clientes_activos';
        $this->object->setList($this->model->getLisClientesActivos(EEstadoCuenta::index(EEstadoCuenta::ACTIVA)->getId())); //
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {30/01/2017}
     */
    public function clientes_inactivos()
    {
        $this->view = 'clientes_inactivos';
        $this->object->setList($this->model->getLisClientesInactivos(EEstadoCuenta::index(EEstadoCuenta::ACTIVA)->getId())); //
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function egresos()
    {
        $this->view = 'egresos';
        $this->object->setList_empleados($this->model->getRepresentantesEnum(ESiNo::index(ESiNo::SI)->getId()));
        
        if (! Util::isVacio($this->object->getId_representante())) {
            $fecha_inicio = Util::fecha($this->object->getFecha_inicio(),'Y-m-d');
            $fecha_fin = Util::fecha($this->object->getFecha_fin(),'Y-m-d');
            $this->object->setList($this->model->getSesionesEmpleado($this->object->getId_representante(), $fecha_inicio, $fecha_fin));
            
            $this->getClases($fecha_inicio, $fecha_fin);
        }
        
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/02/2017}
     */
    public function gastos()
    {
        $this->view = 'gastos';
        if (Persistir::getParam('txtSearch')) {
            $fecha_inicio = Util::fecha($this->object->getFecha_inicio(),'Y-m-d');
            $fecha_fin = Util::fecha($this->object->getFecha_fin(),'Y-m-d');
            $this->object->setList($this->model->getGastos(null, $fecha_inicio, $fecha_fin));
        }
    
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function ingresos()
    {
        $this->view = 'ingresos';
        if (Persistir::getParam('txtSearch')) {
            $fecha_inicio = Util::fecha($this->object->getFecha_inicio(),'Y-m-d');
            $fecha_fin = Util::fecha($this->object->getFecha_fin(),'Y-m-d');
            $this->object->setList($this->model->getAbonosClientes($fecha_inicio, $fecha_fin));
        }
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param unknown $fecha_inicio
     * @param unknown $fecha_fin
     */
    public function getClases($fecha_inicio, $fecha_fin) {
        $clases = $this->model->getListClaseDto(null, $this->object->getId_representante(), ESiNo::index(ESiNo::SI)->getId());
        $list = $this->object->getList();
        if (! Arr::isEmptyArray($clases)) {
            $obj = $this->model->getPaqueteGrupalDto(ETipoPaquete::index(ETipoPaquete::GRUPAL)->getId());
            $dias = array();
            for ($i = $fecha_inicio; $i <= $fecha_fin;) {
                $dia = Util::fecha($i, 'N');
                foreach ($clases as $cl) {
                    $listDias = $cl->getList_dias();
                    if (! Arr::isNullArray($dia, $listDias)) {
                        $dias[] = $cl;
                    }
                }
                $i = Util::fecha(Util::sumarFecha($i, [
                    'd' => 1
                ]), 'Y-m-d');
            }
            $obj->setList_sesiones($dias);
            $list[] = $obj;
        }
        $this->object->setList($list);
    }
}

?>