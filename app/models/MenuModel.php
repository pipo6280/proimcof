<?php
namespace app\models;

use app\dtos\UsuarioPerfilPermisoDto;
use app\dtos\UsuarioMenuDto;
use app\dtos\PermisosMenuDto;
use app\dtos\ClassIconsDto;
use app\enums\EUbicacion;
use system\Support\Util;
use system\Helpers\Form;
use system\Support\Arr;
use app\enums\ETarget;
use app\enums\ESiNo;
use system\Helpers\Html;
use system\Core\Doctrine;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 3/12/2016
 */
class MenuModel
{

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @return string
     */
    protected function getUlPerfil()
    {
        ob_start(); ?>
        <li class="nav-header">
        	<div class="dropdown profile-element">
        		<span style="width: 120px">
                    <?php
                        $filename = lang('general.photo_profile', [
                            Util::userSessionDto()->getPhotoProfile()
                        ]);
                        if (! Util::fileExists($filename)) {
                            $filename = lang('general.photo_app_logo');
                        }
                    ?>
                    <img src="<?php echo site_url($filename)?>" alt="" class="" data-pin-nopin="true" style="width: 160px;">
        		</span> 
        		<a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
                    <span class="clear"> 
                        <span class="block m-t-xs"> 
                            <strong class="font-bold">
                                <?php echo Util::userSessionDto()->getFirstLastName(); ?>
                                <b class="caret"></b>
                            </strong>
                        </span>
                        <?php foreach (Util::userSessionDto()->getListProfiles() as $lis) { ?> 
                            <span class="text-muted text-xs block"><?php echo $lis->getNombre(); ?></span>
                        <?php } ?>                        
                    </span>
        		</a>
        		<ul class="dropdown-menu animated fadeInRight m-t-xs">
        		    <?php /*?>
        			<li><a href="<?php echo site_url('representante/perfil'); ?>"><?php echo lang('general.profile'); ?></a></li>
        			<li><a href="<?php echo site_url('representante/perfil'); ?>"><?php echo lang('general.contacts'); ?></a></li>
        			<li><a href="<?php echo site_url('representante/perfil'); ?>"><?php echo lang('general.mailbox'); ?></a></li>
        			<li class="divider"></li>
        			<?php */?>
        			<li><a href="<?php echo site_url('login/close'); ?>"><?php echo lang('general.log_out'); ?></a></li>
        		</ul>
        	</div>
        	<div class="logo-element" data-toggle="tooltip" title="<?php echo lang('general.company_name'); ?>">PRMCF</div>
        </li>
        <?php
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    /**
     *
     * @tutorial Metodo Descripcion: obtiene el menu vertical por usuario
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param UsuarioMenuDto $object            
     * @param string $idMenuC            
     * @param unknown $idUsuarioC            
     * @param string $ubicacionC            
     * @param string $capture            
     * @return Ambigous <NULL, string>
     */
    public function getDrawMenuPrincipal($object, $idMenuC = NULL, $idUsuarioC, $ubicacionC = NULL, $capture = FALSE)
    {
        $htmlMenu = NULL;
        $object->setListHijosMenus($this->getUserMenus($idMenuC, $idUsuarioC, $ubicacionC));
        $urlSelected = isset($_SERVER['REDIRECT_QUERY_STRING']) ? site_url($_SERVER['REDIRECT_QUERY_STRING']) : NULL;
        if (! Util::isVacio($object->getListHijosMenus())) {
            $firtMenu = Arr::current($object->getListHijosMenus());
            $htmlMenu .= "<ul class='" . (Util::isVacio($firtMenu->getId_menu_padre()) ? 'nav metismenu' : 'nav nav-second-level collapse') . "' " . (Util::isVacio($firtMenu->getId_menu_padre()) ? 'id="side-menu"' : '') . ">";
            if ($capture) {
                $htmlMenu .= $this->getUlPerfil();
            }
            foreach ($object->getListHijosMenus() as $lis) {
                $lis->setMenuPadreDto($object);
                $listHijosMenus = array();
                if (Util::isVacio($lis->getMenuPadreDto()->getId_menu_padre())) {
                    $listHijosMenus = $this->getListMenusHijos($lis->getId_menu());
                }
                $tieneHijos = ! Util::isVacio($listHijosMenus);
                $object->setListHijosMenus($listHijosMenus);
                $selected = $object->getMenuSeleccionado($urlSelected);
                $urlC = (Util::isVacio($lis->getUrl()) || $lis->getUrl() == '#') ? "javascript:void(0);" : site_url($lis->getUrl());
                $activeClass = ($urlSelected == $urlC || $selected) ? 'class="active"' : NULL;
                $htmlMenu .= '<li ' . $activeClass . '>';
                $htmlMenu .= '<a id="menu' . $lis->getId_menu() . '" data-id_menu_padre="' . $lis->getId_menu_padre() . '" href="' . $urlC . '"  class="' . ($tieneHijos ? "dropdown-toggle " : '') . '" target="' . ETarget::result($lis->getTarget())->getDescription() . '">';
                $htmlMenu .= '<i class="' . $lis->getClass_icon() . '"></i>&nbsp;';
                $htmlMenu .= '<span class="nav-label">' . $lis->getNombre() . '</span>';
                if ($tieneHijos) {
                    $htmlMenu .= '&nbsp;<span class="fa arrow"></span>';
                }
                $htmlMenu .= '</a>';
                $htmlMenu .= $this->getDrawMenuPrincipal($lis, $lis->getId_menu(), $idUsuarioC, $ubicacionC, FALSE);
                $htmlMenu .= '</li>';
            }
            $htmlMenu .= "</ul>";
        }
        
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Method Description: guarda un menu en la tabla correspondiente
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 9, 2016}
     * @param UsuarioMenuDto $usuarioMenuDto            
     * @return Ambigous <boolean, number>
     */
    public function setCreateEditMenu($usuarioMenuDto)
    {
        try {
            $return = FALSE;
            $arrayMenu['nombre'] = $usuarioMenuDto->getNombre();
            $arrayMenu['url'] = $usuarioMenuDto->getUrl();
            $arrayMenu['id_menu_padre'] = $usuarioMenuDto->getId_menu_padre();
            $arrayMenu['ubicacion'] = $usuarioMenuDto->getUbicacion();
            $arrayMenu['class_icon'] = $usuarioMenuDto->getClass_icon();
            $arrayMenu['visualizar_en'] = $usuarioMenuDto->getVisualizar_en();
            $arrayMenu['target'] = $usuarioMenuDto->getTarget();
            $arrayMenu['yn_activo'] = $usuarioMenuDto->getYn_activo();
            if (Util::isVacio($usuarioMenuDto->getId_menu())) {
                $return = Doctrine::insert('usuario_menu', $arrayMenu);
            } else {
                $return = Doctrine::update('usuario_menu', $arrayMenu, [
                    'id_menu' => $usuarioMenuDto->getId_menu()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $return ? $usuarioMenuDto->getNombre() : $return;
    }

    /**
     *
     * @tutorial Metodo Descripcion: pinta los options de un select para los menus disponibles
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 14/04/2015
     * @param string $idMenuSelected            
     * @return string
     */
    public function getOptionsMenus($idMenuSelected = NULL)
    {
        $return = NULL;
        $listaMenu = $this->getConsultaSoloMenu(NULL, 0);
        foreach ($listaMenu as $lis) {
            $selected = ($lis->getId_menu() == $idMenuSelected) ? 'selected="selected"' : NULL;
            $return .= '<option value = "' . $lis->getId_menu() . '" ' . $selected . '>' . $lis->getNombre() . '</option>';
            $return .= $this->getDrawOptionsMenus($lis->getId_menu(), NULL, $idMenuSelected);
        }
        return $return;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los menus hijos y pinta los options para el select
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 7/04/2015
     * @param string $idMenuC            
     * @param string $tabC            
     * @return string
     */
    public function getDrawOptionsMenus($idMenuC = NULL, $tabC = NULL, $idMenuSelected = NULL)
    {
        $tabC .= "&nbsp;&nbsp;&nbsp;&nbsp;";
        $sel = "";
        $htmlSubMenu = "";
        $listaSubMenu = $this->getConsultaSoloMenu(NULL, $idMenuC);
        foreach ($listaSubMenu as $lis) {
            $style = '';
            if ($lis->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) {
                $style = 'style="color:#999; font-size: 8px !important; text-decoration:line-through !important;"';
            }
            $selected = ($lis->getId_menu() == $idMenuSelected) ? 'selected="selected"' : NULL;
            $htmlSubMenu .= '<option value="' . $lis->getId_menu() . '"' . $style . ' ' . $selected . '>' . $tabC . $lis->getNombre() . '</option>';
            $htmlSubMenu .= $this->getDrawOptionsMenus($lis->getId_menu(), $tabC, $idMenuSelected);
        }
        return $htmlSubMenu;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {27/09/2015}
     * @param string $idMenuC            
     * @return string
     */
    public function setDrawMenuList($idMenuC = 0)
    {
        $htmlMenu = "";
        $listaMenu = $this->getConsultaSoloMenu(NULL, $idMenuC);
        if (count($listaMenu) > 0) {
            $firtMenu = Arr::current($listaMenu);
            $htmlMenu .= "<ol style='list-style-type: none'>";
            foreach ($listaMenu as $lis) {
                $style = '';
                if ($lis->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) {
                    $style = 'color:#999; text-decoration:line-through;';
                }
                $htmlMenu .= '<li>';
                $htmlMenu .= '<a href="javascript:void(0);" style="' . $style . '" data-id_menu="' . $lis->getId_menu() . '" class="classEditMenu">';
                $htmlMenu .= '<i class="' . $lis->getClass_icon() . '"></i>';
                $htmlMenu .= '&nbsp;<span>' . $lis->getNombre() . '</span>';
                $htmlMenu .= '</a>';
                
                $htmlMenu .= $this->setDrawMenuList($lis->getId_menu());
                $htmlMenu .= '</li>';
            }
            $htmlMenu .= "</ol>";
        }
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 14/04/2015
     *       
     * @return string
     */
    public function getDrawJTree()
    {
        $rutaServer = $_SERVER['DOCUMENT_ROOT'] . str_replace("controller.php", "", $_SERVER['PHP_SELF']) . lang('SC_RAIZ_MODULOS');
        ;
        return $this->setJTreeMenu($rutaServer, 0, $rutaServer);
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 14/04/2015
     *       
     * @param string $directorioC            
     * @param number $cont            
     * @param string $urlC            
     * @return string
     */
    public function setJTreeMenu($directorioC = NULL, $cont = 0, $urlC = NULL)
    {
        $jTreeHTML = "";
        $class = "";
        if (is_dir($directorioC)) {
            $cifrado = Util::setMd5(rand());
            if ($dir = Util::setOpenDirectorio($directorioC)) {
                $jTreeHTML .= '<ul style="display: none;">';
                while (($file = Util::setReadDirectorio($dir)) !== false) {
                    if ($file != "." && $file != "..") {
                        $cifrado = Util::setMd5(rand());
                        $jTreeTempHTML = $this->setJTreeMenu($directorioC . $file . "/", ($cont + 1), $urlC);
                        $class = "";
                        $funcion = "";
                        $jTreeHTML .= '<li>';
                        $jTreeHTML .= '<span>' . $file . '</span>';
                        $jTreeHTML .= $jTreeTempHTML;
                        $jTreeHTML .= '</li>';
                    }
                }
                $jTreeHTML .= '</ul>';
            }
        }
        return $jTreeHTML;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los permisos asociados a un usuario
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     * @param string $idUsuarioC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilPermisoDto
     */
    public function getUsuarioPerfilPermiso($idUsuarioC = NULL, $idMenuC = NULL)
    {
        try {
            $result = array();
            $sql = "SELECT DISTINCT
                        men.nombre AS nombreMenu,
                        men.url AS urlMenu,
                        per.*
                    FROM usuario_menu men
                        INNER JOIN usuario_perfil_permiso per
                            ON per.id_menu = men.id_menu
                                AND men.yn_activo = " . ESiNo::index(ESiNo::SI)->getId() . "
                        INNER JOIN usuario_perfil upe
                            ON upe.id_perfil = per.id_perfil
                                AND upe.yn_activo = " . ESiNo::index(ESiNo::SI)->getId() . "
                        INNER JOIN usuario_perfil_asignado upa
                            ON upa.id_perfil = upe.id_perfil
                                AND upa.id_usuario = :idUsuarioC
                    WHERE men.url IS NOT NULL";
            $arrayParams[':idUsuarioC'] = $idUsuarioC;
            if (! Util::isVacio($idMenuC)) {
                $sql .= " AND men.id_menu = :idMenuC";
                $arrayParams['idMenuC'] = $idMenuC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilPermisoDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: organiza el menu horizontal
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param string $idUsuarioC            
     * @param string $idMenuC            
     * @param array $ignoreArray            
     * @param array $variablesAdicionalesC            
     * @param array $aOptions            
     * @return multitype:string NULL
     */
    public function getMenuHorizontal($idUsuarioC = NULL, $idMenuC = NULL)
    {
        $menuPadre = $this->getConsultaSoloMenu($idMenuC);
        $menuPadre = Arr::current($menuPadre);
        $menuPadre = $menuPadre instanceof UsuarioMenuDto ? $menuPadre : new UsuarioMenuDto();
        $menuHorizontal = $this->setDrawMenuHorizontal($idMenuC, $idUsuarioC, EUbicacion::index(EUbicacion::HORIZONTAL)->getId());
        $contentHeader = '<div class="col-lg-12">';
        $contentHeader .= '<h2>' . title($menuPadre->getNombre()) . '</h2>';
        $contentHeader .= '<ol class="breadcrumb">';
        $contentHeader .= '<li>';
        $contentHeader .= '<a href="' . site_url() . '">Home</a>';
        $contentHeader .= '</li>';
        $contentHeader .= '<li>';
        $contentHeader .= '<a href="#">' . title($menuPadre->getNombre()) . '</a>';
        $contentHeader .= '</li>';
        $contentHeader .= '<li class="active">';
        $contentHeader .= '<strong id="menu-active"></strong>';
        $contentHeader .= '</li>';
        $contentHeader .= '</ol>';
        $contentHeader .= '</div>';
        return [
            'contentDefault' => $menuPadre->getVisualizar_en(),
            'menuHorizontal' => $menuHorizontal,
            'contentHeader' => $contentHeader
        ];
    }

    /**
     *
     * @tutorial obtiene el menu vertical por usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $paramC            
     * @param string $idMenuC            
     * @param unknown $idUsuarioC            
     * @param string $urlFinalC            
     * @param string $ubicacionC            
     * @return Ambigous <NULL, string>
     */
    public function setDrawMenuHorizontal($idMenuC = NULL, $idUsuarioC, $ubicacionC = NULL)
    {
        $htmlMenu = NULL;
        $listaMenus = $this->getUserMenus($idMenuC, $idUsuarioC, $ubicacionC);
        if (! Util::isVacio($listaMenus)) {
            $firtMenu = Arr::current($listaMenus);
            $htmlMenu .= "<ul class=\"sky-mega-menu sky-mega-menu-anim-flip sky-mega-menu-response-to-icons\">";
            foreach ($listaMenus as $lis) {
                $tieneHijos = $this->setChildrenMenus($lis->getId_menu());
                $urlC = (Util::isVacio($lis->getUrl()) || $lis->getUrl() == '#') ? "javascript:void(0);" : base_url($lis->getUrl());
                $htmlMenu .= '<li ' . ($tieneHijos ? 'aria-haspopup="true"' : '') . '>';
                $htmlMenu .= '<a href="#" class="a_menu_horizontal_json" data-pagina="' . site_url($lis->getUrl()) . '" data-contenedor="' . $lis->getVisualizar_en() . '" data-id_smenu="' . $lis->getId_menu() . '">';
                $htmlMenu .= '<i class="' . $lis->getClass_icon() . '"></i>';
                $htmlMenu .= $lis->getNombre();
                $htmlMenu .= '</a>';
                if ($tieneHijos) {
                    $htmlMenu .= '<div class="grid-container3">';
                }
                $htmlMenu .= $this->setDrawMenuHorizontal($lis->getId_menu(), $idUsuarioC, $ubicacionC);
                if ($tieneHijos) {
                    $htmlMenu .= '</div>';
                }
                $htmlMenu .= '</li>';
            }
            $htmlMenu .= "</ul>";
        }
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion: dibuja el menu al lado de checkbox
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/04/2015
     * @param integer $idMenuC            
     * @param integer $idPerfilC            
     * @param array $arrayC            
     * @return string
     */
    public function setDrawMenuChek($idMenuC, $arrayC = array())
    {
        $htmlMenu = "";
        $listaMenus = $this->getUserMenus($idMenuC, NULL, NULL, NULL, NULL, 'menu.nombre ASC');
        if (! Util::isVacio($listaMenus)) {
            $htmlMenu .= "<ul style='list-style: none;'>";
            foreach ($listaMenus as $lis) {
                $style = '';
                if ($lis->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) {
                    $style = 'color: #999;';
                }
                $sNombreFormateado = '<span style="font-weight: bold;">' . $lis->getNombre() . '</span>';
                if ($lis->getId_menu_padre() * 1 > 0) {
                    $sNombreFormateado = $lis->getNombre();
                }
                $view = ! Arr::isNullArray($lis->getId_menu(), $arrayC) ? $arrayC[$lis->getId_menu()]['view'] : NULL;
                $htmlMenu .= '<li style="margin:0; padding: 2px 0px 2px 0px;">';
                $htmlMenu .= '<div class="i-checks">';
                $htmlMenu .= '<label>';
                $htmlMenu .= '<input class="chkAll" type="checkbox" ' . $view . ' value="' . $lis->getId_menu() . '" style="' . $style . '" name="txtMenu[]" id="txtMenu_' . $lis->getId_menu() . '" />&nbsp;';
                $htmlMenu .= $sNombreFormateado;
                $htmlMenu .= '</label>';
                $htmlMenu .= '</div>';
                $htmlMenu .= $this->setDrawMenuChek($lis->getId_menu(), $arrayC);
                $htmlMenu .= '</li>';
            }
            $htmlMenu .= "</ul>";
        }
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     * @param unknown $array            
     * @return string
     */
    public function setDrawModulesChek($array = array())
    {
        $htmlMenu = "";
        $listaMenu = $this->getUserMenus(0, NULL, NULL, NULL, NULL, 'menu.nombre ASC');
        if (! Util::isVacio($listaMenu)) {
            Html::startHtml();
            ?>
<table class="table table-striped" id="tablePerfilMenu">
	<thead>
		<tr>
			<th><?php echo lang('perfil.modulo'); ?></th>
			<th class="text-center"><?php echo lang('perfil.permiso_view'); ?></th>
			<th class="text-center"><?php echo lang('perfil.permiso_add'); ?></th>
			<th class="text-center"><?php echo lang('perfil.permiso_edit'); ?></th>
			<th class="text-center"><?php echo lang('perfil.permiso_del'); ?></th>
		</tr>
	</thead>
	<tbody>
                    <?php
            $htmlMenu .= Html::stopHtml();
            foreach ($listaMenu as $key => $lis) {
                $nombreFormateado = '<span style="font-weight: bold;">' . $lis->getNombre() . '</span>';
                if ($lis->getId_menu_padre() * 1 > 0) {
                    $nombreFormateado = $lis->getNombre();
                }
                Html::startHtml();
                $classHide = (empty($array[$lis->getId_menu()])) ? 'display: none;' : '';
                ?>
                            <tr id="txtFilaMenu<?php echo $lis->getId_menu(); ?>" style="<?php echo $classHide; ?>">
			<td nowrap="nowrap"><label><?php echo $nombreFormateado; ?></label></td>
			<td align="center" nowrap="nowrap">
				<div class="i-checks" data-cclass="icheckbox_square-blue">
					<label for="<?php echo "txtYn_view_$key"; ?>"> 
                                            <?php
                echo Form::checkbox('txtYn_view[]', $lis->getId_menu(), TRUE, [
                    'id' => "txtYn_view_$key"
                ]);
                ?>
                                            <i></i>
					</label>
				</div>
			</td>
			<td align="center" nowrap="nowrap">
				<div class="i-checks" data-cclass="icheckbox_square-red">
					<label for="<?php echo "txtYn_add_$key"; ?>"> 
                                            <?php
                echo Form::checkbox('txtYn_add[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_add_$key"
                ]);
                ?>
                                            <i></i>
					</label>
				</div>
			</td>
			<td align="center" nowrap="nowrap">
				<div class="i-checks" data-cclass="icheckbox_square-orange">
					<label for="<?php echo "txtYn_edit_$key"; ?>"> 
                                            <?php
                echo Form::checkbox('txtYn_edit[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_edit_$key"
                ]);
                ?>
                                            <i></i>
					</label>
				</div>
			</td>
			<td align="center" nowrap="nowrap">
				<div class="i-checks" data-cclass="icheckbox_square-purple">
					<label for="<?php echo "txtYn_del$key"; ?>"> 
                                            <?php
                echo Form::checkbox('txtYn_del[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_del_$key"
                ]);
                ?>
                                            <i></i>
					</label>
				</div>
			</td>
		</tr>
                            <?php
                $htmlMenu .= Html::stopHtml();
                $htmlMenu .= $this->setDrawSubModulesChek($lis->getId_menu(), $lis->getNombre() . ' > ', $array);
            }
            Html::startHtml();
            ?>
                    </tbody>
</table>
<?php
            $htmlMenu .= Html::stopHtml();
        }
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     * @param unknown $idMenuC            
     * @param unknown $padreName            
     * @param unknown $arrayC            
     * @return string
     */
    private function setDrawSubModulesChek($idMenuC, $padreName, $arrayC = array())
    {
        $htmlMenu = '';
        $listaMenu = $this->getUserMenus($idMenuC);
        if (! Util::isVacio($listaMenu)) {
            foreach ($listaMenu as $key => $lis) {
                Html::startHtml();
                $style = (empty($arrayC[$lis->getId_menu()])) ? 'display:none;' : '';
                ?>
<tr id="txtFilaMenu<?php echo $lis->getId_menu(); ?>" style="<?php echo $style; ?>">
	<td nowrap="nowrap"><label>
                            <?php echo $padreName . $lis->getNombre(); ?>
                        </label></td>
	<td align="center" width="70">
		<div class="i-checks" data-cclass="icheckbox_square-blue">
			<label for="<?php echo "txtYn_view_$key"; ?>"> 
                                <?php
                echo Form::checkbox('txtYn_view[]', $lis->getId_menu(), TRUE, [
                    'id' => "txtYn_view_$key"
                ]);
                ?>
                                <i></i>
			</label>
		</div>
	</td>
	<td align="center" width="70">
		<div class="i-checks" data-cclass="icheckbox_square-red">
			<label for="<?php echo "txtYn_view_$key"; ?>"> 
                                <?php
                echo Form::checkbox('txtYn_add[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_add_$key",
                    'class' => ''
                ]);
                ?>
                                <i></i>
			</label>
		</div>
	</td>
	<td align="center" width="70">
		<div class="i-checks" data-cclass="icheckbox_square-orange">
			<label for="<?php echo "txtYn_view_$key"; ?>"> 
                                <?php
                echo Form::checkbox('txtYn_edit[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_edit_$key",
                    'class' => ''
                ]);
                ?>
                                <i></i>
			</label>
		</div>
	</td>
	<td align="center" width="70">
		<div class="i-checks" data-cclass="icheckbox_square-purple">
			<label for="<?php echo "txtYn_view_$key"; ?>"> 
                                <?php
                echo Form::checkbox('txtYn_del[]', $lis->getId_menu(), FALSE, [
                    'id' => "txtYn_del_$key",
                    'class' => ''
                ]);
                ?>
                                <i></i>
			</label>
		</div>
	</td>
</tr>
<?php
                $htmlMenu .= Html::stopHtml();
                $htmlMenu .= $this->setDrawSubModulesChek($lis->getId_menu(), $padreName . $lis->getNombre() . " > ", $arrayC);
            }
        }
        return $htmlMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta el menu padre
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param string $idMenuC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioMenuDto
     */
    public function getConsultaSoloMenu($idMenuC = NULL, $idMenuPadreC = null, $activoC = false)
    {
        try {
            $arrayParams = array();
            $result = array();
            $sql = "SELECT menu.* FROM  usuario_menu menu WHERE 1 ";
            if (! Util::isVacio($idMenuC)) {
                $sql .= " AND menu.id_menu = :idMenuC ";
                $arrayParams[':idMenuC'] = $idMenuC;
            }
            if (! Util::isVacio($idMenuPadreC)) {
                $sql .= " AND COALESCE(menu.id_menu_padre, 0) = :idMenuPadreC ";
                $arrayParams[':idMenuPadreC'] = $idMenuPadreC;
            }
            if ($activoC) {
                $sql .= " AND menu.yn_activo = :activoC ";
                $arrayParams[':activoC'] = ESiNo::index(ESiNo::SI)->getId();
            }
            $sql .= "ORDER BY menu.orden ASC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioMenuDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 6, 2016}
     * @param number $idMenuPadreC            
     * @param string $idUsuarioC            
     * @param string $ubicacionC            
     * @param string $ynActivoC            
     * @param string $idMenuC            
     * @param string $orderBy            
     * @throws Exception
     * @return multitype:\app\dtos\UsuarioMenuDto
     */
    public function getUserMenus($idMenuPadreC = 0, $idUsuarioC = NULL, $ubicacionC = NULL, $ynActivoC = TRUE, $idMenuC = NULL, $orderBy = 'menu.orden')
    {
        $result = array();
        $arrayParams = array();
        try {
            $sql = "SELECT menu.* FROM usuario_menu menu INNER JOIN usuario_perfil_permiso upp ON upp.id_menu = menu.id_menu AND upp.yn_view = 1 ";
            if (! Util::isVacio($ubicacionC)) {
                $sql .= " AND menu.ubicacion = :ubicacionC ";
                $arrayParams[':ubicacionC'] = $ubicacionC;
            }
            if ($ynActivoC) {
                $sql .= " AND menu.yn_activo = :ynActivoA ";
                $arrayParams[':ynActivoA'] = ESiNo::index(ESiNo::SI)->getId();
            }
            $sql .= "INNER JOIN usuario_perfil perfil
                        ON perfil.id_perfil = upp.id_perfil
                    INNER JOIN usuario_perfil_asignado upa
                        ON upa.id_perfil = perfil.id_perfil
                WHERE 1 ";
            if (! Util::isVacio($idMenuPadreC)) {
                $sql .= " AND COALESCE(menu.id_menu_padre, 0) = :idMenuPadreC ";
                $arrayParams[':idMenuPadreC'] = $idMenuPadreC;
            }
            if (! Util::isVacio($idMenuC)) {
                $sql .= " AND COALESCE(menu.id_menu, 0) = :idMenuC ";
                $arrayParams[':idMenuC'] = $idMenuC;
            }
            if ($ynActivoC) {
                $sql .= " AND perfil.yn_activo = :ynActivoB ";
                $arrayParams[':ynActivoB'] = ESiNo::index(ESiNo::SI)->getId();
            }
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND upa.id_usuario = :idUsuarioC ";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
            $sql .= " ORDER BY $orderBy";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioMenuDto();
                Util::setObjectRow($object, $row);
                $result[$object->getId_menu()] = $object;
                unset($object);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param string $idMenuC            
     * @throws Exception
     * @return boolean
     */
    public function setChildrenMenus($idMenuC = NULL)
    {
        try {
            $sql = "SELECT COUNT(ume.id_menu) AS cantidadHijos FROM usuario_menu ume WHERE ume.id_menu_padre = :idMenuC AND ume.ubicacion = :ubicacionC ";
            $arrayParams[':idMenuC'] = $idMenuC;
            $arrayParams[':ubicacionC'] = EUbicacion::index(EUbicacion::VERTICAL)->getId();
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetch();
        } catch (\Exception $e) {
            throw $e;
        }
        return ($list['cantidadHijos'] > 0);
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param string $idMenuC            
     * @throws Exception
     * @return boolean
     */
    public function getListMenusHijos($idMenuC = NULL)
    {
        try {
            $result = array();
            $sql = "SELECT ume.url FROM usuario_menu ume WHERE ume.id_menu_padre = :idMenuC AND ume.ubicacion = :ubicacionC ";
            $arrayParams[':idMenuC'] = $idMenuC;
            $arrayParams[':ubicacionC'] = EUbicacion::index(EUbicacion::VERTICAL)->getId();
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $lis) {
                $object = new UsuarioMenuDto();
                Util::setObjectRow($object, $lis);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param string $idUsuarioC            
     * @param string $idMenuC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilPermisoDto
     */
    public function getPermisosMenuUsuario($idUsuarioC = NULL, $idMenuC = NULL)
    {
        try {
            $result = array();
            $sql = "SELECT
                        per.*
                    FROM usuario_perfil_permiso per
                        INNER JOIN usuario_perfil_asignado upe
                            ON upe.id_perfil = per.id_perfil
                        INNER JOIN usuario_menu men
                            ON men.id_menu = per.id_menu
                                AND men.yn_activo = :ynActivoC
                    WHERE per.id_menu = :idMenuC
                        AND upe.id_usuario = :idUsuarioC";
            $arrayParams[':ynActivoC'] = ESiNo::index(ESiNo::SI)->getId();
            $arrayParams[':idMenuC'] = $idMenuC;
            $arrayParams[':idUsuarioC'] = $idUsuarioC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilPermisoDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: verifica los permisos que tiene un usuario sobre un menu
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param integer $idUsuarioC            
     * @param string $idMenuC            
     * @return Ambigous <number, string>
     */
    public function setValidarPermisos($idUsuarioC, $idMenuC = NULL)
    {
        $permisosMenu = new PermisosMenuDto();
        $listaPermisos = $this->getPermisosMenuUsuario($idUsuarioC, $idMenuC);
        foreach ($listaPermisos as $per) {
            if ($per->getYn_view() == ESiNo::index(ESiNo::SI)->getId()) {
                $permisosMenu->setView($per->getYn_view());
                $permisosMenu->setClassView('fa fa-search-plus fa-2x');
                $permisosMenu->setIconView(NULL);
            }
            if ($per->getYn_edit() == ESiNo::index(ESiNo::SI)->getId()) {
                $permisosMenu->setEdit($per->getYn_view());
                $permisosMenu->setClassEdit('fa fa-edit fa-2x');
                $permisosMenu->setIconEdit(NULL);
            }
            if ($per->getYn_add() == ESiNo::index(ESiNo::SI)->getId()) {
                $permisosMenu->setAdd($per->getYn_add());
                $permisosMenu->setClassAdd('fa fa-plus-square fa-2x');
                $permisosMenu->setIconAdd(NULL);
            }
            if ($per->getYn_delete() == ESiNo::index(ESiNo::SI)->getId()) {
                $permisosMenu->setDelete($per->getYn_delete());
                $permisosMenu->setClassDelete('fa fa-trash-o fa-2x red-text text-darken-4');
                $permisosMenu->setIconDelete(NULL);
            }
        }
        return $permisosMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los iconos
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/04/2015
     *       
     * @param string $classC            
     * @param integer $limitC            
     * @throws \Exception
     * @return multitype:\app\dtos\ClassIconsDto
     */
    public function getClassIcons($classC = NULL, $limitC = NULL)
    {
        try {
            $result = array();
            $sql = 'SELECT * FROM class_icon WHERE class LIKE :nombreC ';
            $arrayParams[':nombreC'] = "%" . $classC . "%";
            if (! Util::isVacio($limitC)) {
                $sql .= "LIMIT 0, $limitC";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClassIconsDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 4/05/2015
     *       
     * @param integer $idPerfilC            
     * @param integer $idMenuC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilPermisoDto
     */
    private function getPermisosPerfil($idPerfilC, $idMenuC)
    {
        try {
            $result = array();
            $sql = "SELECT * FROM usuario_perfil_permiso WHERE id_perfil = :idPerfilC AND id_menu = :idMenuC LIMIT 1 ";
            $arrayParams[':idPerfilC'] = $idPerfilC;
            $arrayParams[':idMenuC'] = $idMenuC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilPermisoDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: crea un arbol de los menus creados
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 4/05/2015
     *       
     * @param integer $idMenuPadreC            
     * @param integer $idPerfilC            
     * @param integer $nivelMenuC            
     * @param array $arrayDataC            
     */
    public function setArbolMenus($idMenuPadreC, $idPerfilC, $nivelMenuC, &$arrayDataC)
    {
        $listaMenu = $this->getConsultaSoloMenu(NULL, $idMenuPadreC, true);
        if (count($listaMenu) > 0) {
            $nivelMenuC ++;
            foreach ($listaMenu as $keyMenu => $lis) {
                $sNombreFormateado = "<span class='nivel_menu{$nivelMenuC}'>{$lis->getNombre()}</span>";
                $lis->setNombre($sNombreFormateado);
                $permisosPerfil = $this->getPermisosPerfil($idPerfilC, $lis->getId_menu());
                $permisoDto = Arr::current($permisosPerfil);
                if (! Arr::current($permisosPerfil)) {
                    $noPermit = ESiNo::index(ESiNo::NO)->getId();
                    $permisoDto = new UsuarioPerfilPermisoDto();
                    $permisoDto->setYn_add($noPermit);
                    $permisoDto->setYn_delete($noPermit);
                    $permisoDto->setYn_edit($noPermit);
                    $permisoDto->setYn_view($noPermit);
                }
                $lis->setPerfilPermisoDto($permisoDto);
                $lis->setNivelMenu($nivelMenuC);
                $arrayDataC[] = $lis;
                $this->setArbolMenus($lis->getId_menu(), $idPerfilC, $nivelMenuC, $arrayDataC);
            }
        }
    }
}