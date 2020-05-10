<?php
namespace app\dtos;

class LoginDto extends ADto
{

    /**
     *
     * @var string
     */
    protected $login;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var smallint
     */
    protected $keep_session;

    /**
     *
     * @var string
     */
    protected $email;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @return \app\dtos\smallint
     */
    public function getKeep_session()
    {
        return $this->keep_session;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @param string $login            
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @param string $password            
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @param \app\dtos\smallint $keep_session            
     */
    public function setKeep_session($keep_session)
    {
        $this->keep_session = $keep_session;
    }

    /**
     *
     * @tutorial {}
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 24/08/2015
     * @param string $email            
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}