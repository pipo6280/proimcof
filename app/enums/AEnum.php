<?php
namespace app\enums;

/**
 *
 * @class app\enums\AEnum
 *
 * @tutorial clase abstracta
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since 20/09/2015
 */
abstract class AEnum
{

    /**
     *
     * @var integer
     */
    protected $id = NULL;

    /**
     *
     * @var string
     */
    protected $description = NULL;

    /**
     *
     * @var string
     */
    protected $assistant = NULL;

    /**
     *
     * @var string
     */
    protected $auxiliar = NULL;

    /**
     *
     * @tutorial constructor de la clase AEnum
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param integer $id            
     * @param string $description            
     * @param string $assistant            
     * @return void
     */
    public function __construct($id, $description, $assistant = NULL, $auxiliar = NULL)
    {
        $this->id = $id;
        $this->description = $description;
        $this->assistant = $assistant;
        $this->auxiliar = $auxiliar;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $description            
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return string
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     *
     * @tutorial
     *
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $assistant            
     */
    public function setAssistant($assistant)
    {
        $this->assistant = $assistant;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/12/2015}
     */
    public function getAuxiliar()
    {
        return $this->auxiliar;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {24/12/2015}
     * @param string $auxiliar            
     */
    public function setAuxiliar($auxiliar)
    {
        $this->auxiliar = $auxiliar;
    }
}