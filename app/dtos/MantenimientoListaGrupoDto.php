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
    private $id_mantenimiento_lista;  

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
     * @var MantenimientoGrupoDto
     */
    private $mantenimiento_grupo;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->mantenimiento_grupo = new MantenimientoGrupoDto();
        parent::__construct();
    }
    
    /**
     * @return the $id_mantenimiento_lista
     */
    public function getId_mantenimiento_lista()
    {
        return $this->id_mantenimiento_lista;
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
     * @return the $mantenimiento_grupo
     */
    public function getMantenimiento_grupo()
    {
        return $this->mantenimiento_grupo;
    }

    /**
     * @param number $id_mantenimiento_lista
     */
    public function setId_mantenimiento_lista($id_mantenimiento_lista)
    {
        $this->id_mantenimiento_lista = $id_mantenimiento_lista;
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

    /**
     * @param \app\dtos\MantenimientoGrupoDto $mantenimiento_grupo
     */
    public function setMantenimiento_grupo($mantenimiento_grupo)
    {
        $this->mantenimiento_grupo = $mantenimiento_grupo;
    }

    
    
       
}