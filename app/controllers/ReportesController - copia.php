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
use app\dtos\PaqueteDto;
use app\models\PaqueteModel;
use app\dtos\SubPaqueteDto;
use app\dtos\HorarioPaqueteDto;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {29/11/2016}
 */
class PaqueteController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new PaqueteDto();
        $this->model = new PaqueteModel();
        $this->template = 'admin';
        $this->module = 'paquete';
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
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/11/2016}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 19);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/11/2016}
     */
    public function crear()
    {
        $this->view = 'paquete';
        $this->object->setList($this->model->getPaquetes());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/11/2016}
     */
    public function delete()
    {
        $this->_array['contenido'] = false;
        if (Persistir::getParam('txtId_paquete')) {
            $this->_array['contenido'] = $this->model->setDeletePaquete(Persistir::getParam('txtId_paquete'));
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {30/11/2016}
     */
    public function edit()
    {
        $this->view = 'edit_paquete';
        $dto = null;
        if (Persistir::getParam('txtId_paquete')) {
            $dto = $this->model->getPaquetes(Persistir::getParam('txtId_paquete'));
        }
        $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new PaqueteDto();
        if (Arr::isEmptyArray($dto->getList_horario())) {
            $dto->setList_horario([
                new HorarioPaqueteDto()
            ]);
        }
        $this->object->setDto($dto);
        $this->object->setList($this->model->getPaquetes(null, $dto->getId_paquete()));
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function add_horario($init = TRUE, $sec = NULL)
    {
        $this->view = 'edit_paquete';
        $listInicio = Persistir::getParam('txtDto-txtHora_inicio');
        $listFin = Persistir::getParam('txtDto-txtHora_fin');
        $listKeys = Persistir::getParam('txtFechaId');
        
        foreach ($listInicio as $k => $hora) {
            $time = new HorarioPaqueteDto();
            $time->setId_horario_paquete($listKeys[$k]);
            $time->setHora_inicio($hora);
            $time->setHora_fin($listFin[$k]);
            $time->setId_paquete($this->object->getDto()
                ->getId_paquete());
            $lisHorario[$k] = $time;
            unset($time, $hora);
        }
        
        if ($init) {
            $lisHorario[($k + 1)] = new HorarioPaqueteDto();
        }
        if (! Util::isVacio($sec)) {
            unset($lisHorario[$sec]);
        }
        
        $lisHorario = Arr::values($lisHorario);
        $this->object->getDto()->setList_horario($lisHorario);
        $this->object->setList($this->model->getPaquetes(null, $this->object->getDto()
            ->getId_paquete()));
        
        $lisPaqutes = array();
        
        foreach ($this->object->getDto()->getList_paquetes() as $p) {
            $lisPaqutes[$p] = $p;
            unset($p);
        }
        $this->object->getDto()->setList_paquetes($lisPaqutes);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/12/2016}
     */
    public function delete_horario($sec = NULL)
    {
        $this->add_horario(false, $sec);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {01/12/2016}
     */
    public function save()
    {
        $this->_array['contenido'] = false;
        if (! Util::isVacio($this->object->getDto()->getNombre())) {
            $this->add_horario(false);
            $this->view = '';
            $this->_array['contenido'] = $this->model->savePaquete($this->object->getDto());
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function clases()
    {
        $this->view = 'clase';
        $this->object->setList($this->model->getSubPaquetes());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function change_state()
    {
        $id_subPaquete = Persistir::getParam('txtId_sub_paquete');
        $estado = Persistir::getParam('txtYn_activo');
        $this->_array['contenido'] = false;
        if (! Util::isVacio($id_subPaquete) && ! Util::isVacio($estado)) {
            $this->_array['contenido'] = $this->model->setChangeState($id_subPaquete, $estado);
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function delete_subPaquete()
    {
        $this->_array['contenido'] = false;
        if (Persistir::getParam('txtId_sub_paquete')) {
            $this->_array['contenido'] = $this->model->setDeleteSubPaquete(Persistir::getParam('txtId_sub_paquete'));
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function edit_subPaquete()
    {
        $this->view = 'edit_clase';
        $dto = null;
        if (Persistir::getParam('txtId_sub_paquete')) {
            $dto = $this->model->getSubPaquetes(Persistir::getParam('txtId_sub_paquete'));
        }
        $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new SubPaqueteDto();
        $this->object->setDto($dto);
        $this->object->setList($this->model->getPaquetesEnums());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function saveSubPaquete()
    {
        $this->_array['contenido'] = false;
        
        $this->object->setDto(new SubPaqueteDto());
        Persistir::postADto($this->object);
        
        if (! Util::isVacio($this->object->getDto()->getNombre())) {
            $this->_array['contenido'] = $this->model->saveSubPaquete($this->object->getDto());
        }
    }
}