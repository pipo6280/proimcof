<?php
namespace app\dtos;

class RhRepresentanteDto extends ADto
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
    protected $id_persona;

    /**
     *
     * @var date
     */
    protected $fecha_creacion;

    /**
     *
     * @var smallint
     */
    protected $yn_activo;

    /**
     *
     * @var PersonaDto
     */
    protected $personaDto;

    /**
     *
     * @var array
     */
    protected $listServices;

    /**
     *
     * @var array
     */
    protected $listCargos;

    /**
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/10/2015}
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->personaDto = new PersonaDto();
        $this->listServices = array();
        $this->listCargos = array();
    }

    /**
     *
     * @return RhRepresentanteDto
     */
    public function getDto()
    {
        if ($this->dto == NULL) {
            $this->dto = new RhRepresentanteDto();
        }
        return $this->dto;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return number
     */
    public function getId_representante()
    {
        return $this->id_representante;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return number
     */
    public function getId_persona()
    {
        return $this->id_persona;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return \app\dtos\date
     */
    public function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return \app\dtos\smallint
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @return \app\dtos\PersonaDto
     */
    public function getPersonaDto()
    {
        return $this->personaDto;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param number $id_representante            
     */
    public function setId_representante($id_representante)
    {
        $this->id_representante = $id_representante;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param number $id_persona            
     */
    public function setId_persona($id_persona)
    {
        $this->id_persona = $id_persona;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param \app\dtos\date $fecha_creacion            
     */
    public function setFecha_creacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param \app\dtos\smallint $yn_activo            
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {15/10/2015}
     * @param \app\dtos\PersonaDto $personaDto            
     */
    public function setPersonaDto($personaDto)
    {
        $this->personaDto = $personaDto;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {28/10/2015}
     * @return multitype:
     */
    public function getListServices()
    {
        return $this->listServices;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {28/10/2015}
     * @param multitype: $listServices            
     */
    public function setListServices($listServices)
    {
        $this->listServices = $listServices;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     */
    public function getListCargos()
    {
        return $this->listCargos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     * @param multitype: $listCargos            
     */
    public function setListCargos($listCargos)
    {
        $this->listCargos = $listCargos;
    }
}