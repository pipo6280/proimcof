<?php
namespace app\dtos;

use system\Support\Util;
use app\enums\ETipoEquipo;
use app\enums\EEstilo;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {21/01/2017}
 */
class ModeloDto extends ADto
{

    /**
     *
     * @var Integer
     */
    protected $id_modelo;

    /**
     *
     * @var Integer
     */
    protected $id_marca;

    /**
     *
     * @var Smallint
     */
    protected $tipo;

    /**
     *
     * @var Smallint
     */
    protected $estilo;

    /**
     *
     * @var String
     */
    protected $modelo;

    /**
     *
     * @var String
     */
    protected $descripcion;

    /**
     *
     * @var DateTime
     */
    protected $fecha_registro;

    /**
     *
     * @var MarcaDto
     */
    protected $marcaDto;

    /**
     *
     * @var Array
     */
    protected $list_equipos;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function __construct()
    {
        $this->marcaDto = new MarcaDto();
        $this->list_equipos = array();
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getTitleTipo()
    {
        $title = "";
        if (! Util::isVacio($this->tipo)) {
            $title = ETipoEquipo::result($this->tipo)->getDescription();
        }
        return $title;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {24/01/2018}
     * @return string
     */
    public function getTitleEstilo()
    {
        $title = "";
        if (! Util::isVacio($this->estilo)) {
            $title = EEstilo::result($this->estilo)->getDescription();
        }
        return $title;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getId_modelo()
    {
        return $this->id_modelo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getId_marca()
    {
        return $this->id_marca;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getMarcaDto()
    {
        return $this->marcaDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getList_equipos()
    {
        return $this->list_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param number $id_modelo            
     */
    public function setId_modelo($id_modelo)
    {
        $this->id_modelo = $id_modelo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param number $id_marca            
     */
    public function setId_marca($id_marca)
    {
        $this->id_marca = $id_marca;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param \app\dtos\Smallint $tipo            
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param string $modelo            
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
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
     * @since {18/01/2018}
     * @param \app\dtos\DateTime $fecha_registro            
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param \app\dtos\MarcaDto $marcaDto            
     */
    public function setMarcaDto($marcaDto)
    {
        $this->marcaDto = $marcaDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param multitype: $list_equipos            
     */
    public function setList_equipos($list_equipos)
    {
        $this->list_equipos = $list_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {24/01/2018}
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {24/01/2018}
     * @param \app\dtos\Smallint $estilo            
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;
    }
}