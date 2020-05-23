<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\GastoDto;
use app\dtos\ServicioDto;
use app\dtos\ClienteDto;
use app\enums\EnumGeneric;
/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class MantenimientoModel
{
    /**
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {23/05/2020}
     * @return \app\enums\EnumGeneric[]
     */
    public function getListClientesEnum() {        
        $return = array();
        $lista = $this->getListClientes(null, null);
        foreach ($lista as $l) {
            $return[] = new EnumGeneric($l->getId_cliente(), $l->getNombre_empresa());
        }
        return $return;
    }
        
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {22/01/2018}
     * @param string $idClienteC
     * @param string $nitC
     * @throws Exception
     * @return multitype:\app\dtos\ClienteDto
     */
    public function getListClientes($idClienteC = null, $nitC = null, $equiposC = false)
    {
        try {
            $result = array();
            $listIdSede = array();
            $arrayParams = array();
            $sql = 'SELECT
                         clt.*
                    FROM cliente clt
                WHERE 1 ';
            if (! Util::isVacio($idClienteC)) {
                $sql .= " AND clt.id_cliente = :idClienteC ";
                $arrayParams[':idClienteC'] = $idClienteC;
            }
            
            if (! Util::isVacio($nitC)) {
                $sql .= " AND clt.nit = :nitC ";
                $arrayParams[':nitC'] = $nitC;
            }
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $object = new ClienteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getCiudadDto(), $row);                
                $result[$object->getId_cliente()] = $object;
            }
            
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    

}