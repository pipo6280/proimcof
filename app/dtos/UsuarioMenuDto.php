<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class UsuarioMenuDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_menu;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @var integer
     */
    protected $id_menu_padre;

    /**
     *
     * @var smallint
     */
    protected $ubicacion;

    /**
     *
     * @var string
     */
    protected $class_icon;

    /**
     *
     * @var smallint
     */
    protected $visualizar_en;

    /**
     *
     * @var smallint
     */
    protected $target;

    /**
     *
     * @var smallint
     */
    protected $orden;

    /**
     *
     * @var smallint
     */
    protected $yn_activo;

    /**
     *
     * @var string
     */
    protected $classEstado;

    /**
     *
     * @var string
     */
    protected $titleEstado;

    /**
     *
     * @var string
     */
    protected $nivelMenu;

    /**
     *
     * @var UsuarioPerfilPermisoDto
     */
    protected $perfilPermisoDto;

    /**
     *
     * @var array
     */
    protected $listMenus;

    /**
     *
     * @var array
     */
    protected $listHijosMenus;

    /**
     *
     * @var array
     */
    protected $valores;

    /**
     *
     * @var UsuarioMenuDto
     */
    protected $menuPadreDto;

    public function __construct()
    {
        parent::__construct();
        
        $this->id_menu = NULL;
        $this->classEstado = NULL;
        $this->listMenus = array();
        $this->listHijosMenus = array();
        $this->perfilPermisoDto = new UsuarioPerfilPermisoDto();
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param string $urlSelected            
     * @return boolean
     */
    public function getMenuSeleccionado($urlSelected)
    {
        $result = false;
        foreach ($this->listHijosMenus as $lis) {
            if (site_url($lis->url) == $urlSelected) {
                $result = true;
                break;
            } else {
                $result = $lis->getMenuSeleccionado($urlSelected);
                if ($result) {
                    break;
                }
            }
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getId_menu_padre()
    {
        return $this->id_menu_padre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getClass_icon()
    {
        return $this->class_icon;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getVisualizar_en()
    {
        return $this->visualizar_en;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getClassEstado()
    {
        return $this->classEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getTitleEstado()
    {
        return $this->titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getNivelMenu()
    {
        return $this->nivelMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getPerfilPermisoDto()
    {
        return $this->perfilPermisoDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getListMenus()
    {
        return $this->listMenus;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getListHijosMenus()
    {
        return $this->listHijosMenus;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getValores()
    {
        return $this->valores;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function getMenuPadreDto()
    {
        return $this->menuPadreDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setId_menu_padre($id_menu_padre)
    {
        $this->id_menu_padre = $id_menu_padre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setClass_icon($class_icon)
    {
        $this->class_icon = $class_icon;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setVisualizar_en($visualizar_en)
    {
        $this->visualizar_en = $visualizar_en;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setClassEstado($classEstado)
    {
        $this->classEstado = $classEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setTitleEstado($titleEstado)
    {
        $this->titleEstado = $titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setNivelMenu($nivelMenu)
    {
        $this->nivelMenu = $nivelMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setPerfilPermisoDto($perfilPermisoDto)
    {
        $this->perfilPermisoDto = $perfilPermisoDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setListMenus($listMenus)
    {
        $this->listMenus = $listMenus;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setListHijosMenus($listHijosMenus)
    {
        $this->listHijosMenus = $listHijosMenus;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setValores($valores)
    {
        $this->valores = $valores;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     */
    public function setMenuPadreDto($menuPadreDto)
    {
        $this->menuPadreDto = $menuPadreDto;
    }
}