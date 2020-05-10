<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use system\Support\Arr;
use app\enums\EEstadoSesion;
use app\dtos\SubPaqueteDto;
use app\dtos\PersonaDto;
use app\enums\ESiNo;
use app\enums\EEstadoCuenta;

class RegistroModel
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function setCambiarEstadoSesion($idClienteC, $fechaC, $estadoC)
    {
        $edita = true;
        $errors = "";
        $mensaje = "";
        $newEstadoC =  EEstadoSesion::index(EEstadoSesion::CONNFIRMADA)->getId();
        $listpaquetes = $this->getClienteSubPaquete($idClienteC, $estadoC);
        if (! Arr::isEmptyArray($listpaquetes)) {
            // buscar sesiona actual
            $listSesiones = $this->getSesionSubpaquetes($listpaquetes, $fechaC, $estadoC);
            if (! Util::isVacio($listSesiones)) {
                // cambiar de estado sesiones a confirmada
                $data['fecha_modificacion'] = Util::fechaActual();
                $data['estado'] = $newEstadoC;
                $result = Doctrine::update('sesion_sub_paquete', $data, [
                    'id_sesion_sub_paquete' => $listSesiones
                ]);
                $this->setConfirmarSesionesAnteriores($listpaquetes, $fechaC, $estadoC, $newEstadoC);
                
                //cambiar los subpaquetes clientes
                foreach ($listpaquetes as $id_sup_paquete) {
                    $subPaqueteDto = $this->getSesionesActivas($id_sup_paquete, $newEstadoC);
                    if($subPaqueteDto instanceof SubPaqueteDto) {
                        $mensaje .= lang('registro.numero_sesiones', [count($subPaqueteDto->getList_sesiones()), $subPaqueteDto->getNombre()])."<br>";
                    }
                    if(count($subPaqueteDto->getList_sesiones()) ==  0) {
                        $data_cs['estado'] = EEstadoCuenta::index(EEstadoCuenta::VENCIDA)->getId();
                        $data_cs['fecha_modificacion'] = Util::fechaActual();
                        $result = Doctrine::update('cliente_sub_paquete', $data_cs, [
                            'id_cliente_sub_paquete' => $id_sup_paquete
                        ]);
                    }
                }
                
            } else {
                $edita = false;
                $errors = lang('registro.error_sesion_dia');
            }
        } else {
            $edita = false;
            $errors = lang('registro.error_sesion_dia');
        }
        
        return array($edita,$errors, $mensaje);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2017}
     */
    public function getClienteSubPaquete($idClienteC = null, $estadoC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                        csp.id_cliente_sub_paquete id
                    FROM cliente_sub_paquete csp
                    INNER JOIN cliente clt
                        ON clt.id_cliente = csp.id_cliente
                    INNER JOIN persona prs
                        ON prs.id_persona = clt.id_persona
                    WHERE 1 ";
            if (! Util::isVacio($idClienteC)) {
                $sql .= " AND clt.id_cliente = :idClienteC ";
                $arrayParams[':idClienteC'] = $idClienteC;
            }
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND csp.estado = :estadoC ";
                $arrayParams[':estadoC'] = $estadoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result[] = $row['id'];
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
     * @since {14/02/2017}
     */
    public function getSesionSubpaquetes($listpaquetes, $fechaC, $estadoC)
    {
        try {
            $result = null;
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                        ssp.id_sesion_sub_paquete id
                    FROM sesion_sub_paquete ssp
                    WHERE 1 ";
            if (! Arr::isEmptyArray($listpaquetes)) {
                $sql .= " AND ssp.id_cliente_sub_paquete IN (" . Arr::implode($listpaquetes) . ") ";
            }
            if (! Util::isVacio($fechaC)) {
                $sql .= " AND ssp.fecha_hora_fin >= '".$fechaC." 00:00:00'  AND ssp.fecha_hora_inicio <= '".$fechaC." 23:59:59' ";
                //$arrayParams[':fechaC'] = $fechaC;
            }
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND ssp.estado = :estadoC ";
                $arrayParams[':estadoC'] = $estadoC;
            }
            $sql .= "ORDER BY ssp.fecha_hora_fin DESC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result = $row['id'];
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
     * @since {14/02/2017}
     * @param unknown $listpaquetes
     * @param unknown $fechaC
     * @param unknown $estadoC
     * @throws Exception
     * @return NULL
     */
    public function setConfirmarSesionesAnteriores($listpaquetes, $fechaC, $estadoC, $newEstadoC)
    {
        try {
            $result = null;
            $arrayParams = array();
            $sql = "UPDATE sesion_sub_paquete SET estado =".$newEstadoC." WHERE 1 ";
            if (! Arr::isEmptyArray($listpaquetes)) {
                $sql .= " AND id_cliente_sub_paquete IN (" . Arr::implode($listpaquetes) . ") ";
            }
            if (! Util::isVacio($fechaC)) {
                $sql .= " AND fecha_hora_fin <= '".$fechaC." 00:00:00'";
                //$arrayParams[':fechaC'] = $fechaC;
            }
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND estado = :estadoC ";
                $arrayParams[':estadoC'] = $estadoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function getSesionesActivas($id_sup_paquete, $newEstadoC) {
        try {
            $result = array();
            $object = new SubPaqueteDto();
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                        spq.*,
                        ssp.id_sesion_sub_paquete                   
                    FROM cliente_sub_paquete csp
                    INNER jOIN sesion_sub_paquete ssp
                        ON ssp.id_cliente_sub_paquete = csp.id_cliente_sub_paquete
                    INNER jOIN sub_paquete spq
                        ON spq.id_sub_paquete = csp.id_sub_paquete
                    WHERE 1 ";
            if (! Util::isVacio($newEstadoC)) {
                $sql .= " AND ssp.estado NOT IN(:newEstadoC) ";
                $arrayParams[':newEstadoC'] = $newEstadoC;
            }
            if (! Util::isVacio($id_sup_paquete)) {
                $sql .= " AND ssp.id_cliente_sub_paquete IN (:idsupaquete) ";
                $arrayParams[':idsupaquete'] = $id_sup_paquete;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                if (! Arr::isNullArray($row['id_sub_paquete'], $result)) {
                    $object = $result[$row['id_sub_paquete']];
                } else {
                    $object = new SubPaqueteDto();
                    Util::setObjectRow($object, $row);
                }
                $listaSesiones = $object->getList_sesiones();
                $listaSesiones[] = $row['id_sesion_sub_paquete'];
                
                $object->setList_sesiones($listaSesiones);
                $result[$object->getId_sub_paquete()] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $object;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     * @param string $idClienteSubPaqueteC
     * @throws Exception
     * @return multitype:\app\models\ClienteDto
     */
    public function getPersonaCliente($idClienteC = NULL)
    {
        try {
            $result = null;
            $arrayParams = array();
            $sql = 'SELECT
                        prs.id_persona,
                        prs.primer_nombre,
                        prs.segundo_nombre,
                        prs.primer_apellido,
                        prs.segundo_apellido
                    FROM persona prs
                    INNER JOIN cliente clt
                        ON clt.id_persona = prs.id_persona
                    WHERE 1 ';
            if (! Util::isVacio($idClienteC)) {
                $sql .= " AND clt.id_cliente = :idClienteC ";
                $arrayParams[':idClienteC'] = $idClienteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new PersonaDto();
                Util::setObjectRow($object, $row);
                $result = "<b>".$object->getNombreCompleto()."</b>";
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    
}