<?php
namespace app\controllers;

use system\Libraries\Template;
use system\Core\Persistir;
use app\models\MenuModel;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Output;
use system\Support\Arr;
use app\dtos\UsuarioMenuDto;
use system\Core\Doctrine;
use system\Core\Message;

class MenuController extends \system\Core\Controller
{

    private $loguea;

    public function __construct()
    {
        parent::__construct();
        $this->object = new UsuarioMenuDto();
        $this->model = new MenuModel();
        $this->template = 'admin';
        $this->module = 'menu';
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

    public function index()
    {
        $sessionobject = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionobject->getIdUsuario(), 3);
    }

    public function create()
    {
        $this->view = 'create';
        $this->object->setListMenus($this->model->getDrawOptionsMenus());
    }

    public function edit()
    {
        $this->view = 'edit';
        $this->_array['menuPrint'] = $this->model->setDrawMenuList();
    }

    public function save()
    {
        $this->_array['contenido'] = $this->model->setCreateEditMenu($this->object);
    }

    public function consult()
    {
        $this->edit();
        $arrayMenu = $this->model->getConsultaSoloMenu($this->object->getId_menu());
        $this->object->setDto(! Util::isVacio($arrayMenu) ? Arr::current($arrayMenu) : new UsuarioMenuDto());
        $this->object->getDto()->setListMenus($this->model->getOptionsMenus($this->object->getDto()
            ->getId_menu_padre()));
        $this->object->setAjax(TRUE);
    }

    public function order()
    {
        $this->view = 'order';
        $idMenuPadreC = Util::isVacio($this->object->getId_menu_padre()) ? 0 : $this->object->getId_menu_padre();
        $idMenuC = Util::isVacio($this->object->getId_menu()) ? 0 : $this->object->getId_menu();
        
        $listMenus = $this->model->getConsultaSoloMenu(NULL, $idMenuPadreC);
        $listHijosMenus = $this->model->getConsultaSoloMenu($idMenuC);
        
        $this->object->setListMenus($listHijosMenus);
        $this->object->setListHijosMenus($listMenus);
    }

    public function save_order()
    {
        $valores = $this->object->getValores();
        $arrayValores = Arr::explode($valores, ',');
        $entra = false;
        foreach ($arrayValores as $keyOrden => $post) {
            $values = Arr::explode($post, '_');
            $campos = Arr::explode($values[1], '=');
            $this->_array['contenido'] = Doctrine::update('usuario_menu', [
                "orden" => $campos[1]
            ], [
                'id_menu' => Arr::current($campos)
            ]);
        }
    }

    public function icons()
    {
        $this->view = 'icons';
    }

    public function save_icons()
    {
        if (! Util::isVacio($_REQUEST['txtIcon_class'])) {
            $arrayInsert = array();
            foreach ($_REQUEST['txtIcon_class'] as $lis) {
                $arrayInsert[] = "('" . $lis . "')";
            }
            Doctrine::exec('INSERT INTO `class_icon` (`class`) VALUES ' . Arr::implode($arrayInsert, ','));
        }
    }
}