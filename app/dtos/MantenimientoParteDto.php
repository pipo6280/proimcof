<?php
namespace app\dtos;

use Doctrine\DBAL\Types\SmallIntType;


/**
 * 
 * @author pipo
 *
 */
class MantenimientoParteDto extends ADto
{
    
    /**
     *
     * @var integer
     */
    private $id_mantenimiento_parte;  
    /**
     *
     * @var integer
     */
    private $id_mantenimiento;
    /**
     * 
     * @var String
     */
    private $numero_parte;    
    /**
     * 
     * @var String
     */
    private $descripcion;
    /**
     * 
     * @var integer
     */
    private $cantidad;

    /**
     *
     * @var SmallIntType
     */  
    private $yn_cambio;
    /**
     *
     * @var SmallIntType
     */
    private $yn_solicitud;
    /**
     *
     * @var SmallIntType
     */
    private $yn_anticipado;
    /**
     *
     * @var SmallIntType
     */
    private $yn_cotizar;   
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
     * @return the $id_mantenimiento_parte
     */
    public function getId_mantenimiento_parte()
    {
        return $this->id_mantenimiento_parte;
    }

    /**
     * @return the $id_mantenimiento
     */
    public function getId_mantenimiento()
    {
        return $this->id_mantenimiento;
    }

    /**
     * @return the $numero_parte
     */
    public function getNumero_parte()
    {
        return $this->numero_parte;
    }

    /**
     * @return the $descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @return the $cantidad
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @return the $yn_cambio
     */
    public function getYn_cambio()
    {
        return $this->yn_cambio;
    }

    /**
     * @return the $yn_solicitud
     */
    public function getYn_solicitud()
    {
        return $this->yn_solicitud;
    }

    /**
     * @return the $yn_anticipado
     */
    public function getYn_anticipado()
    {
        return $this->yn_anticipado;
    }

    /**
     * @return the $yn_cotizar
     */
    public function getYn_cotizar()
    {
        return $this->yn_cotizar;
    }

    /**
     * @return the $fecha_registro
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     * @param number $id_mantenimiento_parte
     */
    public function setId_mantenimiento_parte($id_mantenimiento_parte)
    {
        $this->id_mantenimiento_parte = $id_mantenimiento_parte;
    }

    /**
     * @param number $id_mantenimiento
     */
    public function setId_mantenimiento($id_mantenimiento)
    {
        $this->id_mantenimiento = $id_mantenimiento;
    }

    /**
     * @param \app\dtos\String $numero_parte
     */
    public function setNumero_parte($numero_parte)
    {
        $this->numero_parte = $numero_parte;
    }

    /**
     * @param Ambigous <string, \app\dtos\String> $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @param number $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $yn_cambio
     */
    public function setYn_cambio($yn_cambio)
    {
        $this->yn_cambio = $yn_cambio;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $yn_solicitud
     */
    public function setYn_solicitud($yn_solicitud)
    {
        $this->yn_solicitud = $yn_solicitud;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $yn_anticipado
     */
    public function setYn_anticipado($yn_anticipado)
    {
        $this->yn_anticipado = $yn_anticipado;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $yn_cotizar
     */
    public function setYn_cotizar($yn_cotizar)
    {
        $this->yn_cotizar = $yn_cotizar;
    }

    /**
     * @param DateTime $fecha_registro
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

}