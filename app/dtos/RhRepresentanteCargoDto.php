<?php
namespace app\dtos;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 19/05/2015
 */
class RhRepresentanteCargoDto
{

    protected $id_representante;

    protected $id_cargo;

    protected $yn_activo;

    protected $cargoDto;

    protected $representanteDto;

    public function __construct()
    {
        $this->cargoDto = new RhCargoDto();
        $this->representanteDto = new RhRepresentanteDto();
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function getId_representante()
    {
        return $this->id_representante;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function setId_representante($id_representante)
    {
        $this->id_representante = $id_representante;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function getId_cargo()
    {
        return $this->id_cargo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function setId_cargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function getCargoDto()
    {
        return $this->cargoDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function setCargoDto($cargoDto)
    {
        $this->cargoDto = $cargoDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function getRepresentanteDto()
    {
        return $this->representanteDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 19/05/2015
     */
    public function setRepresentanteDto($representanteDto)
    {
        $this->representanteDto = $representanteDto;
    }
}