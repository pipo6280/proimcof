<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\ServicioDto;
use app\dtos\ClienteDto;
use app\enums\EnumGeneric;
use app\dtos\EquipoDto;
use app\dtos\ClienteSedeDto;
use app\dtos\MantenimientoDto;
use app\dtos\RhRepresentanteDto;
use app\dtos\RecargasDto;
use app\enums\EEstadoMantenimiento;
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
     * @since {25/05/2020}
     */
    private function getRepresentanteIdPersona($idPersona = null) {
        
        try {
            $result = null;
            $listIdSede = array();
            $arrayParams = array();
            $sql = 'SELECT
                         rpt.*
                    FROM rh_representante rpt
                WHERE 1 ';
            if (! Util::isVacio($idPersona)) {
                $sql .= " AND rpt.id_persona = :idPersona ";
                $arrayParams[':idPersona'] = $idPersona;
            }
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $object = new RhRepresentanteDto();
                Util::setObjectRow($object, $row);
                //Util::setObjectRow($object->getCiudadDto(), $row);
                $result = $object;
            }
            
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
        
    }
    
    
    /**
     * 
     * @param unknown $idEquipo
     * @throws Exception
     * @return array|\app\dtos\MantenimientoDto
     */
    public function getListMantenimientos($idEquipo = null) {
        
        try {
            $result = array();            
            $arrayParams = array();
            $sql = 'SELECT
                        mnt.*,
                        srv.id_servicio,
                        srv.descripcion descripcion_servicio,
                        prs.id_persona,
                        prs.primer_nombre,
                        prs.segundo_nombre,
                        prs.primer_apellido,
                        prs.segundo_apellido
                    FROM mantenimiento mnt 
                    INNER JOIN servicio srv ON mnt.id_servicio = srv.id_servicio
                    INNER JOIN rh_representante rpt ON mnt.id_representante = rpt.id_representante
                    INNER JOIN persona prs ON rpt.id_persona = prs.id_persona
                WHERE 1 ';
            
            if (! Util::isVacio($idEquipo)) {
                $sql .= " AND mnt.id_equipo = :idEquipo ";
                $arrayParams[':idEquipo'] = $idEquipo;
            }
            
            $sql .= " ORDER BY mnt.fecha DESC";
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $object = new MantenimientoDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPersonaDto(), $row);
                
                $servicio = new ServicioDto();
                $servicio->setId_servicio($row['id_servicio']);
                $servicio->setDescripcion($row['descripcion_servicio']);
                
                $object->setServicioDto($servicio);
                
                $result[] = $object;
            }
            
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
        
    }
    
    
    /**
     *
     * @param unknown $idEquipo
     * @throws Exception
     * @return array|\app\dtos\MantenimientoDto
     */
    public function getListMantenimientosPorRepresentante($idPersona= null, $estado = null) {
        
        try {
            $result = array();
            $arrayParams = array();
            $sql = 'SELECT
                        mnt.*,
                        srv.id_servicio,
                        srv.descripcion descripcion_servicio,
                        prs.id_persona,
                        prs.primer_nombre,
                        prs.segundo_nombre,
                        prs.primer_apellido,
                        prs.segundo_apellido,
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
                    FROM mantenimiento mnt
                    LEFT JOIN servicio srv ON mnt.id_servicio = srv.id_servicio
                    INNER JOIN rh_representante rpt ON mnt.id_representante = rpt.id_representante
                    INNER JOIN persona prs ON rpt.id_persona = prs.id_persona
                    INNER JOIN equipo eqp ON mnt.id_equipo = eqp.id_equipo
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
                WHERE 1 ';
            
            if (! Util::isVacio($idPersona)) {
                $sql .= " AND rpt.id_persona = :idrepresentante ";
                $arrayParams[':idrepresentante'] = $idPersona;
            }
            
            if (! Util::isVacio($estado)) {
                $sql .= " AND mnt.estado = :estado ";
                $arrayParams[':estado'] = $estado;
            }
            
            $sql .= " ORDER BY mnt.fecha DESC";
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();  
            
            foreach ($list as $row) {
                $object = new MantenimientoDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPersonaDto(), $row);
                
                Util::setObjectRow($object->getEquipoDto(), $row);
                Util::setObjectRow($object->getEquipoDto()->getModeloDto(), $row);
                Util::setObjectRow($object->getEquipoDto()->getMarcaDto(), $row);
                
                $clienteSede = new ClienteSedeDto();
                $clienteSede->setId_cliente_sede($row['id_cliente_sede']);
                $clienteSede->setNombre($row['nombre_sede']);
                Util::setObjectRow($clienteSede->getClienteDto(),$row);
                
                $object->getEquipoDto()->setClienteSedeDto($clienteSede);
                
                $result[] = $object;
            }
            
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
        
    }
    
    /**
     * 
     * @param unknown $idEquipo
     * @throws Exception
     * @return \app\dtos\RecargasDto[]
     */
    public function getListRecargas($idEquipo = null) {
        
        try {
            $result = array();
            $arrayParams = array();
            $sql = 'SELECT
                        rcg.*,
                        prs.id_persona,
                        prs.primer_nombre,
                        prs.segundo_nombre,
                        prs.primer_apellido,
                        prs.segundo_apellido
                    FROM recarga rcg
                    INNER JOIN rh_representante rpt ON rcg.id_representante = rpt.id_representante
                    INNER JOIN persona prs ON rpt.id_persona = prs.id_persona
                WHERE 1 ';
            
            if (! Util::isVacio($idEquipo)) {
                $sql .= " AND rcg.id_equipo = :idEquipo ";
                $arrayParams[':idEquipo'] = $idEquipo;
            }
            
            $sql .= " ORDER BY rcg.fecha DESC";
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $object = new RecargasDto();
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
     * @since {23/05/2020}
     */
    public function getEquipos($serialC = null, $idCLienteC = null, $idEquipoC = null)
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
                $sql .= " AND ( eqp.serial_equipo LIKE '%".$serialC."%'  OR mdl.modelo LIKE '%".$serialC."%' OR mrc.nombre LIKE '%".$serialC."%' )";
                //$arrayParams[":serialC"] = ;
            }
            
            if (! Util::isVacio($idCLienteC)) {
                $sql .= " AND clt.id_cliente = :idCLienteC ";
                $arrayParams[':idCLienteC'] = $idCLienteC;
            }
            
            if (! Util::isVacio($idEquipoC)) {
                $sql .= " AND eqp.id_equipo = :idEquipoC ";
                $arrayParams[':idEquipoC'] = $idEquipoC;
            }
            
            $sql .= " ORDER BY mrc.id_marca, mdl.modelo, eqp.id_equipo ";
            $statement = Doctrine::prepare($sql);
            //echo $sql;
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
    
    /**
     *
     * @param ServicioDto $object
     * @throws Exception
     * @return boolean|number
     */
    public function saveMantenimiento(MantenimientoDto $object)
    {
        try {
            $result = false;
            //$representante = $this->getRepresentanteIdPersona(Util::userSessionDto()->getPersonaDto()->getId_persona());
            //$data['descripcion'] = $object->getDescripcion();
            //$data['pendientes'] = $object->getPendientes();
            $data['fecha'] = Util::fecha($object->getFecha());
            $data['id_equipo'] = $object->getId_equipo();
            $data['id_representante'] = $object->getId_representante();
            $data['estado'] = EEstadoMantenimiento::index(EEstadoMantenimiento::SOLICITADO)->getId();
            $data['antecedente'] = $object->getAntecedente();
            //$data['contador_negro'] = $object->getContador_negro();
//             $data['contador_cyan'] = $object->getContador_cyan();
//             $data['contador_magenta'] = $object->getContador_magenta();
//             $data['contador_amarillo'] = $object->getContador_amarillo();
            
            if (Util::isVacio($object->getId_mantenimiento())) {
                $data['id_usuario_registra'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('mantenimiento', $data);
            } else {
                $data['id_usuario_modifica'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_modifica'] = Util::fechaActual(true);
                $result = Doctrine::update('mantenimiento', $data, [
                    'id_mantenimiento' => $object->getId_mantenimiento()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    
    
    /**
     * 
     * @param ServicioDto $object
     * @throws Exception
     * @return boolean|number
     */
    public function save(RecargasDto $object)
    {
        try {
            $result = false;
            $representante = $this->getRepresentanteIdPersona(Util::userSessionDto()->getPersonaDto()->getId_persona());
            $data['descripcion'] = $object->getDescripcion();
            $data['pendientes'] = $object->getPendientes();
            $data['fecha'] = Util::fecha($object->getFecha());
            $data['id_equipo'] = $object->getId_equipo();           
            $data['id_representante'] = $representante->getId_representante();
            $data['contador_negro'] = $object->getContador_negro();
            $data['contador_cyan'] = $object->getContador_cyan();
            $data['contador_magenta'] = $object->getContador_magenta();
            $data['contador_amarillo'] = $object->getContador_amarillo();
            
            if (Util::isVacio($object->getId_recarga())) {
                $data['id_usuario_registra'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('recarga', $data);
            } else {
                $data['id_usuario_modifica'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_modifica'] = Util::fechaActual(true);
                $result = Doctrine::update('recarga', $data, [
                    'id_recarga' => $object->getId_recarga()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    

}