<?php
namespace app\dtos;

use system\Support\Arr;

/**
 * 
 * @author pipo
 *
 */
class MantenimientoDto extends ADto
{

    /**
     * 
     * @var integer
     */
    private $id_mantenimiento;    
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
     * @var integer
     */
    private $id_servicio;
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
    /**
     * 
     * @var ServicioDto
     */    
    private $servicioDto;
    
    /********************************************************************/
   
    /**
     * 
     * @var integer
     */
    private $id_cliente;
    /**
     *  @var string
     */
    private $search_equipo;
    
    /**
     * 
     * @var array
     */
    private $list_clientes_enum;
        
    /**
     *
     * @var array
     */
    private $list_servicios_enum;
    
    
    /**
     * 
     * @var array
     */
    private $list_mantenimientos;
    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->equipoDto = new EquipoDto();
        $this->rhRepresentanteDto = new RhRepresentanteDto();
        $this->servicioDto = new ServicioDto();
        $this->personaDto = new PersonaDto();
        
        $this->list_clientes_enum = new Arr();
        $this->list_servicios_enum = new Arr();
        $this->list_mantenimientos = new Arr();
    }
    /**
     * @return the $id_mantenimiento
     */
    public function getId_mantenimiento()
    {
        return $this->id_mantenimiento;
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
     * @return the $id_servicio
     */
    public function getId_servicio()
    {
        return $this->id_servicio;
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
     * @return the $equipoDto
     */
    public function getEquipoDto()
    {
        return $this->equipoDto;
    }

    /**
     * @return the $servicioDto
     */
    public function getServicioDto()
    {
        return $this->servicioDto;
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
     * @return the $list_servicios_enum
     */
    public function getList_servicios_enum()
    {
        return $this->list_servicios_enum;
    }

    /**
     * @param number $id_mantenimiento
     */
    public function setId_mantenimiento($id_mantenimiento)
    {
        $this->id_mantenimiento = $id_mantenimiento;
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
     * @param number $id_servicio
     */
    public function setId_servicio($id_servicio)
    {
        $this->id_servicio = $id_servicio;
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
     * @param \app\dtos\EquipoDto $equipoDto
     */
    public function setEquipoDto($equipoDto)
    {
        $this->equipoDto = $equipoDto;
    }

    /**
     * @param \app\dtos\ServicioDto $servicioDto
     */
    public function setServicioDto($servicioDto)
    {
        $this->servicioDto = $servicioDto;
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
     * @param array $list_clientes_enum
     */
    public function setList_clientes_enum($list_clientes_enum)
    {
        $this->list_clientes_enum = $list_clientes_enum;
    }

    /**
     * @param array $list_servicios_enum
     */
    public function setList_servicios_enum($list_servicios_enum)
    {
        $this->list_servicios_enum = $list_servicios_enum;
    }
    /**
     * @return the $personaDto
     */
    public function getPersonaDto()
    {
        return $this->personaDto;
    }

    /**
     * @param \app\dtos\PersonaDto $personaDto
     */
    public function setPersonaDto($personaDto)
    {
        $this->personaDto = $personaDto;
    }
    /**
     * @return the $list_mantenimientos
     */
    public function getList_mantenimientos()
    {
        return $this->list_mantenimientos;
    }

    /**
     * @param array $list_mantenimientos
     */
    public function setList_mantenimientos($list_mantenimientos)
    {
        $this->list_mantenimientos = $list_mantenimientos;
    }



    
    
     
    
}