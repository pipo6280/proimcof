<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\GastoDto;
use app\dtos\ServicioDto;
use app\dtos\ClienteDto;
use app\enums\EnumGeneric;
use app\dtos\EquipoDto;
use app\dtos\ClienteSedeDto;
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
    
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {23/05/2020}
     */
    public function getEquipos($serialC = null, $idCLienteC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT
                        eqp.id_equipo,
                        eqp.id_modelo,
                        eqp.serial_equipo,
                        eqp.descripcion,
                        eqp.estado,
                        mdl.tipo,
                        mdl.modelo,
                        mdl.estilo,
                        mrc.id_marca,
                        mrc.nombre,
                        cls.id_cliente_sede,
                        cls.nombre nombre_sede,
                        clt.id_cliente,
                        clt.nombre_empresa
                     FROM equipo eqp
                        INNER JOIN equipo_modelo mdl
                            ON mdl.id_modelo = eqp.id_modelo
                        INNER JOIN equipo_marca mrc
                            ON mrc.id_marca = mdl.id_marca
                        INNER JOIN cliente_sede_equipo cse
                            ON cse.id_equipo = eqp.id_equipo
                        INNER JOIN cliente_sede cls
                            ON cls.id_cliente_sede = cse.id_cliente_sede
                        INNER JOIN cliente clt
                            ON cls.id_cliente = clt.id_cliente 
                     WHERE 1 ";
            
            if (! Util::isVacio($serialC)) {
                $sql .= " AND ( eqp.serial_equipo = :serialC  OR mdl.modelo = :serialC OR mrc.nombre = :serialC )";
                $arrayParams[':serialC'] = $serialC;
            }
            
            if (! Util::isVacio($idCLienteC)) {
                $sql .= " AND clt.id_cliente = :idCLienteC ";
                $arrayParams[':idCLienteC'] = $idCLienteC;
            }
            
            $sql .= " ORDER BY mrc.id_marca, mdl.modelo, eqp.id_equipo ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new EquipoDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getModeloDto(), $row);
                Util::setObjectRow($object->getMarcaDto(), $row);
                
                $clienteSede = new ClienteSedeDto();
                $clienteSede->setId_cliente_sede($row['id_cliente_sede']);
                $clienteSede->setNombre($row['nombre_sede']);
                Util::setObjectRow($clienteSede->getClienteDto(),$row);
                
                $object->setClienteSedeDto($clienteSede);
                
                
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    

}