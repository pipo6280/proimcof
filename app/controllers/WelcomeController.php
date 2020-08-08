<?php
namespace app\controllers;

use system\Core\Controller;
use app\models\LoginModel;
use system\Helpers\Lang;
use system\Core\Doctrine;
use system\Core\Persistir;
use system\Core\Message;
use system\Support\Util;
use system\Support\Arr;
use system\Libraries\Template;
use system\Core\Output;
use app\dtos\SessionDto;
use system\Session\Session;
use app\dtos\WelcomeDto;
use app\enums\EEstadoMantenimiento;

/**
 *
 * @tutorial Class Work
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 01/05/2016
 */
class WelcomeController extends Controller
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
        $this->object = new WelcomeDto();
        $this->module = 'welcome';
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
        
    }

    public function birthday()
    {
        $this->view = 'birthday';
        $model = new \app\models\MantenimientoModel();
        $this->object->setListBirthDay($model->getListMantenimientosPorRepresentante(Util::userSessionDto()->getIdPersona(), EEstadoMantenimiento::index(EEstadoMantenimiento::SOLICITADO)->getId()));
       // Chis->object->setListBirthDay($model->getListMantenimientosPorRepresentante(Util::userSessionDto()->getIdUsuario(), EEstadoMantenimiento::index(EEstadoMantenimiento::SOLICITADO)->getId()));
    }

    /**
     *
     * @tutorial Metodo Descripcion: configura la vista para el layout de administracion
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function config()
    {
        $sessionDto = Util::userSessionDto();
        $sessionDto = $sessionDto instanceof SessionDto ? $sessionDto : new SessionDto();
        switch (Persistir::getParam('txtOption')) {
            case 'skin':
                {
                    $sessionDto->setClassBody(Persistir::getParam('txtClassBody'));
                }
                break;
            case 'config':
                {
                    $menuClass = Persistir::getParam('txtMenu_class');
                    $sessionDto = Util::userSessionDto();
                    $sessionDto = $sessionDto instanceof SessionDto ? $sessionDto : new SessionDto();
                    $sessionDto->setClassMenu($menuClass);
                }
                break;
        }
        Session::setData('sessionDto', Util::serialize($sessionDto));
        $this->_array['contenido'] = true;
    }
}