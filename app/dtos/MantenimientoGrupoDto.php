<?php
namespace app\dtos;

use Doctrine\DBAL\Types\SmallIntType;

/**
 * 
 * @author pipo
 *
 */
class MantenimientoGrupoDto extends ADto
{

    /**
     * 
     * @var integer
     */
    private $id_mantenimiento_grupo;    

    /**
     *
     * @var SmallIntType
     */  
    private $yn_activo;
    /**
     *
     * @var string
     */
    private $descripcion;
    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @return the $id_mantenimiento_grupo
     */
    public function getId_mantenimiento_grupo()
    {
        return $this->id_mantenimiento_grupo;
    }

    /**
     * @return the $yn_activo
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     * @return the $descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param number $id_mantenimiento_grupo
     */
    public function setId_mantenimiento_grupo($id_mantenimiento_grupo)
    {
        $this->id_mantenimiento_grupo = $id_mantenimiento_grupo;
    }

    /**
     * @param \Doctrine\DBAL\Types\SmallIntType $yn_activo
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    
    
    
       
}