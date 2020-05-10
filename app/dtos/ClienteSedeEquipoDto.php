<?php
namespace app\dtos;

use app\enums\EnumGeneric;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {26/01/2018}
 */
class ClienteSedeEquipoDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_cliente_sede_equipo_fecha;

    /**
     *
     * @var integer
     */
    protected $id_cliente_sede_equipo;

    /**
     *
     * @var integer
     */
    protected $id_cliente_sede;

    /**
     *
     * @var integer
     */
    protected $id_equipo;

    /**
     *
     * @var integer
     */
    protected $plan_minimo;

    /**
     *
     * @var Smallint
     */
    protected $incluir_scanner;

    /**
     *
     * @var Smallint
     */
    protected $separar_copia_impresion;

    /**
     *
     * @var integer
     */
    protected $contador_copia_bn_ant;

    /**
     *
     * @var integer
     */
    protected $contador_copia_bn;

    /**
     *
     * @var integer
     */
    protected $contador_impresion_bn_ant;

    /**
     *
     * @var integer
     */
    protected $contador_impresion_bn;

    /**
     *
     * @var Decimal
     */
    protected $costo_impresion_bn;

    /**
     *
     * @var integer
     */
    protected $contador_copia_color_ant;

    /**
     *
     * @var integer
     */
    protected $contador_copia_color;

    /**
     *
     * @var integer
     */
    protected $contador_impresion_color_ant;

    /**
     *
     * @var integer
     */
    protected $contador_impresion_color;

    /**
     *
     * @var Decimal
     */
    protected $costo_impresion_color;

    /**
     *
     * @var integer
     */
    protected $contador_scanner_ant;

    /**
     *
     * @var integer
     */
    protected $contador_scanner;

    /**
     *
     * @var Decimal
     */
    protected $costo_scanner;

    /**
     *
     * @var DateTime
     */
    protected $fecha_registro;

    /**
     *
     * @var integer
     */
    protected $id_usuario_registro;

    /**
     *
     * @var ClienteSedeDto
     */
    protected $clienteSedeDto;

    /**
     *
     * @var EquipoDto
     */
    protected $equipoDto;

    /**
     *
     * @var ClienteDto
     */
    protected $clienteDto;

    /**
     *
     * @var smallint
     */
    protected $estado;

    /**
     *
     * @var Array
     */
    protected $list_equipos_enum;

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     */
    public function __construct()
    {
        $this->clienteSedeDto = new ClienteSedeDto();
        $this->equipoDto = new EquipoDto();
        $this->list_equipos_enum = array();
        parent::__construct();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2018}
     */
    public function getListEnum()
    {
        $temp = $this->getList_equipos_enum();
        $temp[] = new EnumGeneric($this->getEquipoDto()->getId_equipo(), $this->getEquipoDto()
            ->getMarcaDto()
            ->getNombre() . " (" . $this->getEquipoDto()
            ->getModeloDto()
            ->getModelo() . ") " . $this->getEquipoDto()->getSerial_equipo());
        // $this->setList_equipos_enum($temp);
        return $temp;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/04/2018}
     */
    public function getNameEquipo()
    {
        return $this->equipoDto->getSerial_equipo() . "( " . $this->getEquipoDto()
            ->getMarcaDto()
            ->getNombre() . " - " . $this->getEquipoDto()
            ->getModeloDto()
            ->getModelo() . ")";
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getId_cliente_sede_equipo()
    {
        return $this->id_cliente_sede_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getId_cliente_sede()
    {
        return $this->id_cliente_sede;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getId_equipo()
    {
        return $this->id_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getPlan_minimo()
    {
        return $this->plan_minimo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getIncluir_scanner()
    {
        return $this->incluir_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getSeparar_copia_impresion()
    {
        return $this->separar_copia_impresion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getContador_copia_bn()
    {
        return $this->contador_copia_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getContador_impresion_bn()
    {
        return $this->contador_impresion_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getCosto_impresion_bn()
    {
        return $this->costo_impresion_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getContador_copia_color()
    {
        return $this->contador_copia_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getContador_impresion_color()
    {
        return $this->contador_impresion_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getCosto_impresion_color()
    {
        return $this->costo_impresion_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getContador_scanner()
    {
        return $this->contador_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getCosto_scanner()
    {
        return $this->costo_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getId_usuario_registro()
    {
        return $this->id_usuario_registro;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getClienteSedeDto()
    {
        return $this->clienteSedeDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     */
    public function getEquipoDto()
    {
        return $this->equipoDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $id_cliente_sede_equipo            
     */
    public function setId_cliente_sede_equipo($id_cliente_sede_equipo)
    {
        $this->id_cliente_sede_equipo = $id_cliente_sede_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
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
     * @since {26/01/2018}
     * @param number $id_equipo            
     */
    public function setId_equipo($id_equipo)
    {
        $this->id_equipo = $id_equipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $plan_minimo            
     */
    public function setPlan_minimo($plan_minimo)
    {
        $this->plan_minimo = $plan_minimo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\Smallint $incluir_scanner            
     */
    public function setIncluir_scanner($incluir_scanner)
    {
        $this->incluir_scanner = $incluir_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\Smallint $separar_copia_impresion            
     */
    public function setSeparar_copia_impresion($separar_copia_impresion)
    {
        $this->separar_copia_impresion = $separar_copia_impresion;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $contador_copia_bn            
     */
    public function setContador_copia_bn($contador_copia_bn)
    {
        $this->contador_copia_bn = $contador_copia_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $contador_impresion_bn            
     */
    public function setContador_impresion_bn($contador_impresion_bn)
    {
        $this->contador_impresion_bn = $contador_impresion_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\Decimal $costo_impresion_bn            
     */
    public function setCosto_impresion_bn($costo_impresion_bn)
    {
        $this->costo_impresion_bn = $costo_impresion_bn;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $contador_copia_color            
     */
    public function setContador_copia_color($contador_copia_color)
    {
        $this->contador_copia_color = $contador_copia_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $contador_impresion_color            
     */
    public function setContador_impresion_color($contador_impresion_color)
    {
        $this->contador_impresion_color = $contador_impresion_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\Decimal $costo_impresion_color            
     */
    public function setCosto_impresion_color($costo_impresion_color)
    {
        $this->costo_impresion_color = $costo_impresion_color;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param number $contador_scanner            
     */
    public function setContador_scanner($contador_scanner)
    {
        $this->contador_scanner = $contador_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\Decimal $costo_scanner            
     */
    public function setCosto_scanner($costo_scanner)
    {
        $this->costo_scanner = $costo_scanner;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
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
     * @since {26/01/2018}
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
     * @since {26/01/2018}
     * @param \app\dtos\ClienteSedeDto $clienteSedeDto            
     */
    public function setClienteSedeDto($clienteSedeDto)
    {
        $this->clienteSedeDto = $clienteSedeDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {26/01/2018}
     * @param \app\dtos\EquipoDto $equipoDto            
     */
    public function setEquipoDto($equipoDto)
    {
        $this->equipoDto = $equipoDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2018}
     */
    public function getClienteDto()
    {
        return $this->clienteDto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2018}
     */
    public function getList_equipos_enum()
    {
        return $this->list_equipos_enum;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2018}
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
     * @since {29/01/2018}
     * @param multitype: $list_equipos_enum            
     */
    public function setList_equipos_enum($list_equipos_enum)
    {
        $this->list_equipos_enum = $list_equipos_enum;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     * @param \app\dtos\smallint $estado            
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/04/2018}
     */
    public function getId_cliente_sede_equipo_fecha()
    {
        return $this->id_cliente_sede_equipo_fecha;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/04/2018}
     * @param number $id_cliente_sede_equipo_fecha            
     */
    public function setId_cliente_sede_equipo_fecha($id_cliente_sede_equipo_fecha)
    {
        $this->id_cliente_sede_equipo_fecha = $id_cliente_sede_equipo_fecha;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     */
    public function getContador_copia_bn_ant()
    {
        return $this->contador_copia_bn_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     */
    public function getContador_impresion_bn_ant()
    {
        return $this->contador_impresion_bn_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     */
    public function getContador_copia_color_ant()
    {
        return $this->contador_copia_color_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     */
    public function getContador_impresion_color_ant()
    {
        return $this->contador_impresion_color_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     */
    public function getContador_scanner_ant()
    {
        return $this->contador_scanner_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     * @param number $contador_copia_bn_ant            
     */
    public function setContador_copia_bn_ant($contador_copia_bn_ant)
    {
        $this->contador_copia_bn_ant = $contador_copia_bn_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     * @param number $contador_impresion_bn_ant            
     */
    public function setContador_impresion_bn_ant($contador_impresion_bn_ant)
    {
        $this->contador_impresion_bn_ant = $contador_impresion_bn_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     * @param number $contador_copia_color_ant            
     */
    public function setContador_copia_color_ant($contador_copia_color_ant)
    {
        $this->contador_copia_color_ant = $contador_copia_color_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     * @param number $contador_impresion_color_ant            
     */
    public function setContador_impresion_color_ant($contador_impresion_color_ant)
    {
        $this->contador_impresion_color_ant = $contador_impresion_color_ant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/04/2018}
     * @param number $contador_scanner_ant            
     */
    public function setContador_scanner_ant($contador_scanner_ant)
    {
        $this->contador_scanner_ant = $contador_scanner_ant;
    }
}