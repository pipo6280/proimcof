<?php
namespace app\dtos;

use app\enums\ESiNo;
use system\Support\Str;

class ServicioDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_servicio;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var string
     */
    protected $descripcion;

    /**
     *
     * @var DateTime
     */
    protected $fecha_registro;

    /**
     *
     * @var integer
     */
    protected $precio_base;

    /**
     *
     * @var integer
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
     * @var boolean
     */
    protected $hasControl;

    /**
     *
     * @var boolean
     */
    protected $hasCita;

    /**
     *
     * @var array
     */
    protected $listControles;

    /**
     *
     * @var array
     */
    protected $listTratamientos;

    /**
     *
     * @var decimal
     */
    protected $totalRecaudo;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description: metodo que retorna el tipo de servico en el siguiente formato: (tipo servicio)
     * @author Rodolfo Perez - pipo6280@gmail.com
     * @since {26/11/2015}
     */
    public function getServicioVerCita()
    {
        return ' (' . Str::substr($this->getNombre(), 0, 25) . ')';
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function getTitleEstado()
    {
        $this->titleEstado = ($this->yn_activo == ESiNo::index(ESiNo::SI)->getId()) ? 'Activo' : 'Inactivo';
        return $this->titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setTitleEstado($titleEstado)
    {
        $this->titleEstado = $titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     *       
     * @return Ambigous <NULL, unknown, string>
     */
    public function getClassEstado()
    {
        if ($this->classEstado == '') {
            $this->classEstado = ($this->yn_activo == ESiNo::index(ESiNo::SI)->getId() ? 'fa fa-check-square-o fa-2x' : 'fa fa-dot-circle-o fa-2x');
        }
        return $this->classEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setClassEstado($classEstado)
    {
        $this->classEstado = $classEstado;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return number
     */
    public function getId_servicio()
    {
        return $this->id_servicio;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return number
     */
    public function getPrecio_base()
    {
        return $this->precio_base;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return number
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param number $id_servicio            
     */
    public function setId_servicio($id_servicio)
    {
        $this->id_servicio = $id_servicio;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param string $nombre            
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param number $precio_base            
     */
    public function setPrecio_base($precio_base)
    {
        $this->precio_base = $precio_base;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param number $yn_activo            
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/12/2015}
     */
    public function getHasControl()
    {
        return $this->hasControl;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/12/2015}
     * @param boolean $hasControl            
     */
    public function setHasControl($hasControl)
    {
        $this->hasControl = $hasControl;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/01/2016}
     */
    public function getHasCita()
    {
        return $this->hasCita;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/01/2016}
     * @param boolean $hasCita            
     */
    public function setHasCita($hasCita)
    {
        $this->hasCita = $hasCita;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/01/2016}
     */
    public function getListTratamientos()
    {
        return $this->listTratamientos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/01/2016}
     * @param multitype: $listTratamientos            
     */
    public function setListTratamientos($listTratamientos)
    {
        $this->listTratamientos = $listTratamientos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/01/2016}
     */
    public function getTotalRecaudo()
    {
        return $this->totalRecaudo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/01/2016}
     * @param \app\dtos\decimal $totalRecaudo            
     */
    public function setTotalRecaudo($totalRecaudo)
    {
        $this->totalRecaudo = $totalRecaudo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     * @param string $descripcion            
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     * @param \app\dtos\DateTime $fecha_registro            
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }
}