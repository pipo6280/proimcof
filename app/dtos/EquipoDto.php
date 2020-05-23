<?php
namespace app\dtos;

use app\enums\EEstadoEquipo;
use system\Support\Util;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {21/01/2017}
 */
class EquipoDto extends ADto
{

    /**
     *
     * @var Integer
     */
    protected $id_equipo;

    /**
     *
     * @var Integer
     */
    protected $id_modelo;

    /**
     *
     * @var String
     */
    protected $serial_equipo;

    /**
     *
     * @var String
     */
    protected $descripcion;

    /**
     *
     * @var Smallint
     */
    protected $estado;

    /**
     *
     * @var Datatime
     */
    protected $fecha_registro;

    /**
     *
     * @var Integer
     */
    protected $id_usuario_registro;

    /**
     *
     * @var Datatime
     */
    protected $fecha_modificacion;

    /**
     *
     * @var Integer
     */
    protected $id_usuario_modifica;

    /**
     *
     * @var Integer
     */
    protected $contador_inicial_copia;

    /**
     *
     * @var Integer
     */
    protected $contador_inicial_scanner;

    /**
     *
     * @var ModeloDto
     */
    protected $modeloDto;

    /**
     *
     * @var MarcaDto
     */
    protected $marcaDto;
    
    /**
     * 
     * @var ClienteSedeDto
     */
    protected $clienteSedeDto;

    /**
     *
     * @var Array
     */
    protected $list_modelos_enum;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function __construct()
    {
        $this->list_modelos_enum = array();
        $this->modeloDto = new ModeloDto();
        $this->marcaDto = new MarcaDto();
        $this->clienteSedeDto = new ClienteSedeDto();
        parent::__construct();
    }    
    
    /**
     * 
     */
    public function getUbicacionEquipo() {
        $title = "";
        if ($this->clienteSedeDto !=null) {
            $title =  $this->getClienteSedeDto()->getClienteDto()->getNombre_empresa()." (". $this->getClienteSedeDto()->getNombre()." )";
        }
        return $title;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\dtos\ADto::getTitleEstado()
     */
    public function getTitleEstado()
    {
        $title = "";
        if (! Util::isVacio($this->estado)) {
            $title = EEstadoEquipo::result($this->estado)->getDescription();
        }
        return $title;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {30/01/2018}
     */
    public function getNombreEquipo() {
       return  $this->getMarcaDto()->getNombre() . " (" . $this->getModeloDto()->getModelo() . ") " . $this->getSerial_equipo();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_equipo()
    {
        return $this->id_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_modelo()
    {
        return $this->id_modelo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getSerial_equipo()
    {
        return $this->serial_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_usuario_registro()
    {
        return $this->id_usuario_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_usuario_modifica()
    {
        return $this->id_usuario_modifica;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getContador_inicial_copia()
    {
        return $this->contador_inicial_copia;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getContador_inicial_scanner()
    {
        return $this->contador_inicial_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getModeloDto()
    {
        return $this->modeloDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getMarcaDto()
    {
        return $this->marcaDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getList_modelos_enum()
    {
        return $this->list_modelos_enum;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_equipo            
     */
    public function setId_equipo($id_equipo)
    {
        $this->id_equipo = $id_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
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
     * @since {19/01/2018}
     * @param string $serial_equipo            
     */
    public function setSerial_equipo($serial_equipo)
    {
        $this->serial_equipo = $serial_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
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
     * @since {19/01/2018}
     * @param \app\dtos\Smallint $estado            
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\Datatime $fecha_registro            
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_usuario_registro            
     */
    public function setId_usuario_registro($id_usuario_registro)
    {
        $this->id_usuario_registro = $id_usuario_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\Datatime $fecha_modificacion            
     */
    public function setFecha_modificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_usuario_modifica            
     */
    public function setId_usuario_modifica($id_usuario_modifica)
    {
        $this->id_usuario_modifica = $id_usuario_modifica;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $contador_inicial_copia            
     */
    public function setContador_inicial_copia($contador_inicial_copia)
    {
        $this->contador_inicial_copia = $contador_inicial_copia;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $contador_inicial_scanner            
     */
    public function setContador_inicial_scanner($contador_inicial_scanner)
    {
        $this->contador_inicial_scanner = $contador_inicial_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\ModeloDto $modeloDto            
     */
    public function setModeloDto($modeloDto)
    {
        $this->modeloDto = $modeloDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\MarcaDto $marcaDto            
     */
    public function setMarcaDto($marcaDto)
    {
        $this->marcaDto = $marcaDto;
    }       

    /**
     * @return the $clienteSedeDto
     */
    public function getClienteSedeDto()
    {
        return $this->clienteSedeDto;
    }

    /**
     * @param \app\dtos\ClienteSedeDto $clienteSedeDto
     */
    public function setClienteSedeDto($clienteSedeDto)
    {
        $this->clienteSedeDto = $clienteSedeDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param multitype: $list_modelos_enum            
     */
    public function setList_modelos_enum($list_modelos_enum)
    {
        $this->list_modelos_enum = $list_modelos_enum;
    }
}