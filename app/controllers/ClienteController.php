<?php
namespace app\controllers;

use system\Libraries\Template;
use app\models\ClienteModel;
use system\Core\Persistir;
use system\Core\Doctrine;
use system\Core\Message;
use app\dtos\ClienteDto;
use system\Helpers\Lang;
use system\Support\Util;
use system\Core\Output;
use system\Support\Arr;
use app\dtos\ClienteSedeDto;
use app\enums\EEstadoEquipo;
use app\dtos\ClienteSedeEquipoDto;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {19/01/2018}
 */
class ClienteController extends \system\Core\Controller
{

    public $ruta = "public/img/perfil/barcode.png";

    public $list_campos = array();

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->model = new ClienteModel();
        Lang::instance()->load('cliente');
        $this->object = new ClienteDto();
        $this->module = 'cliente';
        $this->template = 'admin';
        
        $this->list_campos[1] = 'contador_copia_bn';
        $this->list_campos[2] = 'contador_impresion_bn';
        $this->list_campos[3] = 'contador_copia_color';
        $this->list_campos[4] = 'contador_impresion_color';
        $this->list_campos[5] = 'contador_scanner';
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
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
                Message::addError(null, lang('general.error_proccess_controller'));
            }
            if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true) {
                foreach ($e->getTrace() as $tra) {
                    if (! Arr::isnullArray('file', $tra)) {
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
     * @since {19/01/2018}
     */
    public function index()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 15);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function cliente()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 16);
        
        $this->view = 'cliente';
        $this->object->setList($this->model->getListClientes());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function edit()
    {
        $this->view = 'edit';
        $dto = new ClienteDto();
        if (Persistir::getParam('txtId_cliente')) {
            $dto = $this->model->getListClientes(Persistir::getParam('txtId_cliente'));
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ClienteDto();
        }
        
        if (Arr::isEmptyArray($dto->getList_sedes())) {
            $sede = new ClienteSedeDto();
            $sede->setNombre(lang('cliente.principal'));
            $sede->setId_cliente($dto->getId_cliente());
            $sede->setDireccion($dto->getDirecion());
            $sede->setTelefono($dto->getTelefono());
            
            $dto->setList_sedes([
                $sede
            ]);
        }
        
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function validate_nit()
    {
        $idCliente = Persistir::getParam('txtDto-txtId_cliente');
        $nit = Persistir::getParam('txtDto-txtNit');
        
        $hayDuplicate = false;
        if (! Util::isVacio($nit)) {
            $listEquipos = $this->model->getListClientes(null, $nit);
            foreach ($listEquipos as $lis) {
                if ($lis->getId_cliente() != $idCliente && $lis->getNit() == $nit) {
                    $hayDuplicate = true;
                    break;
                }
            }
        }
        $this->_array['contenido'] = $hayDuplicate;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {23/01/2018}
     * @param string $init            
     * @param string $sec            
     */
    public function add_sede($add = true, $sec = null)
    {
        $this->view = 'edit';
        
        $this->object->setDto(new ClienteDto());
        Persistir::postADto($this->object);
        
        $listKey = Persistir::getParam('txtSede_key');
        $listId = Persistir::getParam('txtSede_id');
        
        $listNombres = Persistir::getParam('txtSede_nombre');
        $listDireccion = Persistir::getParam('txtSede_direccion');
        $listTelefono = Persistir::getParam('txtSede_telefono');
        
        $listSedes = array();
        
        foreach ($listKey as $k) {
            $sede = new ClienteSedeDto();
            $sede->setNombre($listNombres[$k]);
            $sede->setId_cliente_sede($listId[$k]);
            $sede->setId_cliente($this->object->getDto()
                ->getId_cliente());
            $sede->setDireccion($listDireccion[$k]);
            $sede->setTelefono($listTelefono[$k]);
            $listSedes[$k] = $sede;
            
            unset($sede);
        }
        
        if ($add) {
            $listSedes[($k + 1)] = new ClienteSedeDto();
        }
        
        if (! Util::isVacio($sec)) {
            $delete = true;
            
            $id = $listId[$k];
            if (! Util::isVacio($id)) {
                $delete = $this->model->setDeleteSeede($id);
            }
            
            if ($delete) {
                unset($listSedes[$sec]);
            }
        }
        
        $this->object->getDto()->setList_sedes($listSedes);
        unset($k, $listSedes, $listTelefono, $listDireccion, $listNombres, $listId, $listKey);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {23/01/2018}
     * @param string $sec            
     */
    public function delete_sede($sec = null)
    {
        $this->add_sede(false, $sec);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     * @param string $add            
     * @param string $sec            
     */
    public function add_equipo($add = true)
    {
        $this->save_equipo();
        $this->get_equipos_sede($this->object->getDto()
            ->getId_cliente_sede(), true);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     * @param string $add            
     */
    public function guardar_equipo()
    {
        $this->save_equipo();
        $this->get_equipos_sede($this->object->getDto()
            ->getId_cliente_sede(), false);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     */
    public function set_asignar_equipos()
    {
        $this->object->setDto(new ClienteSedeDto());
        Persistir::postADto($this->object);
        
        $listKey = Persistir::getParam('txtEquipo_key');
        $listId = Persistir::getParam('txtEquipo_id');
        
        // Lista de parametros
        $listIdEquipo = Persistir::getParam('txtEquipo-txtId_equipo');
        $listSepararCopia = Persistir::getParam('txtEquipo-txtSeparar_copia_impresion');
        $listContadorScanner = Persistir::getParam('txtEquipo-txtContador_scanner');
        $listCostoScanner = Persistir::getParam('txtEquipo-txtCosto_scanner');
        
        $listContadorCopiaBn = Persistir::getParam('txtEquipo-txtContador_copia_bn');
        $listContadorImpresionBn = Persistir::getParam('txtEquipo-txtContador_impresion_bn');
        $listCostoImpresionBn = Persistir::getParam('txtEquipo-txtCosto_impresion_bn');
        
        $listContadorCopiaColor = Persistir::getParam('txtEquipo-txtContador_copia_color');
        $listContadorImpresionColor = Persistir::getParam('txtEquipo-txtContador_impresion_color');
        $listCostoImpresionColor = Persistir::getParam('txtEquipo-txtCosto_impresion_color');
        
        $listPlanMinimo = Persistir::getParam('txtEquipo-txtPlan_minimo');
        $listIncluirScanner = Persistir::getParam('txtEquipo-txtIncluir_scanner');
        $listEstado = Persistir::getParam('txtEquipo-txtEstado');
        
        $listEquipos = array();
        
        foreach ($listKey as $k) {
            $equipo = new ClienteSedeEquipoDto();
            $equipo->setId_cliente_sede_equipo($listId[$k]);
            $equipo->setId_equipo($listIdEquipo[$k]);
            $equipo->setSeparar_copia_impresion($listSepararCopia[$k]);
            $equipo->setContador_scanner($listContadorScanner[$k]);
            $equipo->setCosto_scanner($listCostoScanner[$k]);
            $equipo->setContador_copia_bn($listContadorCopiaBn[$k]);
            $equipo->setContador_impresion_bn($listContadorImpresionBn[$k]);
            $equipo->setCosto_impresion_bn($listCostoImpresionBn[$k]);
            $equipo->setContador_copia_color($listContadorCopiaColor[$k]);
            $equipo->setContador_impresion_color($listContadorImpresionColor[$k]);
            $equipo->setCosto_impresion_color($listCostoImpresionColor[$k]);
            $equipo->setPlan_minimo($listPlanMinimo[$k]);
            $equipo->setIncluir_scanner($listIncluirScanner[$k]);
            $equipo->setEstado($listEstado[$k]);
            
            $listEquipos[$k] = $equipo;
            unset($equipo);
        }
        $this->object->getDto()->setList_equipos($listEquipos);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     */
    public function save_equipo()
    {
        $this->set_asignar_equipos();
        $this->model->setGuardarEquipo($this->object->getDto());
        if (! Message::isError()) {
            Doctrine::commit();
            Doctrine::close();
            Doctrine::beginTransaction();
        }
    }

    /**
     *
     * @tutorial Metodo Descripcion: carga la lista de los representantes creados
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 26/11/2016
     */
    public function save()
    {
        $this->add_sede(false, null);
        $this->_array['contenido'] = true;
        $this->_array['titulo'] = $this->model->setGuardarCliente($this->object->getDto());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function asignar_equipo()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 54);
        
        $this->view = 'sede';
        
        $dto = new ClienteDto();
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/01/2018}
     */
    public function consultar_sedes()
    {
        $this->asignar_equipo();
        $dto = new ClienteDto();
        if (Persistir::getParam('txtId_cliente')) {
            $dto = $this->model->getListClientes(Persistir::getParam('txtId_cliente'), null, true);
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ClienteDto();
        }
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function get_equipos_sede($idEquipoSede = null, $add = false)
    {
        $this->view = 'asignar_equipo';
        $dto = new ClienteSedeDto();
        
        $idEquipoSede = ! Util::isVacio($idEquipoSede) ? $idEquipoSede : Persistir::getParam('txtId_cliente_sede');
        
        if ($idEquipoSede) {
            $dto = $this->model->getClienteSede($idEquipoSede);
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ClienteSedeDto();
            
            if (Arr::isEmptyArray($dto->getList_equipos()) || $add) {
                $estado = EEstadoEquipo::index(EEstadoEquipo::SIN_ASIGNAR)->getId().",".EEstadoEquipo::index(EEstadoEquipo::CLIENTE_GENERAL)->getId();
                $equipo = new ClienteSedeEquipoDto();
                $equipo->setList_equipos_enum($this->model->getEquiposEnum(null, null, $estado));
                $equipos = $dto->getList_equipos();
                $equipos[] = $equipo;
                $dto->setList_equipos($equipos);
                unset($equipos, $equipo);
            }
        }
        
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/04/2018}
     */
    public function contadores()
    {
        $sessionDto = Util::userSessionDto();
        $oMenu = new \app\models\MenuModel();
        $this->_array['menu'] = $oMenu->getMenuHorizontal($sessionDto->getIdUsuario(), 57);
        $this->view = 'buscar_cliente';
        $dto = new ClienteDto();
        $this->object->setDto($dto);
        $this->object->setList($this->model->getListClientesEnum());
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/04/2018}
     */
    public function get_equipos_cliente()
    {
        $this->contadores();
        $dto = new ClienteDto();
        if (Persistir::getParam('txtId_cliente')) {
            $this->object->setAnho_actual(Persistir::getParam('txtAnho_actual'));
            $this->object->setId_mes(Persistir::getParam('txtId_mes'));
            
            $dto = $this->model->getClienteListSede(Persistir::getParam('txtId_cliente'), $this->object->getFecha_mes());
            $dto = ! Util::isVacio($dto) ? Arr::current($dto) : new ClienteDto();
        }
        $this->object->setDto($dto);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/04/2018}
     */
    public function set_save_contador()
    {
        $this->object->setAnho_actual(Persistir::getParam('txtAnho_actual'));
        $this->object->setId_mes(Persistir::getParam('txtId_mes'));
        
        $idxContador = Persistir::getParam('txtIdx');
        $valFinal = Persistir::getParam('txtValor_final');
        $valor_inicial = Persistir::getParam('txtValor_inicial');
        $idEquipoSede = Persistir::getParam('txtId_cliente_sede_equipo');
        $idEquipoSedeFecha = Persistir::getParam('txtId_cliente_sede_equipo_fecha');        
        
        if (! Util::isVacio($idEquipoSede)) {
            $column = $this->list_campos[$idxContador];
            $data[$column] = Util::NullToCero($valFinal);
            $data[$column."_ant"] = Util::NullToCero($valor_inicial);
            $data['id_cliente_sede_equipo'] = $idEquipoSede;
            if (Util::isVacio($idEquipoSedeFecha)) {
                $data['fecha_mes'] = $this->object->getFecha_mes();
            }
                        
            $idEquipoSedeFecha = $this->model->setSaveEquipoSedeFecha($data, $idEquipoSedeFecha, $idEquipoSede, $column);
            $this->_array['contenido'] = $idEquipoSedeFecha;
        }
    }

/**
 *
 * @tutorial Method Description:
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {30/01/2018}
 * @param string $filepath            
 * @param string $text            
 * @param string $size            
 * @param string $orientation            
 * @param string $code_type            
 * @param string $print            
 * @param number $SizeFactor            
 */
    /*
     * public function barcode( $filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ) {
     * $code_string = "";
     * // Translate the $text into barcode the correct $code_type
     * if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
     * $chksum = 104;
     * // Must not change order of array elements as the checksum depends on the array's key to validate final code
     * $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
     * $code_keys = array_keys($code_array);
     * $code_values = array_flip($code_keys);
     * for ( $X = 1; $X <= strlen($text); $X++ ) {
     * $activeKey = substr( $text, ($X-1), 1);
     * $code_string .= $code_array[$activeKey];
     * $chksum=($chksum + ($code_values[$activeKey] * $X));
     * }
     * $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
     * $code_string = "211214" . $code_string . "2331112";
     * } elseif ( strtolower($code_type) == "code128a" ) {
     * $chksum = 103;
     * $text = strtoupper($text); // Code 128A doesn't support lower case
     * // Must not change order of array elements as the checksum depends on the array's key to validate final code
     * $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
     * $code_keys = array_keys($code_array);
     * $code_values = array_flip($code_keys);
     * for ( $X = 1; $X <= strlen($text); $X++ ) {
     * $activeKey = substr( $text, ($X-1), 1);
     * $code_string .= $code_array[$activeKey];
     * $chksum=($chksum + ($code_values[$activeKey] * $X));
     * }
     * $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
     * $code_string = "211412" . $code_string . "2331112";
     * } elseif ( strtolower($code_type) == "code39" ) {
     * $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");
     * // Convert to uppercase
     * $upper_text = strtoupper($text);
     * for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
     * $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
     * }
     * $code_string = "1211212111" . $code_string . "121121211";
     * } elseif ( strtolower($code_type) == "code25" ) {
     * $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
     * $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");
     * for ( $X = 1; $X <= strlen($text); $X++ ) {
     * for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
     * if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
     * $temp[$X] = $code_array2[$Y];
     * }
     * }
     * for ( $X=1; $X<=strlen($text); $X+=2 ) {
     * if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
     * $temp1 = explode( "-", $temp[$X] );
     * $temp2 = explode( "-", $temp[($X + 1)] );
     * for ( $Y = 0; $Y < count($temp1); $Y++ )
     * $code_string .= $temp1[$Y] . $temp2[$Y];
     * }
     * }
     * $code_string = "1111" . $code_string . "311";
     * } elseif ( strtolower($code_type) == "codabar" ) {
     * $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
     * $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");
     * // Convert to uppercase
     * $upper_text = strtoupper($text);
     * for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
     * for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
     * if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
     * $code_string .= $code_array2[$Y] . "1";
     * }
     * }
     * $code_string = "11221211" . $code_string . "1122121";
     * }
     * // Pad the edges of the barcode
     * $code_length = 20;
     * if ($print) {
     * $text_height = 30;
     * } else {
     * $text_height = 0;
     * }
     *
     * for ( $i=1; $i <= strlen($code_string); $i++ ){
     * $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
     * }
     * if ( strtolower($orientation) == "horizontal" ) {
     * $img_width = $code_length*$SizeFactor;
     * $img_height = $size;
     * } else {
     * $img_width = $size;
     * $img_height = $code_length*$SizeFactor;
     * }
     * $image = imagecreate($img_width, $img_height + $text_height);
     * $black = imagecolorallocate ($image, 0, 0, 0);
     * $white = imagecolorallocate ($image, 255, 255, 255);
     * imagefill( $image, 0, 0, $white );
     * if ( $print ) {
     * imagestring($image, 5, 31, $img_height, $text, $black );
     * }
     * $location = 10;
     * for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
     * $cur_size = $location + ( substr($code_string, ($position-1), 1) );
     * if ( strtolower($orientation) == "horizontal" )
     * imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
     * else
     * imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
     * $location = $cur_size;
     * }
     *
     * // Draw barcode to the screen or save in a file
     * if ( $filepath=="" ) {
     * header ('Content-type: image/png');
     * imagepng($image);
     * imagedestroy($image);
     * } else {
     * imagepng($image,$filepath);
     * imagedestroy($image);
     * }
     * }
     */
}