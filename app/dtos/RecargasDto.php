<?php
namespace app\dtos;

use system\Support\Arr;

/**
 * 
 * @author pipo
 *
 */
class RecargasDto extends ADto
{

    /**
     * 
     * @var integer
     */
    private $id_recarga;    
    /**
     *
     * @var integer
     */
    private $id_representante;    
    /**
     *
     * @var integer
     */
    private $id_equipo;
    /**
     *
     * @var string
     */
    private $descripcion;    
    /**
     *
     * @var string
     */
    private $pendientes;    
    /**
     *
     * @var integer
     */
    private $contador_negro;   
    /**
     *
     * @var boolean
     */
    private $yn_contador_negro;   
    /**
     *
     * @var integer
     */
    private $contador_cyan;
    /**
     * 
     * @var boolean
     */
    private $yn_contador_cyan;
    /**
     *
     * @var integer
     */
    private $contador_magenta;
    /**
     * 
     * @var boolean
     */
    private $yn_contador_magenta;
    /**
     *
     * @var integer
     */
    private $contador_amarillo;
    /**
     * 
     * @var boolean
     */
    private $yn_contador_amarillo;
    /**
     *
     * @var \DateTime
     */
    private $fecha;
    /**
     * 
     * @var integer
     */
    private $id_usuario_registra;
    /**
     *
     * @var \DateTime
     */
    private $fecha_registro;    
    /**
     * 
     * @var integer
     */
    private $id_usuario_modifica;
    /**
     *
     * @var \DateTime
     */
    private $fecha_modifica;    
    /**
     *  @var RhRepresentanteDto
     */
    private $rhRepresentanteDto;    
    /**
     * 
     * @var PersonaDto
     */
    private $personaDto;
    /**
     * 
     * @var EquipoDto
     */
    private $equipoDto;

    /********************************************************************/
   
    /**
     * 
     * @var integer
     */
    private $id_cliente;

    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->equipoDto = new EquipoDto();
        $this->rhRepresentanteDto = new RhRepresentanteDto();
        $this->personaDto = new PersonaDto();

    }
    

    /**
     * @return the $id_recarga
     */
    public function getId_recarga()
    {
        return $this->id_recarga;
    }

    /**
     * @param number $id_recarga
     */
    public function setId_recarga($id_recarga)
    {
        $this->id_recarga = $id_recarga;
    }

    /**
     * @return the $id_representante
     */
    public function getId_representante()
    {
        return $this->id_representante;
    }

    /**
     * @return the $id_equipo
     */
    public function getId_equipo()
    {
        return $this->id_equipo;
    }

    /**
     * @return the $descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @return the $pendientes
     */
    public function getPendientes()
    {
        return $this->pendientes;
    }

    /**
     * @return the $contador_negro
     */
    public function getContador_negro()
    {
        return $this->contador_negro;
    }

    /**
     * @return the $contador_cyan
     */
    public function getContador_cyan()
    {
        return $this->contador_cyan;
    }

    /**
     * @return the $contador_magenta
     */
    public function getContador_magenta()
    {
        return $this->contador_magenta;
    }

    /**
     * @return the $contador_amarillo
     */
    public function getContador_amarillo()
    {
        return $this->contador_amarillo;
    }

    /**
     * @return the $fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return the $id_usuario_registra
     */
    public function getId_usuario_registra()
    {
        return $this->id_usuario_registra;
    }

    /**
     * @return the $fecha_registro
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     * @return the $id_usuario_modifica
     */
    public function getId_usuario_modifica()
    {
        return $this->id_usuario_modifica;
    }

    /**
     * @return the $fecha_modifica
     */
    public function getFecha_modifica()
    {
        return $this->fecha_modifica;
    }

    /**
     * @return the $rhRepresentanteDto
     */
    public function getRhRepresentanteDto()
    {
        return $this->rhRepresentanteDto;
    }

    /**
     * @return the $personaDto
     */
    public function getPersonaDto()
    {
        return $this->personaDto;
    }

    /**
     * @return the $equipoDto
     */
    public function getEquipoDto()
    {
        return $this->equipoDto;
    }

    /**
     * @return the $id_cliente
     */
    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    /**
     * @return the $search_equipo
     */
    public function getSearch_equipo()
    {
        return $this->search_equipo;
    }

    /**
     * @return the $list_clientes_enum
     */
    public function getList_clientes_enum()
    {
        return $this->list_clientes_enum;
    }

    /**
     * @return the $list_mantenimientos
     */
    public function getList_mantenimientos()
    {
        return $this->list_mantenimientos;
    }


    /**
     * @param number $id_representante
     */
    public function setId_representante($id_representante)
    {
        $this->id_representante = $id_representante;
    }

    /**
     * @param number $id_equipo
     */
    public function setId_equipo($id_equipo)
    {
        $this->id_equipo = $id_equipo;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @param string $pendientes
     */
    public function setPendientes($pendientes)
    {
        $this->pendientes = $pendientes;
    }

    /**
     * @param number $contador_negro
     */
    public function setContador_negro($contador_negro)
    {
        $this->contador_negro = $contador_negro;
    }

    /**
     * @param number $contador_cyan
     */
    public function setContador_cyan($contador_cyan)
    {
        $this->contador_cyan = $contador_cyan;
    }

    /**
     * @param number $contador_magenta
     */
    public function setContador_magenta($contador_magenta)
    {
        $this->contador_magenta = $contador_magenta;
    }

    /**
     * @param number $contador_amarillo
     */
    public function setContador_amarillo($contador_amarillo)
    {
        $this->contador_amarillo = $contador_amarillo;
    }

    /**
     * @param DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param number $id_usuario_registra
     */
    public function setId_usuario_registra($id_usuario_registra)
    {
        $this->id_usuario_registra = $id_usuario_registra;
    }

    /**
     * @param DateTime $fecha_registro
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     * @param number $id_usuario_modifica
     */
    public function setId_usuario_modifica($id_usuario_modifica)
    {
        $this->id_usuario_modifica = $id_usuario_modifica;
    }

    /**
     * @param DateTime $fecha_modifica
     */
    public function setFecha_modifica($fecha_modifica)
    {
        $this->fecha_modifica = $fecha_modifica;
    }

    /**
     * @param \app\dtos\RhRepresentanteDto $rhRepresentanteDto
     */
    public function setRhRepresentanteDto($rhRepresentanteDto)
    {
        $this->rhRepresentanteDto = $rhRepresentanteDto;
    }

    /**
     * @param \app\dtos\PersonaDto $personaDto
     */
    public function setPersonaDto($personaDto)
    {
        $this->personaDto = $personaDto;
    }

    /**
     * @param \app\dtos\EquipoDto $equipoDto
     */
    public function setEquipoDto($equipoDto)
    {
        $this->equipoDto = $equipoDto;
    }

    /**
     * @param number $id_cliente
     */
    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    /**
     * @param string $search_equipo
     */
    public function setSearch_equipo($search_equipo)
    {
        $this->search_equipo = $search_equipo;
    }
    /**
     * @return the $yn_contador_negro
     */
    public function getYn_contador_negro()
    {
        if($this->contador_negro >0 ) {
            return true;
        }
        return $this->yn_contador_negro;
    }

    /**
     * @return the $yn_contador_cyan
     */
    public function getYn_contador_cyan()
    {
        if($this->contador_cyan >0 ) {
            return true;
        }
        return $this->yn_contador_cyan;
    }

    /**
     * @return the $yn_contador_magenta
     */
    public function getYn_contador_magenta()
    {
        if($this->contador_magenta > 0 ) {
            return true;
        }
        return $this->yn_contador_magenta;
    }

    /**
     * @return the $yn_contador_amarillo
     */
    public function getYn_contador_amarillo()
    {
        if($this->contador_amarillo > 0 ) {
            return true;
        }
        return $this->yn_contador_amarillo;
    }

    /**
     * @param boolean $yn_contador_negro
     */
    public function setYn_contador_negro($yn_contador_negro)
    {
        $this->yn_contador_negro = $yn_contador_negro;
    }

    /**
     * @param boolean $yn_contador_cyan
     */
    public function setYn_contador_cyan($yn_contador_cyan)
    {
        $this->yn_contador_cyan = $yn_contador_cyan;
    }

    /**
     * @param boolean $yn_contador_magenta
     */
    public function setYn_contador_magenta($yn_contador_magenta)
    {
        $this->yn_contador_magenta = $yn_contador_magenta;
    }

    /**
     * @param boolean $yn_contador_amarillo
     */
    public function setYn_contador_amarillo($yn_contador_amarillo)
    {
        $this->yn_contador_amarillo = $yn_contador_amarillo;
    }

}