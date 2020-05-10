<?php
namespace app\models;

use system\Support\Util;
use app\dtos\UsuarioPerfilDto;
use app\dtos\UsuarioPerfilAsignadoDto;
use app\dtos\RhRepresentanteDto;
use app\enums\ESiNo;
use system\Core\Persistir;
use system\Support\Arr;
use app\dtos\PersonaDto;
use app\dtos\UsuarioDto;
use app\dtos\ClienteDto;
use system\Core\Doctrine;
use app\enums\EEstadoSesion;
use app\enums\EEstadoCuenta;
use app\dtos\SubPaqueteDto;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since nov 10, 2016
 */
class UsuarioModel
{

    /**
     *
     * @tutorial Metodo Descripcion: consulta los perfiles creados
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param string $idPerfilC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilDto
     */
    public function getUserProfiles($idPerfilC = NULL)
    {
        try {
            $arrayParams = array();
            $result = array();
            $sql = " SELECT
                        id_perfil,
                        nombre,
                        yn_activo
                    FROM
                        usuario_perfil
                    WHERE 1 ";
            if (! Util::isVacio($idPerfilC)) {
                $sql .= " AND id_perfil = :idPerfilC";
                $arrayParams[':idPerfilC'] = $idPerfilC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilDto();
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
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 10, 2016}
     * @param string $idPersonaC            
     * @param string $idUsuarioC            
     * @param string $nombreC            
     * @throws Exception
     * @return multitype:\app\dtos\UsuarioDto
     */
    public function getPersonaUsuario($idPersonaC = NULL, $idUsuarioC = NULL, $nombreC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                    per.id_persona,
                    per.primer_nombre,
                    per.segundo_nombre,
                    per.primer_apellido,
                    per.segundo_apellido,
                    usu.id_usuario,
                    usu.yn_activo
                FROM
                    usuario usu
                    INNER JOIN persona per
                        ON usu.id_persona = per.id_persona
                WHERE 1 ";
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND per.id_persona = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
            }
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND usu.id_usuario = :idUsuarioC ";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
            if (! Util::isVacio($nombreC)) {
                $sql .= " AND (
                        per.numero_identificacion LIKE :nombreC
                        OR per.primer_apellido LIKE :nombreC
                        OR per.segundo_apellido LIKE :nombreC
                        OR per.primer_nombre LIKE :nombreC
                        OR per.segundo_nombre LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.segundo_nombre,
                          ' ',
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido,
                          '',
                          per.primer_nombre,
                          ' '
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.primer_apellido
                        ) LIKE :nombreC
                      )";
                $arrayParams[':nombreC'] = "%" . $nombreC . "%";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioDto();
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
     * @tutorial Metodo Descripcion: consulta las personas asociadas a un perfil
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/04/2015
     * @param string $idPersonaC            
     * @param string $idUsuarioC            
     * @param string $idPerfilC            
     * @throws \Exception
     * @return multitype:\app\dtos\PersonaDto
     */
    public function getPersonaUsuariosPerfil($idPersonaC = NULL, $idUsuarioC = NULL, $idPerfilC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                        per.id_persona,
                        per.primer_nombre,
                        per.segundo_nombre,
                        per.primer_apellido,
                        per.segundo_apellido,
                        usu.id_usuario,
                        usu.yn_activo,
                        asi.id_perfil
                    FROM persona per
                        INNER JOIN usuario usu
                            ON usu.id_persona = per.id_persona
                        INNER JOIN usuario_perfil_asignado asi
                            ON asi.id_usuario = usu.id_usuario
                    WHERE 1 ";
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND per.id_persona = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
            }
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND usu.id_usuario = :idUsuarioC ";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
            if (! Util::isVacio($idPerfilC)) {
                $sql .= " AND asi.id_perfil = :idPerfilC ";
                $arrayParams[':idPerfilC'] = $idPerfilC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new PersonaDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getUsuarioDto(), $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description: consulta los perfiles asociados de un usuario en particular
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 10, 2016}
     * @param str $idUsuarioC            
     * @throws Exception
     * @return multitype:\app\dtos\UsuarioPerfilAsignadoDto
     */
    public function getPerfilAsignadoUsuario($idUsuarioC)
    {
        try {
            $result = array();
            $sql = "SELECT
                        per.id_perfil,
                        per.nombre,
                        upa.id_usuario
                    FROM usuario usu
                        INNER JOIN usuario_perfil_asignado upa
                            ON upa.id_usuario = usu.id_usuario
                                AND upa.id_usuario = :idUsuarioC
                        RIGHT JOIN usuario_perfil per
                            ON per.id_perfil = upa.id_perfil ";
            $arrayParams[':idUsuarioC'] = $idUsuarioC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilAsignadoDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPerfilDto(), $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los representantes
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 15/05/2015
     * @param string $idRepresentanteC            
     * @param string $idPersonaC            
     * @param string $idUsuarioC            
     * @param string $nombreC            
     * @throws \Exception
     * @return multitype:\app\dtos\PersonaDto
     */
    public function getListRepresentantes($idRepresentanteC = NULL, $idPersonaC = NULL, $nombreC = NULL, $idServicioC = NULL, $cargoC = NULL)
    {
        try {
            $result = array();
            $sql = "SELECT
                        rep.id_representante,
                        rep.fecha_creacion,
                        rep.yn_activo,
                        per.id_persona,
                        per.primer_nombre,
                        per.segundo_nombre,
                        per.primer_apellido,
                        per.segundo_apellido
                    FROM persona per
                        INNER JOIN rh_representante rep
                            ON rep.id_persona = per.id_persona ";
            if (! Util::isVacio($cargoC)) {
                $sql .= " INNER JOIN rh_representante_cargo rc
                ON rc.id_representante = rep.id_representante
                AND rc.id_cargo = $cargoC ";
            }
            if (! Util::isVacio($idServicioC)) {
                $sql .= " INNER JOIN rh_representante_servicio rs
                ON rs.id_representante = rep.id_representante
                AND rs.id_servicio = $idServicioC ";
            }
            
            $sql .= " WHERE 1 ";
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND rep.id_reprsentante = :idRepresentanteC ";
                $arrayParams[':idRepresentanteC'] = $idRepresentanteC;
            }
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND per.id_persona = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
            }
            if (! Util::isVacio($nombreC)) {
                $sql .= " AND (
                        per.numero_identificacion LIKE :nombreC
                        OR per.primer_apellido LIKE :nombreC
                        OR per.segundo_apellido LIKE :nombreC
                        OR per.primer_nombre LIKE :nombreC
                        OR per.segundo_nombre LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.segundo_nombre,
                          ' ',
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_apellido,
                          ' ',
                          per.segundo_apellido,
                          '',
                          per.primer_nombre,
                          ' '
                        ) LIKE :nombreC
                      )
                      OR (
                        CONCAT(
                          per.primer_nombre,
                          ' ',
                          per.primer_apellido
                        ) LIKE :nombreC
                      )";
                $arrayParams[':nombreC'] = "%" . $nombreC . "%";
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
     * @tutorial Metodo Descripcion: consulta los perfiles creados
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 2/04/2015
     *       
     * @param string $idPerfilC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilDto
     */
    public function getPerfilsUser($idPerfilC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT up.* FROM usuario_perfil up WHERE 1 ";
            if (! Util::isVacio($idPerfilC)) {
                $sql .= " AND up.id_perfil = :idPerfilC";
                $arrayParams[':idPerfilC'] = $idPerfilC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilDto();
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
     * @tutorial cambia el estado del perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {6/10/2015}
     * @param UsuarioPerfilDto $object            
     * @return boolean
     */
    public function setCambiarEstadoPerfil($object)
    {
        $data['yn_activo'] = ($object->getYn_activo() == ESiNo::index(ESiNo::SI)->getId() ? ESiNo::index(ESiNo::NO)->getId() : ESiNo::index(ESiNo::SI)->getId());
        return Doctrine::update('usuario_perfil', $data, [
            'id_perfil' => $object->getId_perfil()
        ]);
    }

    /**
     *
     * @tutorial registra o edita un perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {11/10/2015}
     * @param UsuarioPerfilDto $object            
     */
    public function setAddEditProfile($object)
    {
        try {
            
            $arrayPerfil['nombre'] = $object->getNombre();
            $arrayPerfil['yn_activo'] = $object->getYn_activo();
            if (Util::isVacio($object->getId_perfil())) {
                $result = Doctrine::insert('usuario_perfil', $arrayPerfil);
                $idPerfil = $result;
                $object->setId_perfil($idPerfil);
            } else {
                $result = Doctrine::update('usuario_perfil', $arrayPerfil, [
                    'id_perfil' => $object->getId_perfil()
                ]);
            }
            if (! Util::isVacio(Persistir::getParam('txtMenu'))) {
                foreach (Persistir::getParam('txtMenu') as $lis) {
                    $result = Doctrine::insert('usuario_perfil_permiso', [
                        'id_perfil' => $object->getId_perfil(),
                        'id_menu' => $lis
                    ]);
                }
            }
            if (! Util::isVacio(Persistir::getParam('txtYn_view'))) {
                foreach (Persistir::getParam('txtYn_view') as $lis) {
                    $result = Doctrine::update('usuario_perfil_permiso', array(
                        'yn_view' => ESiNo::index(ESiNo::SI)->getId()
                    ), array(
                        'id_perfil' => $object->getId_perfil(),
                        'id_menu' => $lis
                    ));
                }
            }
            if (! Util::isVacio(Persistir::getParam('txtYn_add'))) {
                foreach (Persistir::getParam('txtYn_add') as $lis) {
                    $result = Doctrine::update('usuario_perfil_permiso', array(
                        'yn_add' => ESiNo::index(ESiNo::SI)->getId()
                    ), array(
                        'id_perfil' => $object->getId_perfil(),
                        'id_menu' => $lis
                    ));
                }
            }
            if (! Util::isVacio(Persistir::getParam('txtYn_edit'))) {
                foreach (Persistir::getParam('txtYn_edit') as $lis) {
                    $result = Doctrine::update('usuario_perfil_permiso', array(
                        'yn_edit' => ESiNo::index(ESiNo::SI)->getId()
                    ), array(
                        'id_perfil' => $object->getId_perfil(),
                        'id_menu' => $lis
                    ));
                }
            }
            if (! Util::isVacio(Persistir::getParam('txtYn_del'))) {
                foreach (Persistir::getParam('txtYn_del') as $lis) {
                    $result = Doctrine::update('usuario_perfil_permiso', array(
                        'yn_delete' => ESiNo::index(ESiNo::SI)->getId()
                    ), array(
                        'id_perfil' => $object->getId_perfil(),
                        'id_menu' => $lis
                    ));
                }
            }
            return $object->getNombre();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial Method Description: guardar los permisos perteneciente a cada perfil
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {nov 12, 2016}
     * @return boolean
     */
    public function setGuardarPermisosPerfil()
    {
        try {
            $result = FALSE;
            $arrayElimina = array();
            $aObjetos = json_decode(Persistir::getParam('dataJson'));
            if (! Util::isVacio(Persistir::getParam('id_perfil'))) { // $_REQUEST
                $result = Doctrine::update('usuario_perfil', [
                    'nombre' => Persistir::getParam('nombre'),
                    'yn_activo' => Persistir::getParam('yn_activo')
                ], [
                    'id_perfil' => Persistir::getParam('id_perfil')
                ]);
                foreach ($aObjetos as $key => $value) {
                    $arrayColumnas = array();
                    $arrayDatos = array();
                    $arrayDatos['id_perfil'] = Persistir::getParam('id_perfil');
                    $arrayDatos['id_menu'] = $aObjetos[$key]->id_menu;
                    $arrayDatos['yn_view'] = $aObjetos[$key]->p_view;
                    $arrayDatos['yn_edit'] = $aObjetos[$key]->p_edit;
                    $arrayDatos['yn_add'] = $aObjetos[$key]->p_add;
                    $arrayDatos['yn_delete'] = $aObjetos[$key]->p_del;
                    $noPermit = ESiNo::index(ESiNo::NO)->getId();
                    if (($arrayDatos["yn_view"] == $noPermit) && ($arrayDatos["yn_edit"] == $noPermit) && ($arrayDatos["yn_add"] == $noPermit) && ($arrayDatos["yn_delete"] == $noPermit)) {
                        $arrayElimina[] = $aObjetos[$key]->id_menu;
                    }
                    foreach ($arrayDatos as $keyDato => $arr) {
                        $arrayColumnas[] = "$keyDato = ?";
                    }
                    $replace = Doctrine::prepare('REPLACE INTO usuario_perfil_permiso SET ' . Arr::implode($arrayColumnas));
                    $sec = 0;
                    foreach ($arrayDatos as $arr) {
                        $sec ++;
                        $replace->bindValue($sec, $arr);
                    }
                    unset($arrayDatos);
                    $result = $replace->execute();
                }
            }
            if (! Util::isVacio($arrayElimina)) {
                $result = Doctrine::delete('usuario_perfil_permiso', [
                    'id_perfil' => Persistir::getParam('id_perfil'),
                    'id_menu' => Arr::implode($arrayElimina)
                ]);
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial Method Description: guarda los perfiles asociados a un usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @param integer $idUsuarioC            
     * @param array $listaPerfil            
     * @return Ambigous <boolean, \system\Database\Util, string>
     */
    public function setSaveAssociatedProfile($idUsuarioC, $listaPerfil)
    {
        try {
            Doctrine::delete('usuario_perfil_asignado', [
                'id_usuario' => $idUsuarioC
            ]);
            $data['id_usuario'] = $idUsuarioC;
            if (! Util::isVacio($listaPerfil)) {
                if (! Util::isVacio($listaPerfil)) {
                    foreach ($listaPerfil as $lis) {
                        $data['id_perfil'] = $lis;
                        $result = Doctrine::insert('usuario_perfil_asignado', $data);
                    }
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial valida si el perfil tiene usuarios asignados
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {6/10/2015}
     * @param string $idPerfilC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioPerfilAsignadoDto
     */
    public function setValidateProfile($idPerfilC = NULL)
    {
        try {
            $result = array();
            $sql = "SELECT * FROM usuario_perfil_asignado upa WHERE id_perfil = :idPerfilC ";
            $arrayParams[':idPerfilC'] = $idPerfilC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilAsignadoDto();
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
     * @tutorial Method Description: consulta las personas que están de cumpleaños
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @param unknown $fechaActualC            
     * @param unknown $fechaNextC            
     * @throws \Exception
     * @return multitype:\app\dtos\PersonaDto
     */
    public function getClientesCumpleaños($fechaActualC, $next = false)
    {
        try {
            $arrayClientes = [];
            $arrayParams = [];
            $result = [];
            /*$sql = "SELECT cli.*, per.* FROM persona per INNER JOIN cliente cli ON cli.id_persona = per.id_persona WHERE 1 ";
            if ($next) {
                $sql .= " AND DATE_FORMAT(per.`fecha_nacimiento`,'%m-%d') >= DATE_FORMAT('$fechaActualC','%m-%d') ";
            } else {
                $sql .= " AND DATE_FORMAT(per.`fecha_nacimiento`,'%m-%d') = DATE_FORMAT('$fechaActualC','%m-%d') ";
            }
            $sql .= "ORDER BY DATE_FORMAT(per.`fecha_nacimiento`,'%m-%d') ASC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getPersonaDto(), $row);
                $arrayClientes[$object->getId_cliente()] = $object->getId_cliente();
                $result[] = $object;
            }
            if ($next) {
                $listPagos = $this->getClienteServicioPagoDetalle($arrayClientes);
                $listServices = $this->getTotalClienteServicios($arrayClientes);
                foreach ($result as $res) {
                    $valor_abono = ! Arr::isNullArray($res->getId_cliente(), $listPagos) ? $listPagos[$res->getId_cliente()] : 0;
                    $totalServices = ! Arr::isNullArray($res->getId_cliente(), $listServices) ? $listServices[$res->getId_cliente()] : 0;
                    $res->setValor_abono($valor_abono);
                    $res->setValor_inicial($totalServices);
                }
            }*/
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    public function getTotalClienteServicios($arrayClientes)
    {
        try {
            $result = [];
            $arrayParams = [];
            $sql = "SELECT
                    cli.id_cliente AS idCliente,
                    COUNT(cli.id_cliente_servicio) AS totalServicio
                FROM
                    cliente_servicio cli
                WHERE DATE_FORMAT(cli.fecha_registro, '%Y') = " . Util::year();
            if (! Util::isVacio($arrayClientes)) {
                $arrayClientes = Arr::isArray($arrayClientes) ? $arrayClientes : array(
                    $arrayClientes
                );
                $sql .= " AND cli.id_cliente IN (" . Arr::implode($arrayClientes) . ") ";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result[$row['idCliente']] = $row['totalServicio'];
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description: suma todos los pagos que ha realizado un cliente para el ano actual
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @param integer $idClienteC            
     * @throws \Exception
     * @return multitype:\app\dtos\ClienteDto
     */
    public function getClienteServicioPagoDetalle($arrayClientes)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                    cli.id_cliente AS idCliente,
                    SUM(pag.valor) AS valorTotal
    			FROM
                    cliente_servicio cli
                    INNER JOIN cliente_servicio_pago pag
                        ON pag.id_cliente_servicio = cli.id_cliente_servicio
                WHERE DATE_FORMAT(pag.fecha_pago, '%Y') = " . Util::year();
            if (! Util::isVacio($arrayClientes)) {
                $arrayClientes = Arr::isArray($arrayClientes) ? $arrayClientes : array(
                    $arrayClientes
                );
                $sql .= " AND cli.id_cliente IN (" . Arr::implode($arrayClientes) . ") ";
            }
            $sumPagos = array();
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                if (empty($result[$row['idCliente']])) {
                    $result[$row['idCliente']] = 0;
                }
                $result[$row['idCliente']] += $row['valorTotal'];
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
     * @since {11/12/2016}
     * @param string $idClienteC            
     * @param string $documentoC            
     * @param string $nombreC            
     * @throws Exception
     * @return multitype:\app\dtos\ClienteDto
     */
    public function getListclientes($idClienteC = NULL, $documentoC = NULL, $nombreC = NULL)
    {
        try {
            $arrayLlaves = [];
            $arrayParams = [];
            $result = [];
            $sql = 'SELECT
                        per.*,
                        clt.*
                    FROM cliente clt
                    INNER JOIN persona per
                        ON clt.id_persona = per.id_persona
                    WHERE 1 ';
            if (! Util::isVacio($idClienteC)) {
                $sql .= " AND clt.id_cliente = :idClienteC ";
                $arrayParams['idClienteC'] = $idClienteC;
            }
            
            if (! Util::isVacio($nombreC)) {
                $sql .= " AND (
                            per.numero_identificacion LIKE :nombreC
                            OR per.primer_apellido LIKE :nombreC
                            OR per.segundo_apellido LIKE :nombreC
                            OR per.primer_nombre LIKE :nombreC
                            OR per.segundo_nombre LIKE :nombreC
                          )
                          OR (
                            CONCAT(
                              per.primer_nombre,
                              ' ',
                              per.segundo_nombre,
                              ' ',
                              per.primer_apellido,
                              ' ',
                              per.segundo_apellido
                            ) LIKE :nombreC
                          )
                          OR (
                            CONCAT(
                              per.primer_nombre,
                              ' ',
                              per.primer_apellido,
                              ' ',
                              per.segundo_apellido
                            ) LIKE :nombreC
                          )
                          OR (
                            CONCAT(
                              per.primer_apellido,
                              ' ',
                              per.segundo_apellido,
                              '',
                              per.primer_nombre,
                              ' '
                            ) LIKE :nombreC
                          )
                          OR (
                            CONCAT(
                              per.primer_nombre,
                              ' ',
                              per.primer_apellido
                            ) LIKE :nombreC
                          )";
                $arrayParams[':nombreC'] = "%" . $nombreC . "%";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteDto();
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
     * @since {16/02/2017}
     * @param unknown $idDocumentoC            
     * @param unknown $fechaC            
     * @param unknown $estadoC            
     * @return multitype:boolean string
     */
    public function setCambiarEstadoSesionIndex($estadoC)
    {
        try {
            $result = TRUE;
            $arrayParams = array();
            $listPaquetes = $this->getClienteSubPaquete(NULL, $estadoC);
            if (! Arr::isEmptyArray($listPaquetes)) {
                $this->setConfirmarSesionesAnteriores($listPaquetes, $estadoC, EEstadoSesion::index(EEstadoSesion::CONNFIRMADA)->getId());
                $listActivos = $this->getListSesionesActivas($listPaquetes, [$estadoC, EEstadoSesion::index(EEstadoSesion::PENDIENTE)->getId()]);
                if (! Arr::isEmptyArray($listActivos)) {
                    $statement = Doctrine::prepare("UPDATE cliente_sub_paquete SET estado = :estadoC, fecha_modificacion = NOW() WHERE id_cliente_sub_paquete NOT IN (" . Arr::implode($listActivos) . ") ");
                    $statement->execute(array(
                        ':estadoC' => EEstadoCuenta::index(EEstadoCuenta::VENCIDA)->getId()
                    ));
                }
            }
            unset($listPaquetes);
            return TRUE;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/02/2017}
     * @param unknown $id_sup_paquete            
     * @param unknown $newEstadoC            
     * @throws Exception
     * @return \app\dtos\SubPaqueteDto
     */
    public function getListSesionesActivas($list_id_sup_paquete, $listEstadoC)
    {
        try {
            $result = array();
            $object = new SubPaqueteDto();
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                        csp.id_cliente_sub_paquete
                    FROM cliente_sub_paquete csp
                    INNER jOIN sesion_sub_paquete ssp
                        ON ssp.id_cliente_sub_paquete = csp.id_cliente_sub_paquete
                    INNER jOIN sub_paquete spq
                        ON spq.id_sub_paquete = csp.id_sub_paquete
                    WHERE 1 ";
            if (! Arr::isEmptyArray($listEstadoC)) {
                $sql .= " AND ssp.estado IN(". Arr::implode($listEstadoC) .") ";
                //$arrayParams[':newEstadoC'] = $listEstadoC;
            }
            if (! Arr::isEmptyArray($list_id_sup_paquete)) {
                $sql .= " AND ssp.id_cliente_sub_paquete IN (" . Arr::implode($list_id_sup_paquete) . ") ";
                // $arrayParams[':idsupaquete'] = $list_id_sup_paquete;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result[$row['id_cliente_sub_paquete']] = $row['id_cliente_sub_paquete'];
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
     * @since {16/02/2017}
     * @param unknown $listpaquetes            
     * @param unknown $fechaC            
     * @param unknown $estadoC            
     * @param unknown $newEstadoC            
     * @throws Exception
     * @return NULL
     */
    protected function setConfirmarSesionesAnteriores($keyClientessubPaquetesC, $estadoC, $newEstadoC)
    {
        try {
            $sql = "UPDATE sesion_sub_paquete SET estado = :estadoA WHERE fecha_hora_fin <= '".Util::fechaActual()." 00:00:00 ' AND estado =:estadoC";
            if (! Util::isVacio($keyClientessubPaquetesC)) {
                $sql .= " AND id_cliente_sub_paquete IN (" . Arr::implode($keyClientessubPaquetesC) . ") ";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute([
                ':estadoA' => $newEstadoC,
                ':estadoC' => $estadoC
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/02/2017}
     * @param string $idClienteC            
     * @param string $estadoC            
     * @throws Exception
     * @return multitype:unknown
     */
    public function getClienteSubPaquete($idClienteC = null, $estadoC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT DISTINCT
                        csp.id_cliente_sub_paquete
                    FROM cliente_sub_paquete csp
                    WHERE csp.estado = :estadoC ";
            $statement = Doctrine::prepare($sql);
            $statement->execute([
                'estadoC' => $estadoC
            ]);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result[$row['id_cliente_sub_paquete']] = $row['id_cliente_sub_paquete'];
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
}