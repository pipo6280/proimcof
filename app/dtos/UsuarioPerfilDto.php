<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class UsuarioPerfilDto extends ADto
{

    protected $id_perfil;

    protected $nombre;

    protected $yn_activo;

    protected $classEstado;

    protected $titleEstado;

    protected $listPerfiles;

    protected $menuCheck;

    protected $moduleCheck;

    protected $arbolMenu;

    public function __construct()
    {
        $this->listPerfiles = array();
        $this->arbolMenu = array();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     * @return \app\dtos\UsuarioPerfilDto
     * @see \app\dtos\ADto::getDto()
     */
    public function getDto()
    {
        if ($this->dto == NULL) {
            $this->dto = new UsuarioPerfilDto();
        }
        return $this->dto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function getId_perfil()
    {
        return $this->id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setId_perfil($id_perfil)
    {
        $this->id_perfil = $id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/10/2015}
     * @return multitype:
     */
    public function getListPerfiles()
    {
        return $this->listPerfiles;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/10/2015}
     * @param multitype: $listPerfiles            
     */
    public function setListPerfiles($listPerfiles)
    {
        $this->listPerfiles = $listPerfiles;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {7/10/2015}
     * @return field_type
     */
    public function getMenuCheck()
    {
        return $this->menuCheck;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {7/10/2015}
     * @param field_type $menuCheck            
     */
    public function setMenuCheck($menuCheck)
    {
        $this->menuCheck = $menuCheck;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {7/10/2015}
     * @return field_type
     */
    public function getModuleCheck()
    {
        return $this->moduleCheck;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {7/10/2015}
     * @param field_type $moduleCheck            
     */
    public function setModuleCheck($moduleCheck)
    {
        $this->moduleCheck = $moduleCheck;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {11/10/2015}
     * @return multitype:
     */
    public function getArbolMenu()
    {
        return $this->arbolMenu;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {11/10/2015}
     * @param multitype: $arbolMenu            
     */
    public function setArbolMenu($arbolMenu)
    {
        $this->arbolMenu = $arbolMenu;
    }
}