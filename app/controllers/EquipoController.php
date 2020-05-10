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
use app\dtos\EquipoDto;
use app\models\EquipoModel;
use app\dtos\ModeloDto;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class EquipoController extends Controller
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
        $this->object = new EquipoDto();
        $this->model = new EquipoModel();
        $this->template = 'admin';
        $this->module = 'equipo';
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
        // $this->view ="servicio";
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 51);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function inicio()
    {
        $this->view = "equipo";
        $this->object->setList($this->model->getEquipos());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function modelo()
    {
        $this->view = "modelo";
        $this->object->setList($this->model->getListModelos());
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
        $dto = new EquipoDto();
        if (Persistir::getParam('txtId_equipo')) {
            $dto = $this->model->getEquipos(Persistir::getParam('txtId_equipo'));
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new EquipoDto();
        }
        $this->object->setList_modelos_enum($this->model->getListaModelosEnum());
        $this->object->setDto($dto);
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function edit_modelo()
    {
        $this->view = 'edit_modelo';
        $dto = new ModeloDto();
        if (Persistir::getParam('txtId_modelo')) {
            $dto = $this->model->getListModelos(null, Persistir::getParam('txtId_modelo'));
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ModeloDto();
        }
    
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function save()
    {
        $this->_array['contenido'] = false;
        $this->object->setDto(new EquipoDto());
        Persistir::postADto($this->object);
        if (! Util::isVacio($this->object->getDto()->getSerial_equipo())) {
            $this->_array['contenido'] = $this->model->save($this->object->getDto());
        }
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function save_modelo()
    {
        $this->_array['contenido'] = false;
        $this->object->setDto(new ModeloDto());
        Persistir::postADto($this->object);
        if (! Util::isVacio($this->object->getDto()->getTipo())) {
            $this->_array['contenido'] = $this->model->save_modelo($this->object->getDto());
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
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function validate_serial()
    {
        $idEquipo = Persistir::getParam('txtDto-txtId_equipo');
        $serial = Persistir::getParam('txtDto-txtSerial_equipo');
    
        $hayDuplicate = false;
        if (! Util::isVacio($serial)) {
            $listEquipos = $this->model->getEquipos(NULL, $serial);
            foreach ($listEquipos as $lis) {
                if ($lis->getId_equipo() != $idEquipo && $lis->getSerial_equipo() == $serial) {
                    $hayDuplicate = TRUE;
                    break;
                }
            }
        }
        $this->_array['contenido'] = $hayDuplicate;
    }
}