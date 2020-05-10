<?php
use app\models\MenuModel;
use system\Support\Str;
use system\Core\Doctrine;
use system\Core\Persistir;
use app\models\UsuarioModel;
use app\enums\ESiNo;
use system\Support\Util;
use system\Helpers\Html;
use app\models\EquipoModel;
use app\models\ClienteModel;

define('ENVIRONMENT', isset($_SERVER['ci_env']) ? $_SERVER['ci_env'] : 'development');

require '../../bootstrap/autoload.php';
require '../../app/config/config.php';
$lang = require '../../resources/lang/es/general_lang.php';

$charset = Str::lower($config['charset']);
ini_set('default_charset', $charset);
if (extension_loaded('mbstring')) {
    define('MB_ENABLED', TRUE);
    @ini_set('mbstring.internal_encoding', $charset);
    mb_substitute_character('none');
}
if (extension_loaded('iconv')) {
    define('ICONV_ENABLED', TRUE);
    @ini_set('iconv.internal_encoding', $charset);
}
$tempDirApp = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
unset($tempDirApp[count($tempDirApp) - 1]);

$tempDirPath = $tempDirApp;
unset($tempDirPath[count($tempDirPath) - 1]);
define('EM_APPPATH', implode(DIRECTORY_SEPARATOR, $tempDirApp) . DIRECTORY_SEPARATOR);
define('EM_BASEPATH', implode(DIRECTORY_SEPARATOR, $tempDirPath) . DIRECTORY_SEPARATOR);
try {
    new Doctrine();
    Doctrine::getConexion()->beginTransaction();
    $searchC = Persistir::getParam('term');
    $select2 = Persistir::getParam('txtSelect2');
    switch (Persistir::getParam('control')) {
        case 'auto_class_iconos':
            {
                $oModelo = new MenuModel();
                $listData = $oModelo->getClassIcons($searchC, 50);
                $result = array();
                foreach ($listData as $lis) {
                    $iconClass = "<i class='" . $lis->getClass() . " fa-2x'></i>";
                    $result[] = array(
                        'id' => $lis->getClass(),
                        'value' => $lis->getClass(),
                        'icon' => '<a><span>' . $lis->getClass() . '</span>&nbsp;' . $iconClass . '</a>'
                    );
                }
                echo json_encode($result);
            }
            break;
        case 'auto_usuarios_perfil':
            {
                $oModelo = new UsuarioModel();
                $listData = $oModelo->getPersonaUsuario(NULL, NULL, $searchC);
                $result = array();
                foreach ($listData as $lis) {
                    $nombrePersona = Str::ucWords($lis->getPersonaDto()->getNombreCompleto());
                    $iconClass = $nombrePersona;
                    $iconClass .= ($lis->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) ? ' <span class=\'red\'>(!)</span>' : NULL;
                    $result[] = array(
                        'id' => $lis->getId_usuario(),
                        'value' => $nombrePersona,
                        'icon' => "<a>" . $iconClass . "</a>"
                    );
                    unset($lis);
                }
                unset($listData);
                echo json_encode($result);
            }
            break;
        
        case 'auto_representantes':
            {
                $oModelo = new UsuarioModel();
                $listData = $oModelo->getListRepresentantes(NULL, NULL, $searchC);
                $result = array();
                foreach ($listData as $lis) {
                    $nombrePersona = Str::ucWords($lis->getPersonaDto()->getNombreCompleto());
                    $iconClass = $nombrePersona;
                    $iconClass .= ($lis->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) ? ' <span class=\'red\'>(!)</span>' : NULL;
                    $result[] = array(
                        'id' => $lis->getId_representante(),
                        'value' => $nombrePersona,
                        'icon' => "<a>" . $iconClass . "</a>"
                    );
                    unset($lis);
                }
                unset($listData);
                echo json_encode($result);
            }
            break;
            case 'auto_marca':
                {
                    $oModelo = new EquipoModel();
                    $listData = $oModelo->getListMarcas($searchC);
                    $result = array();
                    foreach ($listData as $lis) {
                        $nombre = Str::ucWords($lis->getNombre());
                        $result[] = array(
                            'id' => $lis->getId_marca(),
                            'value' => $nombre
                        );
                        unset($lis);
                    }
                    unset($listData);
                    if ($select2 == ESiNo::index(ESiNo::SI)->getId()) {
                        echo '{"results":' . json_encode($result) . '}';
                    } else {
                        echo json_encode($result);
                    }
                }
                break;
            case 'auto_ciudad':
                {
                    $oModelo = new ClienteModel();
                    $listData = $oModelo->getListCiudades($searchC);
                    $result = array();
                    foreach ($listData as $lis) {
                        $nombre = Str::ucWords($lis->getNombre_ciudad());
                        $result[] = array(
                            'id' => $lis->getId_ciudad(),
                            'value' => $nombre
                        );
                        unset($lis);
                    }
                    unset($listData);
                    if ($select2 == ESiNo::index(ESiNo::SI)->getId()) {
                        echo '{"results":' . json_encode($result) . '}';
                    } else {
                        echo json_encode($result);
                    }
                }
                break;
            case 'auto_cliente':
                {
                    $oModelo = new ClienteModel();
                    $listData = $oModelo->getListAutoClientes($searchC);
                    $result = array();
                    foreach ($listData as $lis) {
                        $nombre = Str::ucWords($lis->getNombre_empresa());
                        $result[] = array(
                            'id' => $lis->getId_cliente(),
                            'value' => $nombre
                        );
                        unset($lis);
                    }
                    unset($listData);
                    if ($select2 == ESiNo::index(ESiNo::SI)->getId()) {
                        echo '{"results":' . json_encode($result) . '}';
                    } else {
                        echo json_encode($result);
                    }
                }
                break;
    }
    Doctrine::getConexion()->close();
} catch (\PDOException $e) {
    Doctrine::getConexion()->rollBack();
    throw new \Exception($e->getMessage(), $e->getCode());
}
exit();