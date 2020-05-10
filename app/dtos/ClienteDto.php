<?php
namespace app\dtos;

use app\enums\ETipoEmpresa;
use system\Support\Util;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {19/01/2018}
 */
class ClienteDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_cliente;

    /**
     *
     * @var String
     */
    protected $nombre_empresa;

    /**
     *
     * @var String
     */
    protected $razon_social;

    /**
     *
     * @var String
     */
    protected $nit;

    /**
     *
     * @var String
     */
    protected $telefono;

    /**
     *
     * @var String
     */
    protected $movil;

    /**
     *
     * @var Smallint
     */
    protected $tipo_cliente;

    /**
     *
     * @var String
     */
    protected $observacion;

    /**
     *
     * @var String
     */
    protected $contacto;

    /**
     *
     * @var Integer
     */
    protected $id_ciudad;

    /**
     *
     * @var String
     */
    protected $direcion;

    /**
     *
     * @var String
     */
    protected $email;

    /**
     *
     * @var Integer
     */
    protected $descuento_scanner;

    /**
     *
     * @var Smallint
     */
    protected $yn_activo;

    /**
     *
     * @var DateTime
     */
    protected $fecha_registro;

    /**
     *
     * @var Integer
     */
    protected $id_usuario_registro;

    /**
     *
     * @var DateTime
     */
    protected $fecha_modificacion;

    /**
     *
     * @var Integer
     */
    protected $id_usuario_modifica;

    /**
     *
     * @var CiudadDto
     */
    protected $ciudadDto;

    /**
     *
     * @var Array
     */
    protected $list_sedes;

    /**
     *
     * @var Integer
     */
    protected $id_mes;

    /**
     *
     * @var Integer
     */
    protected $anho_actual;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function __construct()
    {
        $this->ciudadDto = new CiudadDto();
        $this->list_sedes = array();
        parent::__construct();
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/04/2018}
     * @return string
     */
    public function getFecha_mes() {
        return $this->anho_actual."-".$this->id_mes;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     */
    public function getTitleTipo()
    {
        $title = "";
        if (! Util::isVacio($this->tipo_cliente)) {
            $title = ETipoEmpresa::result($this->tipo_cliente)->getDescription();
        }
        return $title;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getNombre_empresa()
    {
        return $this->nombre_empresa;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getRazon_social()
    {
        return $this->razon_social;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getTipo_cliente()
    {
        return $this->tipo_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getContacto()
    {
        return $this->contacto;
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
    public function getDirecion()
    {
        return $this->direcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getDescuento_scanner()
    {
        return $this->descuento_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getYn_activo()
    {
        return $this->yn_activo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_usuario_registro()
    {
        return $this->id_usuario_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getId_usuario_modifica()
    {
        return $this->id_usuario_modifica;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
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
     * @since {19/01/2018}
     * @param string $nombre_empresa            
     */
    public function setNombre_empresa($nombre_empresa)
    {
        $this->nombre_empresa = $nombre_empresa;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $razon_social            
     */
    public function setRazon_social($razon_social)
    {
        $this->razon_social = $razon_social;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $nit            
     */
    public function setNit($nit)
    {
        $this->nit = $nit;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
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
     * @since {19/01/2018}
     * @param string $movil            
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\Smallint $tipo_cliente            
     */
    public function setTipo_cliente($tipo_cliente)
    {
        $this->tipo_cliente = $tipo_cliente;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $observacion            
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $contacto            
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;
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
     * @param string $direcion            
     */
    public function setDirecion($direcion)
    {
        $this->direcion = $direcion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $descuento_scanner            
     */
    public function setDescuento_scanner($descuento_scanner)
    {
        $this->descuento_scanner = $descuento_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\Smallint $yn_activo            
     */
    public function setYn_activo($yn_activo)
    {
        $this->yn_activo = $yn_activo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\DateTime $fecha_registro            
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_usuario_registro            
     */
    public function setId_usuario_registro($id_usuario_registro)
    {
        $this->id_usuario_registro = $id_usuario_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\DateTime $fecha_modificacion            
     */
    public function setFecha_modificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param number $id_usuario_modifica            
     */
    public function setId_usuario_modifica($id_usuario_modifica)
    {
        $this->id_usuario_modifica = $id_usuario_modifica;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getCiudadDto()
    {
        return $this->ciudadDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param \app\dtos\CiudadDto $ciudadDto            
     */
    public function setCiudadDto($ciudadDto)
    {
        $this->ciudadDto = $ciudadDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {19/01/2018}
     * @param string $email            
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function getList_sedes()
    {
        return $this->list_sedes;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     * @param multitype: $list_sedes            
     */
    public function setList_sedes($list_sedes)
    {
        $this->list_sedes = $list_sedes;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/04/2018}
     */
    public function getId_mes()
    {
        return $this->id_mes;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/04/2018}
     * @param number $id_mes            
     */
    public function setId_mes($id_mes)
    {
        $this->id_mes = $id_mes;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/04/2018}
     */
    public function getAnho_actual()
    {
        return $this->anho_actual;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/04/2018}
     * @param number $anho_actual            
     */
    public function setAnho_actual($anho_actual)
    {
        $this->anho_actual = $anho_actual;
    }
}