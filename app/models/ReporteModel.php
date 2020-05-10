<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\ClienteSubPaqueteDto;
use app\enums\EnumGeneric;
use app\dtos\RhRepresentanteDto;
use app\dtos\SubPaqueteDto;
use system\Support\Arr;
use app\dtos\SesionSubPaqueteDto;
use app\dtos\ClaseDto;
use app\dtos\ClaseDiaDto;
use app\dtos\PaqueteDto;
use app\dtos\GastoDto;
use app\dtos\ClienteSubPaqueteAbonoDto;

class ReporteModel
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {30/01/2017}
     * @param string $idClienteC            
     * @param string $estadoC            
     * @param string $orderBy            
     * @param string $fechaInicioC            
     * @throws Exception
     * @return Ambigous <multitype:, \app\models\ClienteSubPaqueteDto>
     */
    public function getLisClientesActivos($estadoC = null)
    {
        try {
            $result = $this->getAsociadoSubpaquete($estadoC);
            $arrayParams = array();
            $sql = "SELECT
                        csp.*,
                        spq.*,
                        clt.id_cliente,
                        prs.*,
                        usu.loggin                
                    FROM cliente_sub_paquete csp
                    INNER JOIN sub_paquete spq
                        ON csp.id_sub_paquete = spq.id_sub_paquete                    
                    INNER JOIN cliente clt
                        ON clt.id_cliente = csp.id_cliente
                    INNER JOIN persona prs
                        ON prs.id_persona = clt.id_persona
                    INNER JOIN usuario usu
                        ON usu.id_persona = prs.id_persona
                    WHERE 1 ";
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND csp.estado = :estadoC ";
                $arrayParams[':estadoC'] = $estadoC;
            }
            $sql .= " ORDER BY prs.primer_nombre, prs.segundo_nombre, prs.primer_apellido, prs.segundo_apellido ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteSubPaqueteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getSubPaqueteDto(), $row);
                Util::setObjectRow($object->getClienteDto(), $row);
                Util::setObjectRow($object->getClienteDto()->getPersonaDto(), $row);
                $object->getClienteDto()->getPersonaDto()->setLoggin($row['loggin']);
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
     * @since {15/02/2017}
     */
    public function getAsociadoSubpaquete($estadoC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                        csp.*,
                        spq.*,
                        cla.id_cliente,
                        pra.*,
                        usu.loggin
                    FROM cliente_sub_paquete csp
                        INNER JOIN sub_paquete spq
                            ON csp.id_sub_paquete = spq.id_sub_paquete    
                        INNER JOIN cliente_sub_paquete_asociado csa
                            ON csa.id_cliente_sub_paquete = csp.id_cliente_sub_paquete
                        INNER JOIN cliente cla
                            ON cla.id_cliente = csa.id_cliente
                        INNER JOIN persona pra
                            ON pra.id_persona = cla.id_persona 
                        INNER JOIN usuario usu
                            ON usu.id_persona = pra.id_persona
                    WHERE 1 ";
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND csp.estado = :estadoC ";
                $arrayParams[':estadoC'] = $estadoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteSubPaqueteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getSubPaqueteDto(), $row);
                Util::setObjectRow($object->getClienteDto(), $row);
                Util::setObjectRow($object->getClienteDto()->getPersonaDto(), $row);
                $object->getClienteDto()->getPersonaDto()->setLoggin($row['loggin']);
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
     * @since {30/01/2017}
     * @param string $estadoC            
     * @throws Exception
     * @return multitype:\app\dtos\ClienteSubPaqueteDto
     */
    public function getLisClientesInactivos($estadoC = null)
    {
        try {
            $listClientes = $this->getListClintesActivos($estadoC);
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                        clt.id_cliente,
                        prs.*
                    FROM cliente clt
                    INNER JOIN persona prs
                        ON prs.id_persona = clt.id_persona
                    WHERE 1 ";
            if (! Util::isVacio($estadoC)) {
                $arrayParams[':estadoC'] = $estadoC;
            }
            if (! Arr::isEmptyArray($listClientes)) {
                $sql .= " AND clt.id_cliente NOT IN (" . Arr::implode($listClientes, ",") . ") ";
            }
            $sql .= " ORDER BY prs.primer_nombre, prs.segundo_nombre, prs.primer_apellido, prs.segundo_apellido ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteSubPaqueteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getClienteDto(), $row);
                Util::setObjectRow($object->getClienteDto()->getPersonaDto(), $row);
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
     * @since {15/02/2017}
     */
    public function getListClintesActivos($estadoC)
    {
        try {
            $arrayParams[':estadoC'] = $estadoC;
            $result = array();
            $sql = "SELECT
                        cp.id_cliente,
                        csa.id_cliente AS id_asociado
                    FROM cliente_sub_paquete cp
                    LEFT JOIN cliente_sub_paquete_asociado csa
                        ON csa.id_cliente_sub_paquete = cp.id_cliente_sub_paquete
                    WHERE cp.estado =:estadoC ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result[$row['id_cliente']] = $row['id_cliente'];
                if (! Util::isVacio($row['id_asociado'])) {
                    $result[$row['id_asociado']] = $row['id_asociado'];
                }
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
     * @since {4/02/2017}
     * @param unknown $ynActivoC            
     * @return multitype:\app\models\EnumGeneric
     */
    public function getRepresentantesEnum($ynActivoC)
    {
        $lista = array();
        $list = $this->getListRepresentantes($ynActivoC);
        foreach ($list as $l) {
            $lista[] = new EnumGeneric($l->getId_representante(), $l->getPersonaDto()->getNombreCompleto());
            unset($l);
        }
        unset($list);
        return $lista;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {4/02/2017}
     * @param unknown $ynActivoC            
     * @throws Exception
     * @return multitype:\app\models\RhRepresentanteDto
     */
    public function getListRepresentantes($ynActivoC)
    {
        try {
            $arrayParams = [];
            $result = [];
            $sql = 'SELECT DISTINCT
                        rps.*,
                        prs.*
                    FROM rh_representante rps
                    INNER JOIN persona prs
                        ON prs.id_persona = rps.id_persona
                    INNER JOIN rh_representante_cargo crg
                        ON crg.id_representante = rps.id_representante
                        AND crg.id_cargo = 2
                    WHERE 1 ';
            if (! Util::isVacio($ynActivoC)) {
                $sql .= " AND crg.yn_activo = :yn_activo ";
                $arrayParams[':yn_activo'] = $ynActivoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new RhRepresentanteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPersonaDto(), $row);
                $result[] = $object;
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
     * @since {4/02/2017}
     */
    public function getSesionesEmpleado($id_representanteC, $fecha_inicioC, $fecha_finC)
    {
        try {
            $arrayParams = [];
            $result = [];
            $sql = 'SELECT DISTINCT
                        ssp.id_sesion_sub_paquete,
                        csp.id_cliente_sub_paquete,
                        spq.*,
                        pqt.porcentaje_pago
                    FROM sesion_sub_paquete ssp
                    INNER JOIN cliente_sub_paquete csp
                        ON csp.id_cliente_sub_paquete = ssp.id_cliente_sub_paquete
                    INNER JOIN sub_paquete spq
                        ON spq.id_sub_paquete = csp.id_sub_paquete
                    INNER JOIN paquete pqt
                        ON pqt.id_paquete = spq.id_paquete
                    WHERE ssp.estado = 3 ';
            if (! Util::isVacio($id_representanteC)) {
                $sql .= ' AND ssp.id_representante =:id_representanteC ';
                $arrayParams[':id_representanteC'] = $id_representanteC;
            }
            
            if (! Util::isVacio($fecha_inicioC)) {
                $sql .= ' AND ssp.fecha_hora_inicio >=:fecha_inicioC ';
                $arrayParams[':fecha_inicioC'] = $fecha_inicioC . " 00:00:00";
            }
            
            if (! Util::isVacio($fecha_finC)) {
                $sql .= ' AND ssp.fecha_hora_fin <=:fecha_finC ';
                $arrayParams[':fecha_finC'] = $fecha_finC . " 23:59:59";
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
                    Util::setObjectRow($object->getPaqueteDto(), $row);
                }
                $listSesiones = $object->getList_sesiones();
                $sesion = new SesionSubPaqueteDto();
                Util::setObjectRow($sesion, $row);
                $listSesiones[] = $sesion;
                $object->setList_sesiones($listSesiones);
                
                $result[$row['id_sub_paquete']] = $object;
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
     * @since {4/02/2017}
     * @param string $idClaseC            
     * @param string $diaSemanaC            
     * @param string $estadoC            
     * @throws Exception
     * @return multitype:\app\models\ClaseDto
     */
    public function getListClaseDto($idClaseC = null, $id_representanteC = null, $estadoC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                       cls.id_clase,
                       cls.nombre,
                       cls.id_representante,
                       cls.hora_inicio,
                       cls.hora_fin,
                       cls.cupo,
                       cls.yn_activo estado,
                       cld.*
                    FROM clase cls
                    INNER JOIN clase_dia cld
                       ON cld.id_clase = cls.id_clase
                    INNER JOIN rh_representante rhr
                       ON rhr.id_representante = cls.id_representante                  
                    WHERE 1 ";
            if (! Util::isVacio($idClaseC)) {
                $sql .= " AND cls.id_clase =:idClaseC ";
                $arrayParams[':idClaseC'] = $idClaseC;
            }
            if (! Util::isVacio($id_representanteC)) {
                $sql .= " AND cls.id_representante =:id_representanteC ";
                $arrayParams[':id_representanteC'] = $id_representanteC;
            }
            if (! Util::isVacio($estadoC)) {
                $sql .= " AND cls.yn_activo =:estadoc ";
                $arrayParams[':estadoc'] = $estadoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                if (! Arr::isNullArray($row['id_clase'], $result)) {
                    $object = $result[$row['id_clase']];
                } else {
                    $object = new ClaseDto();
                    Util::setObjectRow($object, $row);
                }
                $lisClases = $object->getList_dias();
                
                $clase = new ClaseDiaDto();
                Util::setObjectRow($clase, $row);
                $lisClases[$clase->getDia()] = $clase;
                $object->setList_dias($lisClases);
                
                $object->setYn_activo($row['estado']);
                
                unset($dia, $listDias);
                $result[$row['id_clase']] = $object;
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
     * @since {4/02/2017}
     */
    public function getPaqueteGrupalDto($tipoC)
    {
        try {
            $arrayParams = [];
            $object = new SubPaqueteDto();
            $sql = 'SELECT DISTINCT
                        pqt.*
                    FROM paquete pqt
                    WHERE 1';
            if (! Util::isVacio($tipoC)) {
                $sql .= ' AND pqt.tipo_paquete =:tipoC ';
                $arrayParams[':tipoC'] = $tipoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPaqueteDto(), $row);
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
     * @since {18/02/2017}
     * @param string $idGastoC            
     * @throws Exception
     * @return multitype:\app\models\GastoDto
     */
    public function getGastos($idGastoC = null, $fechaIniC = null, $fechafinC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT gst.* FROM gasto gst WHERE 1 ";
            if (! Util::isVacio($idGastoC)) {
                $sql .= " AND gst.id_gasto = :idGastoC ";
                $arrayParams[':idGastoC'] = $idGastoC;
            }
            if (! Util::isVacio($fechaIniC) && ! Util::isVacio($fechafinC)) {
                $sql .= " AND gst.fecha <= :fechaFinC AND gst.fecha >= :fechaIniC ";
                $arrayParams[':fechaIniC'] = $fechaIniC;
                $arrayParams[':fechaFinC'] = $fechafinC;
            }
            $sql .= " ORDER BY gst.fecha DESC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new GastoDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
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
     * @since {18/02/2017}
     * @param string $idGastoC            
     * @param string $fechaIniC            
     * @param string $fechafinC            
     * @throws Exception
     * @return multitype:\app\dtos\GastoDto
     */
    public function getAbonosClientes($fechaIniC = null, $fechaFinC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $fechaHoraIniC = $fechaIniC." 00:00:00";
            $fechaHoraFinC = $fechaFinC." 23:59:59 ";
            $sql = "SELECT 
                        csp.*,
                        spq.*,
                        prs.*,
                        csa.id_cliente_sub_paquete_abono,
                        csa.fecha,
                        csa.valor
                    FROM cliente_sub_paquete csp
                    LEFT JOIN cliente_sub_paquete_abono csa 
                        ON csp.id_cliente_sub_paquete = csa.id_cliente_sub_paquete
                    INNER JOIN sub_paquete spq
                        ON spq.id_sub_paquete = csp.id_sub_paquete
                    INNER JOIN cliente clt
                        ON clt.id_cliente = csp.id_cliente
                    INNER JOIN persona prs
                        ON prs.id_persona = clt.id_persona
                WHERE 1 ";
            if (! Util::isVacio($fechaIniC) && ! Util::isVacio($fechaFinC)) {
                $sql .= " AND( (csa.fecha <=:fechaHoraFinC AND csa.fecha >=:fechaHoraIniC ) 
                          OR (csp.fecha_pago <= :fechaFinC AND csp.fecha_pago >= :fechaIniC ))";
                $arrayParams[':fechaIniC'] = $fechaIniC;
                $arrayParams[':fechaFinC'] = $fechaFinC;
                $arrayParams[':fechaHoraIniC'] = $fechaHoraIniC;
                $arrayParams[':fechaHoraFinC'] = $fechaHoraFinC;
            }
            $sql .= " ORDER BY csa.fecha DESC, csp.fecha_pago DESC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                if (! Arr::isNullArray($row['id_cliente_sub_paquete'], $result)) {
                    $object = $result[$row['id_cliente_sub_paquete']];
                } else {
                    $object = new ClienteSubPaqueteDto();
                    Util::setObjectRow($object, $row);
                    Util::setObjectRow($object->getSubPaqueteDto(), $row);
                    Util::setObjectRow($object->getClienteDto(), $row);
                    Util::setObjectRow($object->getClienteDto()->getPersonaDto(), $row);
                }
                if (! Util::isVacio($row['id_cliente_sub_paquete_abono']) && $row['fecha'] <= $fechaHoraFinC && $row['fecha'] >= $fechaHoraIniC ) {
                    $listAbonos = $object->getListAbonos();
                    $abono = new ClienteSubPaqueteAbonoDto();
                    Util::setObjectRow($abono, $row);
                    $listAbonos[] = $abono;
                    $object->setListAbonos($listAbonos);
                }
                $result[$object->getId_cliente_sub_paquete()] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
}