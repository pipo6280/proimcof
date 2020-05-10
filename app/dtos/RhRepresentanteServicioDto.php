<?php
namespace app\dtos;

class RhRepresentanteServicioDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_representante;

    /**
     *
     * @var integer
     */
    protected $id_servicio;

    /**
     *
     * @var ServicioDto
     */
    protected $servicioDto;

    /**
     *
     * @var RhRepresentanteDto
     */
    protected $representanteDto;

    /**
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/10/2015}
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->representanteDto = new RhRepresentanteDto();
        $this->servicioDto = new ServicioDto();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @return number
     */
    public function getId_representante()
    {
        return $this->id_representante;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @return number
     */
    public function getId_servicio()
    {
        return $this->id_servicio;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @return \app\dtos\ServicioDto
     */
    public function getServicioDto()
    {
        return $this->servicioDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @return \app\dtos\RhRepresentanteDto
     */
    public function getRepresentanteDto()
    {
        return $this->representanteDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param number $id_representante            
     */
    public function setId_representante($id_representante)
    {
        $this->id_representante = $id_representante;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param number $id_servicio            
     */
    public function setId_servicio($id_servicio)
    {
        $this->id_servicio = $id_servicio;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param \app\dtos\ServicioDto $servicioDto            
     */
    public function setServicioDto($servicioDto)
    {
        $this->servicioDto = $servicioDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param \app\dtos\RhRepresentanteDto $representanteDto            
     */
    public function setRepresentanteDto($representanteDto)
    {
        $this->representanteDto = $representanteDto;
    }
}