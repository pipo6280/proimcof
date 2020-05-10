<?php
    namespace app\dtos;
    /**
     * 
     * @tutorial Clase de trabajo
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/04/2015
     */
class ClassIconsDto extends ADto
{
    protected $id_icono_class;
    protected $class;
    
    public function __construct() {
        parent::__construct();
    }
	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 15/04/2015
     */
    public function getId_icono_class()
    {
        return $this->id_icono_class;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 15/04/2015
     */
    public function getClass()
    {
        return $this->class;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 15/04/2015
     */
    public function setId_icono_class($id_icono_class)
    {
        $this->id_icono_class = $id_icono_class;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 15/04/2015
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

       
}