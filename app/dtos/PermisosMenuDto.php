<?php
    namespace app\dtos;
    /**
     * 
     * @tutorial Clase de trabajo
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
class PermisosMenuDto
{
    
    protected $view;
    protected $classView;
    protected $iconView;
    
    protected $edit;
    protected $classEdit;
    protected $iconEdit;
    
    protected $add;
    protected $classAdd;
    protected $iconAdd;
    
    protected $delete;
    protected $classDelete;
    protected $iconDelete;
    
    public function __construct()
    {
        $this->view         = false;
        $this->edit         = false;
        $this->add          = false;
        $this->delete       = false;
        $this->iconAdd      = 'hide';
        $this->iconEdit     = 'hide';
        $this->iconView     = 'hide';
        $this->iconDelete   = 'hide';
    }
    
	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getView()
    {
        return $this->view;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getClassView()
    {
        return $this->classView;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getIconView()
    {
        return $this->iconView;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getEdit()
    {
        return $this->edit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getClassEdit()
    {
        return $this->classEdit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getIconEdit()
    {
        return $this->iconEdit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getAdd()
    {
        return $this->add;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getClassAdd()
    {
        return $this->classAdd;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getIconAdd()
    {
        return $this->iconAdd;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getDelete()
    {
        return $this->delete;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getClassDelete()
    {
        return $this->classDelete;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function getIconDelete()
    {
        return $this->iconDelete;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setView($view)
    {
        $this->view = $view;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setClassView($classView)
    {
        $this->classView = $classView;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setIconView($iconView)
    {
        $this->iconView = $iconView;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setEdit($edit)
    {
        $this->edit = $edit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setClassEdit($classEdit)
    {
        $this->classEdit = $classEdit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setIconEdit($iconEdit)
    {
        $this->iconEdit = $iconEdit;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setAdd($add)
    {
        $this->add = $add;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setClassAdd($classAdd)
    {
        $this->classAdd = $classAdd;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setIconAdd($iconAdd)
    {
        $this->iconAdd = $iconAdd;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setClassDelete($classDelete)
    {
        $this->classDelete = $classDelete;
    }

	/**
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com 
     * @since 3/04/2015
     */
    public function setIconDelete($iconDelete)
    {
        $this->iconDelete = $iconDelete;
    }

    
}