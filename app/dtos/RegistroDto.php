<?php
namespace app\dtos;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {22/12/2016}
 */
class RegistroDto extends ADto
{

    /**
     *
     * @var integer
     */
    private $documento;

    /**
     *
     * @var integer
     */
    private $id_cliente;

    /**
     *
     * @var string
     */
    private $nombre_cliente;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     * @param number $documento            
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/02/2017}
     */
    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/02/2017}
     */
    public function getNombre_cliente()
    {
        return $this->nombre_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/02/2017}
     * @param number $id_cliente            
     */
    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/02/2017}
     * @param string $nombre_cliente            
     */
    public function setNombre_cliente($nombre_cliente)
    {
        $this->nombre_cliente = $nombre_cliente;
    }
}