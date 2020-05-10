<?php
namespace app\dtos;

use system\Support\Util;
use system\Support\Str;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 29/07/2015
 */
class SessionDto extends ADto
{

    /**
     *
     * @var string
     */
    protected $loggin;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var integer
     */
    protected $idPersona;

    /**
     *
     * @var integer
     */
    protected $idUsuario;

    /**
     *
     * @var string
     */
    protected $primerNombre;

    /**
     *
     * @var string
     */
    protected $segundoNombre;

    /**
     *
     * @var string
     */
    protected $primerApellido;

    /**
     *
     * @var string
     */
    protected $segundoApellido;

    /**
     *
     * @var string
     */
    protected $photoProfile;

    /**
     *
     * @var array
     */
    protected $listProfiles;

    /**
     *
     * @var string
     */
    protected $userMenu;

    /**
     *
     * @var array
     */
    protected $arrays;

    /**
     *
     * @var string
     */
    protected $lang;

    /**
     *
     * @var bool
     */
    protected $access;

    /**
     *
     * @var bool
     */
    protected $changePassword;

    /**
     *
     * @var PersonaDto
     */
    protected $personaDto;

    /**
     *
     * @var array
     */
    protected $listBirthDays;

    /**
     *
     * @var boolean
     */
    protected $presentWelcome;

    /**
     *
     * @var string
     */
    protected $classMenu;

    /**
     *
     * @var string
     */
    protected $classBody;

    /**
     *
     * @var boolean
     */
    protected $consultaOK;

    public function __construct()
    {
        parent::__construct();
        $this->lang = config_item('language');
        $this->personaDto = new PersonaDto();
        $this->listBirthDays = array();
        $this->presentWelcome = true;
        $this->consultaOK = FALSE;
        $this->classBody = NULL;
        $this->access = FALSE;
        $this->array = array();
        
        log_message('info', 'SessionDto Class Initialized');
    }

    public function __set($name, $value = NULL)
    {
        $this->arrays[$name] = $value;
    }

    public function __get($name)
    {
        return $this->arrays[$name];
    }

    public function getFirstLastNameShort()
    {
        $fullName = Str::ucWords($this->primerNombre) . ' ' . Str::ucWords(Str::substr($this->primerApellido, 0, 1)) . '.';
        return $fullName;
    }

    public function getFirstLastName()
    {
        $fullName = Str::ucWords($this->primerNombre) . ' ';
        $fullName .= Str::ucWords($this->primerApellido);
        return $fullName;
    }

    public function getFullName()
    {
        $fullName = Str::ucWords($this->primerNombre) . ' ';
        $fullName .= Util::isVacio($this->segundoNombre) ? ' ' : ' ' . Str::ucWords($this->segundoNombre) . ' ';
        $fullName .= Str::ucWords($this->primerApellido) . ' ';
        $fullName .= Str::ucWords($this->segundoApellido);
        return $fullName;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getLoggin()
    {
        return $this->loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPhotoProfile()
    {
        return $this->photoProfile;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getListProfiles()
    {
        return $this->listProfiles;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getUserMenu()
    {
        return $this->userMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getArrays()
    {
        return $this->arrays;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getChangePassword()
    {
        return $this->changePassword;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPersonaDto()
    {
        return $this->personaDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getListBirthDays()
    {
        return $this->listBirthDays;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getPresentWelcome()
    {
        return $this->presentWelcome;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getClassMenu()
    {
        return $this->classMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function getClassBody()
    {
        return $this->classBody;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setLoggin($loggin)
    {
        $this->loggin = $loggin;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPhotoProfile($photoProfile)
    {
        $this->photoProfile = $photoProfile;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setListProfiles($listProfiles)
    {
        $this->listProfiles = $listProfiles;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setUserMenu($userMenu)
    {
        $this->userMenu = $userMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setArrays($arrays)
    {
        $this->arrays = $arrays;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setChangePassword($changePassword)
    {
        $this->changePassword = $changePassword;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPersonaDto($personaDto)
    {
        $this->personaDto = $personaDto;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setListBirthDays($listBirthDays)
    {
        $this->listBirthDays = $listBirthDays;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setPresentWelcome($presentWelcome)
    {
        $this->presentWelcome = $presentWelcome;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setClassMenu($classMenu)
    {
        $this->classMenu = $classMenu;
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 4/12/2016
     */
    public function setClassBody($classBody)
    {
        $this->classBody = $classBody;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {16/02/2017}
     * @return boolean
     */
    public function getConsultaOK()
    {
        return $this->consultaOK;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {16/02/2017}
     * @param boolean $consultaOK            
     */
    public function setConsultaOK($consultaOK)
    {
        $this->consultaOK = $consultaOK;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @return number
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {19/02/2017}
     * @param number $idPersona            
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;
    }
}