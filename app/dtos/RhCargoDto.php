<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 26/11/2016
 */
class RhCargoDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_cargo;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var smallint
     */
    protected $yn_activo;

    /**
     *
     * @var string
     */
    protected $fecha_creacion;

    /**
     *
     * @var integer
     */
    protected $id_usuario_creacion;

    /**
     *
     * @var string
     */
    protected $fecha_modificacion;

    /**
     *
     * @var integer
     */
    protected $id_usuario_modificacion;

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
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function __construct()
    {
        parent::__construct();
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
            $this->dto = new RhCargoDto();
        }
        return $this->dto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getId_cargo()
    {
        return $this->id_cargo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getId_usuario_creacion()
    {
        return $this->id_usuario_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function getId_usuario_modificacion()
    {
        return $this->id_usuario_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setId_cargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setFecha_creacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setId_usuario_creacion($id_usuario_creacion)
    {
        $this->id_usuario_creacion = $id_usuario_creacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setFecha_modificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setId_usuario_modificacion($id_usuario_modificacion)
    {
        $this->id_usuario_modificacion = $id_usuario_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     */
    public function setClassEstado($classEstado)
    {
        $this->classEstado = $classEstado;
    }
}