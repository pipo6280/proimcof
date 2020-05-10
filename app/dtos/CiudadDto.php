<?php
namespace app\dtos;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {21/01/2017}
 */
class CiudadDto extends ADto
{

    /**
     *
     * @var Integer
     */
    protected $id_ciudad;

    /**
     *
     * @var String
     */
    protected $nombre_ciudad;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_ciudad()
    {
        return $this->id_ciudad;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getNombre_ciudad()
    {
        return $this->nombre_ciudad;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_ciudad            
     */
    public function setId_ciudad($id_ciudad)
    {
        $this->id_ciudad = $id_ciudad;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $nombre_ciudad            
     */
    public function setNombre_ciudad($nombre_ciudad)
    {
        $this->nombre_ciudad = $nombre_ciudad;
    }
}