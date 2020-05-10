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
use app\dtos\FacturacionDto;
use app\models\FacturacionModel;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class FacturacionController extends Controller
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
        $this->object = new FacturacionDto();
        $this->model = new FacturacionModel();
        $this->template = 'admin';
        $this->module = 'facturacion';
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
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 59);
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/04/2018}
     */
    public function inicio()
    {
        $this->index();
        $this->view = "facturacion";        
    }
}