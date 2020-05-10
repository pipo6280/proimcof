<?php
namespace app\dtos;

use system\Support\Util;
/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {22/12/2016}
 */
class ReporteDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_representante;

    /**
     *
     * @var datetime
     */
    protected $fecha_inicio;

    /**
     *
     * @var datetime
     */
    protected $fecha_fin;

    /**
     *
     * @var array
     */
    protected $list_empleados;
    
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function __construct()
    {
        $this->fecha_inicio = Util::fechaActual();
        $this->fecha_fin = Util::fechaActual();
        $list_empleados = array();
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function getFecha_inicio()
    {
        return $this->fecha_inicio;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function getFecha_fin()
    {
        return $this->fecha_fin;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param \app\dtos\datetime $fecha_inicio            
     */
    public function setFecha_inicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param \app\dtos\datetime $fecha_fin            
     */
    public function setFecha_fin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function getId_representante()
    {
        return $this->id_representante;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param number $id_representante            
     */
    public function setId_representante($id_representante)
    {
        $this->id_representante = $id_representante;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function getList_empleados()
    {
        return $this->list_empleados;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param multitype: $list_empleados            
     */
    public function setList_empleados($list_empleados)
    {
        $this->list_empleados = $list_empleados;
    }
}