<?php
namespace app\dtos;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {21/01/2017}
 */
class MarcaDto extends ADto
{

    /**
     *
     * @var Integer
     */
    protected $id_marca;

    /**
     *
     * @var String
     */
    protected $nombre;

    /**
     *
     * @var Array
     */
    protected $list_modelos;

    /**
     *
     * @var Array
     */
    protected $list_equipos;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function __construct()
    {
        $this->list_modelos = array();
        $this->list_equipos = array();
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getId_marca()
    {
        return $this->id_marca;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getList_modelos()
    {
        return $this->list_modelos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getList_equipos()
    {
        return $this->list_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param number $id_marca            
     */
    public function setId_marca($id_marca)
    {
        $this->id_marca = $id_marca;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param string $nombre            
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param multitype: $list_modelos            
     */
    public function setList_modelos($list_modelos)
    {
        $this->list_modelos = $list_modelos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param multitype: $list_equipos            
     */
    public function setList_equipos($list_equipos)
    {
        $this->list_equipos = $list_equipos;
    }
}