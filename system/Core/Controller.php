<?php
namespace system\Core;

use system\Session\Session;
use system\Routing\Router;
use system\Support\Util;
use system\Support\Arr;
use app\models\UsuarioModel;
use app\dtos\UsuarioMenuDto;
use app\models\RegistroModel;
use app\enums\EEstadoCuenta;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Controller
{

    protected static $instance;

    protected $sessions;

    protected $template;

    protected $module;

    protected $model;

    protected $view;

    protected $object;

    protected $_array;

    public function __construct()
    {
        if (Session::getData('sessionDto') === FALSE) {
            $sessionDto = new \app\dtos\SessionDto();
            Session::setData('sessionDto', Util::serialize($sessionDto));
        }
        $this->sessions = Util::userSessionDto();
        $this->sessions = $this->sessions instanceof \app\dtos\SessionDto ? $this->sessions : new \app\dtos\SessionDto();
        log_message('info', 'Controller Class Initialized');
    }

    public function _reallocation($method, $params = array())
    {
        $this->router = Router::instance();
        $arrayExcluido = [
            'app\controllers\AjaxController'
        ];
        if (Persistir::getParam('txtAjax') == FALSE && array_search(get_class($this), $arrayExcluido) === FALSE) {
            $this->validateSession();
            if ($this->sessions->getAccess()) {
                $this->menuPrincipal();
            }
        }
        $temporal = $method;
        if (method_exists($this, $method) && $temporal != 'init') {
            $temporal = $method;
        } else 
            if ($temporal != 'init') {
                show_error("The method " . get_class($this) . ":$method() does not exist");
            } else {
                $temporal = 'index';
            }
        $params = Arr::arrayMerge([
            'metodo' => $temporal
        ], $params);
        return call_user_func_array([
            $this,
            'init'
        ], $params);
    }

    public function methodClass($obj, $params)
    {
        Persistir::postADto($this->object);
        $this->validatePermisos();
        call_user_func_array([
            $obj,
            $obj->object->getMethod()
        ], $params);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/01/2017}
     */
    protected function validateSession()
    {
        if (! $this->sessions->getAccess()) {
            if ($this instanceof \app\controllers\LoginController) {
                if ($this->sessions->getAccess()) {
                    redirect('welcome', 'location');
                }
            } else {
                redirect('login', 'location');
            }
        }
    }

    /**
     *
     * @tutorial Method Description: consulta el menu del usuario y los clientes que estan de cumpleaños
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @return void
     */
    protected function menuPrincipal()
    {
        try {
            if ($this->sessions->getAccess()) {
                $oMenu = new \app\models\MenuModel();
                $object = new UsuarioMenuDto();
                Doctrine::beginTransaction();
                
                $userMenu = $oMenu->getDrawMenuPrincipal($object, 0, $this->sessions->getIdUsuario(), \app\enums\EUbicacion::index(\app\enums\EUbicacion::VERTICAL)->getId(), TRUE);
                $this->sessions->setUserMenu($userMenu);
                if (! $this->sessions->getConsultaOK()) {
                    $model = new UsuarioModel();
                    $listBirthDays = $model->getClientesCumpleaños(Util::fechaActual());
                    $this->sessions->setListBirthDays($listBirthDays);
                    $this->sessions->setConsultaOK($model->setCambiarEstadoSesionIndex(EEstadoCuenta::index(EEstadoCuenta::ACTIVA)->getId()));
                    Doctrine::commit();
                }
                Session::setData('sessionDto', Util::serialize($this->sessions));
                Doctrine::close();
                unset($userMenu);
            }
        } catch (\Exception $e) {
            Doctrine::rollBack();
            Doctrine::close();
            throw $e;
        }
    }

    public function validatePermisos()
    {
        if (! Util::isVacio(Persistir::getParam('id_smenu'))) {
            $oMenu = new \app\models\MenuModel();
            $this->object->setPermisoDto($oMenu->setValidarPermisos(Util::userSessionDto()->getIdUsuario(), Persistir::getParam('id_smenu')));
        }
    }
}