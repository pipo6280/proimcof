<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class UsuarioPerfilMenuDto
{

    protected $id_perfil_menu;

    protected $id_perfil;

    protected $id_menu;

    protected $orden;

    protected $ubicacion;

    public function __construct()
    {
        $this->id_perfil_menu = NULL;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function getId_perfil_menu()
    {
        return $this->id_perfil_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function getId_perfil()
    {
        return $this->id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function setId_perfil_menu($id_perfil_menu)
    {
        $this->id_perfil_menu = $id_perfil_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function setId_perfil($id_perfil)
    {
        $this->id_perfil = $id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 29/03/2015
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }
}