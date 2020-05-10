<?php
namespace app\dtos;

use system\Support\Util;
use system\Support\Arr;
use app\enums\ESiNo;

/**
 *
 * @tutorial Class Work
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 19/12/2016
 */
abstract class ADto
{

    protected $method;

    protected $dto;

    protected $serial;

    protected $_array;

    protected $_time;

    protected $ajax;

    protected $list;

    protected $permisoDto;

    /**
     *
     * @var string
     */
    protected $classEstado;

    /**
     *
     * @var string
     */
    protected $titleEstado;

    /**
     *
     * @var boolean
     */
    protected $bloquea;

    public function __construct()
    {
        $this->serial = Util::uniqid();
        $this->_time = Util::time();
        $this->method = 'index';
        $this->list = array();
        $this->ajax = FALSE;
        $this->bloquea = FALSE;
        $this->permisoDto = new PermisosMenuDto();
    }

    public function __set($nombre, $var)
    {
        $this->_array[$nombre] = $var;
    }

    public function __get($nom)
    {
        if ($this->_array == null || Arr::isNullArray($nom, $this->_array)) {
            return null;
        } else {
            return $this->_array[$nom];
        }
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function getTitleEstado()
    {
        $this->titleEstado = ($this->yn_activo == ESiNo::index(ESiNo::SI)->getId()) ? 'Activo' : 'Inactivo';
        return $this->titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     */
    public function setTitleEstado($titleEstado)
    {
        $this->titleEstado = $titleEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/04/2015
     *       
     * @return Ambigous <NULL, unknown, string>
     */
    public function getClassEstado()
    {
        if ($this->classEstado == '') {
            $this->classEstado = ($this->yn_activo == ESiNo::index(ESiNo::SI)->getId() ? 'fa fa-check-square-o fa-2x green-text text-darken-2' : 'fa fa-dot-circle-o fa-2x yellow-text text-darken-2');
        }
        return $this->classEstado;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function getTime()
    {
        return $this->_time;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 31/07/2015
     */
    public function setTime($_time)
    {
        $this->_time = $_time;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @return field_type
     */
    public function getAjax()
    {
        return $this->ajax;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @param field_type $ajax            
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/10/2015}
     * @return field_type
     */
    public function getDto()
    {
        return $this->dto;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/10/2015}
     * @param field_type $dto            
     */
    public function setDto($dto)
    {
        $this->dto = $dto;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return field_type
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param field_type $list            
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     */
    public function getPermisoDto()
    {
        return $this->permisoDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     * @param \app\dtos\UsuarioPerfilPermisoDto $permisoDto            
     */
    public function setPermisoDto($permisoDto)
    {
        $this->permisoDto = $permisoDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @return field_type
     */
    public function getArray()
    {
        return $this->_array;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @return boolean
     */
    public function getBloquea()
    {
        return $this->bloquea;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @param field_type $_array            
     */
    public function setArray($_array)
    {
        $this->_array = $_array;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @param string $classEstado            
     */
    public function setClassEstado($classEstado)
    {
        $this->classEstado = $classEstado;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @param boolean $bloquea            
     */
    public function setBloquea($bloquea)
    {
        $this->bloquea = $bloquea;
    }
}