<?php
namespace app\dtos;

use System\Support\Arrayable;
use app\enums\EnumGeneric;
use system\Support\Util;

class ClienteSedeDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_cliente_sede;

    /**
     *
     * @var integer
     */
    protected $id_cliente;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var string
     */
    protected $direccion;

    /**
     *
     * @var string
     */
    protected $telefono;

    /**
     *
     * @var ClienteDto
     */
    protected $clienteDto;
    
    /**
     *
     * @var integer
     */
    protected $num_equipos;

    /**
     *
     * @var Array
     */
    protected $list_equipos;


    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function __construct()
    {
        $this->clienteDto = new ClienteDto();
        $this->list_equipos = array();
        parent::__construct();
    }
    
    
    public function getTelefonoSede() {
        $tel = $this->telefono;
        if(Util::isVacio($tel)) {
            $tel = $this->clienteDto->getTelefono();
        }
        return $tel;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/04/2018}
     * @return string
     */
    public function getDireccionSede() {
        $dir = $this->direccion;
        if(Util::isVacio($dir)) {
            $dir = $this->clienteDto->getDirecion();
        }
        return $dir;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getId_cliente_sede()
    {
        return $this->id_cliente_sede;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getClienteDto()
    {
        return $this->clienteDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     * @param number $id_cliente_sede            
     */
    public function setId_cliente_sede($id_cliente_sede)
    {
        $this->id_cliente_sede = $id_cliente_sede;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
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
     * @since {22/01/2018}
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
     * @since {22/01/2018}
     * @param string $direccion            
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     * @param string $telefono            
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     * @param \app\dtos\ClienteDto $clienteDto            
     */
    public function setClienteDto($clienteDto)
    {
        $this->clienteDto = $clienteDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/01/2018}
     */
    public function getNum_equipos()
    {
        return $this->num_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/01/2018}
     * @param number $num_equipos            
     */
    public function setNum_equipos($num_equipos)
    {
        $this->num_equipos = $num_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getList_equipos()
    {
        return $this->list_equipos;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param multitype: $list_equipos            
     */
    public function setList_equipos($list_equipos)
    {
        $this->list_equipos = $list_equipos;
    }
}