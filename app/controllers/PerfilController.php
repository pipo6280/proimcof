<?php
namespace app\controllers;

use system\Libraries\Template;
use app\dtos\UsuarioPerfilDto;
use app\models\UsuarioModel;
use system\Core\Persistir;
use app\models\MenuModel;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Output;
use system\Core\Doctrine;
use system\Support\Arr;
use system\Core\Message;

/**
 *
 * @tutorial Method Description:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 14/11/2016
 */
class PerfilController extends \system\Core\Controller
{

    /**
     *
     * @tutorial Method Description: constructor de la clase
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->object = new UsuarioPerfilDto();
        $this->model = new UsuarioModel();
        $this->template = 'admin';
        $this->module = 'perfil';
        Lang::instance()->load($this->module);
    }

    /**
     *
     * @tutorial Method Description: se ejecta para el acceso de cada uno de los metodos
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
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
     * @tutorial Method Description: carga los submenus del menu perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 2);
    }

    /**
     *
     * @tutorial Method Description: consulta los perfiles
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     */
    public function perfil()
    {
        $this->view = 'profile';
        $this->object->setListPerfiles($this->model->getPerfilsUser());
    }

    /**
     *
     * @tutorial Method Description: edita el perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     */
    public function create()
    {
        $this->view = 'create';
        $this->modelMenu = new MenuModel();
        $menuCheck = $this->modelMenu->setDrawMenuChek(0);
        $moduleCheck = $this->modelMenu->setDrawModulesChek();
        $this->object->setMenuCheck($menuCheck);
        $this->object->setModuleCheck($moduleCheck);
    }

    /**
     *
     * @tutorial Method Description: guarda los cambios del perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function save()
    {
        $this->_array['contenido'] = $this->model->setAddEditProfile($this->object);
    }

    /**
     *
     * @tutorial Method Description: carga la vista para los permisos por perfil de usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     */
    public function edit()
    {
        $this->view = 'edit';
        $this->modelMenu = new MenuModel();
        $arbolMenu = array();
        $listPerfiles = $this->model->getPerfilsUser($this->object->getId_perfil());
        $this->object->setDto(Arr::current($listPerfiles));
        $this->modelMenu->setArbolMenus($idMenuPadreC = 0, $this->object->getId_perfil(), $nivelC = - 1, $arbolMenu);
        $this->object->setArbolMenu($arbolMenu);
    }

    /**
     *
     * @tutorial Method Description: guarda los permisos por perfil de usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     */
    public function save_permissions()
    {
        $return = $this->model->setGuardarPermisosPerfil($this->object);
        if ($return) {
            $this->_array['contenido'] = lang('general.process_message');
        }
    }

    /**
     *
     * @tutorial Method Description: cambia el estado del perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function change_state_profile()
    {
        $this->_array['contenido'] = $this->model->setCambiarEstadoPerfil($this->object);
    }

    /**
     *
     * @tutorial Method Description: carga la vista para dar permisos al usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function permisos()
    {
        $this->view = 'permisos';
    }

    /**
     *
     * @tutorial Method Description: consulta los permisos del usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function associated_profile()
    {
        $this->permisos();
        if (! Util::isVacio(Persistir::getParam('txtId_usuario'))) {
            $list = $this->model->getPerfilAsignadoUsuario(Persistir::getParam('txtId_usuario'));
            $this->object->setList($list);
        }
    }

    /**
     *
     * @tutorial Method Description: guarda la asociacion por perful y usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @return void
     */
    public function save_associated_profile()
    {
        $return = FALSE;
        $idUsuarioC = Persistir::getParam('txtId_usuario');
        if (! Util::isVacio($idUsuarioC)) {
            $return = $this->model->setSaveAssociatedProfile($idUsuarioC, Persistir::getParam('txtListaPerfil'));
        }
        $this->_array['contenido'] = $return;
    }
}