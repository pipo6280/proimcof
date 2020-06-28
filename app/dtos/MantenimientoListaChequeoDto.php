<?php
namespace app\dtos;

use Doctrine\DBAL\Types\SmallIntType;

/**
 * 
 * @author pipo
 *
 */
class MantenimientoListaGrupoDto extends ADto
{
    
    /**
     *
     * @var integer
     */
    private $id_mantenimiento_lista_chequeo;  
    /**
     * 
     * @var integer
     */
    private $id_mantenimiento_lista;   
    /**
     *
     * @var integer
     */
    private $id_mantenimiento;

    /**
     *
     * @var SmallIntType
     */  
    private $estado;
    /**
     *
     * @var \DateTime
     */
    private $fecha_registro;
    
    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @return the $id_mantenimiento_lista_chequeo
     */
    public function getId_mantenimiento_lista_chequeo()
    {
        return $this->id_mantenimiento_lista_chequeo;
    }

    /**
     * @return the $id_mantenimiento_lista
     */
    public function getId_mantenimiento_lista()
    {
        return $this->id_mantenimiento_lista;
    }

    /**
     * @return the $id_mantenimiento
     */
    public function getId_mantenimiento()
    {
        return $this->id_mantenimiento;
    }

    /**
     * @return the $estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @return the $fecha_registro
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     * @param number $id_mantenimiento_lista_chequeo
     */
    public function setId_mantenimiento_lista_chequeo($id_mantenimiento_lista_chequeo)
    {
        $this->id_mantenimiento_lista_chequeo = $id_mantenimiento_lista_chequeo;
    }

    /**
     * @param number $id_mantenimiento_lista
     */
    public function setId_mantenimiento_lista($id_mantenimiento_lista)
    {
        $this->id_mantenimiento_lista = $id_mantenimiento_lista;
    }

    /**
     * @param number $id_mantenimiento
     */
    public function setId_mantenimiento($id_mantenimiento)
    {
        $this->id_mantenimiento = $id_mantenimiento;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @param DateTime $fecha_registro
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

}