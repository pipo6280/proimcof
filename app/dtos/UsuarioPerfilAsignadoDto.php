<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class UsuarioPerfilAsignadoDto
{

    protected $id_usuario;

    protected $id_perfil;

    protected $perfilDto;

    public function __construct()
    {
        $this->perfilDto = new UsuarioPerfilDto();
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function getId_perfil()
    {
        return $this->id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function getPerfilDto()
    {
        return $this->perfilDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function setId_perfil($id_perfil)
    {
        $this->id_perfil = $id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 5/05/2015
     */
    public function setPerfilDto($perfilDto)
    {
        $this->perfilDto = $perfilDto;
    }
}