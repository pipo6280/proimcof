<?php
namespace app\dtos;

use system\Support\Util;
use system\Support\Str;
use app\enums\ETipoDocumento;
use app\enums\EDateFormat;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 25/03/2015
 */
class PersonaDto extends ADto
{

    /**
     *
     * @var integer
     */
    protected $id_persona;

    /**
     *
     * @var string
     */
    protected $primer_nombre;

    /**
     *
     * @var string
     */
    protected $segundo_nombre;

    /**
     *
     * @var string
     */
    protected $primer_apellido;

    /**
     *
     * @var string
     */
    protected $segundo_apellido;

    /**
     *
     * @var smallint
     */
    protected $tipo_identificacion;

    /**
     *
     * @var integer
     */
    protected $numero_identificacion;

    /**
     *
     * @var smallint
     */
    protected $genero;

    /**
     *
     * @var date
     */
    protected $fecha_nacimiento;

    /**
     *
     * @var string
     */
    protected $direccion;

    /**
     *
     * @var string
     */
    protected $barrio;

    /**
     *
     * @var string
     */
    protected $ciudad;

    /**
     *
     * @var integer
     */
    protected $telefono;

    /**
     *
     * @var integer
     */
    protected $movil;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $foto_perfil;

    /**
     *
     * @var string
     */
    protected $fecha_registro;

    /**
     *
     * @var string
     */
    protected $fecha_modificacion;

    /**
     *
     * @var integer
     */
    protected $id_usuario;

    /**
     *
     * @var string
     */
    protected $loggin;

    /**
     *
     * @var sha1
     */
    protected $password;

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/03/2017}
     * @return string
     */
    public function getFirma(){
        return $this->id_persona.".jpeg";
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/03/2017}
     * @return string
     */
    public function getFirstLastName()
    {
        $fullName = title($this->primer_nombre) . ' ';
        $fullName .= title($this->primer_apellido);
        return $fullName;
    }

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/03/2017}
     * @return void|number
     */
    public function getEdad()
    {
        if ($this->fecha_nacimiento != NULL) {
            return (Util::year() - Util::formatDate($this->fecha_nacimiento, EDateFormat::index(EDateFormat::SOLO_ANO)->getId()));
        }
        return;
    }

    /**
     *
     * @tutorial Metodo Descripcion: retorna el nombre completo de la persona
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/04/2015
     * @return string
     */
    public function getNombreCompleto()
    {
        $nombreCompleto = null;
        if (! Util::isVacio($this->primer_nombre)) {
            $nombreCompleto = $this->primer_nombre;
            $nombreCompleto .= Util::isVacio($this->segundo_nombre) ? '' : ' ' . $this->segundo_nombre;
            $nombreCompleto .= ' ' . $this->primer_apellido;
            $nombreCompleto .= Util::isVacio($this->segundo_apellido) ? '' : ' ' . $this->segundo_apellido;
        }
        return $nombreCompleto;
    }

    public function getNombreCliente()
    {
        $nombreCompleto = null;
        if (! Util::isVacio($this->primer_nombre)) {
            $nombreCompleto = $this->primer_nombre;
            $nombreCompleto .= ' ' . $this->primer_apellido;
            $nombreCompleto .= Util::isVacio($this->segundo_apellido) ? '' : ' ' . $this->segundo_apellido;
        }
        return Util::trim($nombreCompleto);
    }

    /**
     *
     * @tutorial Method Description:metodo que retorna el primer nombre y primer apellido de usuario
     * @author Rodolfo Perez - pipo6280@gmail.com
     * @since {26/11/2015}
     */
    public function getNombrePersonaCita()
    {
        $nombreCompleto = null;
        if (! Util::isVacio($this->primer_nombre)) {
            $nombreCompleto = ! Util::isVacio($this->primer_nombre) ? $this->primer_nombre . ' ' . $this->primer_apellido : null;
        }
        return $nombreCompleto;
    }

    /**
     *
     * @tutorial Metodo Descripcion: retorna el nombre completo con las primeras letras en minusculas
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 18/05/2015
     * @return string
     */
    public function getNombreCompletoPrimeraMayuscula()
    {
        $nombreCompleto = $this->getNombreCompleto();
        return Str::ucWords($nombreCompleto);
    }

    /**
     *
     * @tutorial Method Description: retorna la identificacion de la persona concatenada
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/12/2015}
     * @return string
     */
    public function getIdentificacionPersona()
    {
        return ETipoDocumento::result($this->tipo_identificacion)->getDescription() . ' ' . $this->numero_identificacion;
    }

    /**
     *
     * @tutorial Method Description: retorna la direccion y el barrio
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/12/2015}
     * @return string
     */
    public function getDireccionBarrio()
    {
        if (! Util::isVacio($this->direccion)) {
            $direccion = Util::trim($this->direccion);
            $direccion .= Util::isVacio($this->barrio) ? '' : ' ' . $this->barrio;
            $direccion .= Util::isVacio($this->ciudad) ? '' : ', ' . $this->ciudad;
            return $direccion;
        }
    }

    /**
     *
     * @tutorial Method Description: retorna la direccion y el barrio
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/12/2015}
     * @return string
     */
    public function getContactoPersona()
    {
        return (Util::isVacio($this->telefono) ? '' : $this->telefono . ' - ') . Util::trim($this->movil);
    }

    /**
     *
     * @tutorial Method Description: retorna la direccion y el barrio
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {25/12/2015}
     * @return string
     */
    public function getContactoPersonaIcons()
    {
        return (Util::isVacio($this->telefono) ? '' : '<i class="fa fa-phone-square"></i> ' . $this->telefono . ' - ') . '<i class="fa fa-mobile"></i> ' . $this->movil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getId_persona()
    {
        return $this->id_persona;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getPrimer_nombre()
    {
        return $this->primer_nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getSegundo_nombre()
    {
        return $this->segundo_nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getPrimer_apellido()
    {
        return $this->primer_apellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getSegundo_apellido()
    {
        return $this->segundo_apellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getTipo_identificacion()
    {
        return $this->tipo_identificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getNumero_identificacion()
    {
        return $this->numero_identificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getFecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getFoto_perfil()
    {
        return $this->foto_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getFecha_modificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getLoggin()
    {
        return $this->loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setId_persona($id_persona)
    {
        $this->id_persona = $id_persona;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setPrimer_nombre($primer_nombre)
    {
        $this->primer_nombre = $primer_nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setSegundo_nombre($segundo_nombre)
    {
        $this->segundo_nombre = $segundo_nombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setPrimer_apellido($primer_apellido)
    {
        $this->primer_apellido = $primer_apellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setSegundo_apellido($segundo_apellido)
    {
        $this->segundo_apellido = $segundo_apellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setTipo_identificacion($tipo_identificacion)
    {
        $this->tipo_identificacion = $tipo_identificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setNumero_identificacion($numero_identificacion)
    {
        $this->numero_identificacion = $numero_identificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setFecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setBarrio($barrio)
    {
        $this->barrio = $barrio;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setFoto_perfil($foto_perfil)
    {
        $this->foto_perfil = $foto_perfil;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setFecha_modificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setLoggin($loggin)
    {
        $this->loggin = $loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 22/11/2016
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}