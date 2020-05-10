<?php
namespace app\dtos;

use app\enums\ESiNo;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class UsuarioDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_usuario;

    /**
     *
     * @var string
     */
    protected $loggin;

    /**
     *
     * @var md5
     */
    protected $password;

    /**
     *
     * @var integer
     */
    protected $id_persona;

    /**
     *
     * @var smallint
     */
    protected $yn_activo;

    /**
     *
     * @var smalint
     */
    protected $yn_ingreso;

    /**
     *
     * @var \DateTime
     */
    protected $fecha_creacion;

    /**
     *
     * @var \DateTime
     */
    protected $fecha_modificacion;

    /**
     *
     * @var integer
     */
    protected $id_perfil;

    /**
     *
     * @var array
     */
    protected $listProfiles;

    /**
     *
     * @var PersonaDto
     */
    protected $personaDto;

    public function __construct()
    {
        parent::__construct();
        $this->id_usuario = NULL;
        $this->id_perfil = NULL;
        $this->listProfiles = array();
        $this->personaDto = new PersonaDto();
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getLoggin()
    {
        return $this->loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2017}
     */
    public function getUsuario() {
        
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getId_persona()
    {
        return $this->id_persona;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getYn_ingreso()
    {
        return $this->yn_ingreso;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getId_perfil()
    {
        return $this->id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getListProfiles()
    {
        return $this->listProfiles;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPersonaDto()
    {
        return $this->personaDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setLoggin($loggin)
    {
        $this->loggin = $loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setId_persona($id_persona)
    {
        $this->id_persona = $id_persona;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setYn_ingreso($yn_ingreso)
    {
        $this->yn_ingreso = $yn_ingreso;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setFecha_creacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setFecha_modificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setId_perfil($id_perfil)
    {
        $this->id_perfil = $id_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setListProfiles($listProfiles)
    {
        $this->listProfiles = $listProfiles;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPersonaDto($personaDto)
    {
        $this->personaDto = $personaDto;
    }
}