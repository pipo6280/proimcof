<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 2/04/2015
 */
class UsuarioPerfilPermisoDto
{

    protected $id_perfil;

    protected $id_menu;

    protected $yn_view;

    protected $yn_edit;

    protected $yn_add;

    protected $yn_delete;

    protected $nombreMenu;

    protected $urlMenu;

    public function __construct()
    {
        $this->id_menu = NULL;
        $this->id_perfil = NULL;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getId_perfil()
    {
        return $this->id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getYn_view()
    {
        return $this->yn_view;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getYn_edit()
    {
        return $this->yn_edit;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getYn_add()
    {
        return $this->yn_add;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getYn_delete()
    {
        return $this->yn_delete;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getNombreMenu()
    {
        return $this->nombreMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function getUrlMenu()
    {
        return $this->urlMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setId_perfil($id_perfil)
    {
        $this->id_perfil = $id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setYn_view($yn_view)
    {
        $this->yn_view = $yn_view;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setYn_edit($yn_edit)
    {
        $this->yn_edit = $yn_edit;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setYn_add($yn_add)
    {
        $this->yn_add = $yn_add;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setYn_delete($yn_delete)
    {
        $this->yn_delete = $yn_delete;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setNombreMenu($nombreMenu)
    {
        $this->nombreMenu = $nombreMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     */
    public function setUrlMenu($urlMenu)
    {
        $this->urlMenu = $urlMenu;
    }
}