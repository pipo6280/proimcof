<?php
namespace app\dtos;

class WelcomeDto extends ADto
{

    /**
     *
     * @var array
     */
    protected $listBirthDay;

    public function __construct()
    {
        parent::__construct();
        $this->listBirthDay = array();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     */
    public function getListBirthDay()
    {
        return $this->listBirthDay;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @param multitype: $listBirthDay            
     */
    public function setListBirthDay($listBirthDay)
    {
        $this->listBirthDay = $listBirthDay;
    }
}