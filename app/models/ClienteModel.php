<?php
namespace app\models;

use app\enums\EnumGeneric;
use system\Core\Doctrine;
use system\Support\Util;
use app\dtos\ClienteDto;
use system\Support\Arr;
use app\enums\ESiNo;
use app\dtos\CiudadDto;
use app\dtos\ClienteSedeDto;
use app\dtos\ClienteSedeEquipoDto;
use app\dtos\EquipoDto;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 29/11/2016
 */
class ClienteModel
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/04/2018}
     */
    public function getListClientesEnum()
    {
        $listaRetorna = array();
        $list = $this->getListClientesDto();
        foreach ($list as $l) {
            $listaRetorna[] = new EnumGeneric($l->getId_cliente(), $l->getNombre_empresa());
            unset($l);
        }
        unset($list);
        return $listaRetorna;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/04/2018}
     * @param string $idClienteC            
     * @param string $nitC            
     * @param string $equiposC            
     * @throws Exception
     * @return multitype:unknown
     */
    public function getListClientesDto($idClienteC = null, $nitC = null, $equiposC = false)
    {
        try {
            $result = array();
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
                $result[] = $object;
                unset($row, $object);
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
                         clt.*,
                         cd.*,
                         cls.id_cliente_sede,
                         cls.nombre nombre_sede,
                         cls.telefono telefono_sede,
                         cls.direccion direccion_sede
                    FROM cliente clt
                    INNER JOIN ciudad cd
                        ON cd.id_ciudad = clt.id_ciudad
                    INNER JOIN cliente_sede cls
                        ON cls.id_cliente = clt.id_cliente
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
                if (Arr::isNullArray($row['id_cliente'], $result)) {
                    $object = new ClienteDto();
                    Util::setObjectRow($object, $row);
                    Util::setObjectRow($object->getCiudadDto(), $row);
                } else {
                    $object = $result[$row['id_cliente']];
                }
                
                $listSedes = $object->getList_sedes();
                $sede = new ClienteSedeDto();
                $sede->setId_cliente_sede($row['id_cliente_sede']);
                $sede->setId_cliente($object->getId_cliente());
                $sede->setDireccion($row['direccion_sede']);
                $sede->setTelefono($row['telefono_sede']);
                $sede->setNombre($row['nombre_sede']);
                
                if ($equiposC) {
                    $listIdSede[$sede->getId_cliente_sede()] = $sede->getId_cliente_sede();
                }
                
                $listSedes[] = $sede;
                $object->setList_sedes($listSedes);
                
                $result[$object->getId_cliente()] = $object;
            }
            
            if ($equiposC) {
                $listEquipos = $this->geCountEquipos($listIdSede);
                foreach ($result as $cliente) {
                    foreach ($cliente->getList_sedes() as $sede) {
                        if (! Arr::isNullArray($sede->getId_cliente_sede(), $listEquipos)) {
                            $sede->setNum_equipos($listEquipos[$sede->getId_cliente_sede()]);
                        } else {
                            $sede->setNum_equipos(0);
                        }
                        unset($sede);
                    }
                    unset($cliente);
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
     * @since {26/01/2018}
     * @param string $idClienteC            
     * @throws Exception
     * @return multitype:unknown
     */
    public function getClienteSede($idClienteSedeC = null)
    {
        try {
            $result = array();
            $listIdSede = array();
            $arrayParams = array();
            $sql = 'SELECT
                         cl.*,
                         cse.*,
                         eqp.*,
                         mdl.tipo,
                         mdl.modelo,
                         mdl.estilo,
                         mrc.nombre,
                         cls.id_cliente_sede,
                         cls.nombre nombre_sede,
                         cls.telefono telefono_sede,
                         cls.direccion direccion_sede,
                         cse.id_cliente_sede_equipo
                    FROM cliente_sede cls
                    INNER JOIN cliente cl
                        ON cl.id_cliente = cls.id_cliente
                    LEFT JOIN cliente_sede_equipo cse
                        ON cse.id_cliente_sede = cls.id_cliente_sede
                    LEFT JOIN equipo eqp 
                        ON eqp.id_equipo = cse.id_equipo
                    LEFT JOIN equipo_modelo mdl
                        ON mdl.id_modelo = eqp.id_modelo
                    LEFT JOIN equipo_marca mrc
                        ON mrc.id_marca = mdl.id_marca 
                    WHERE 1 ';
            if (! Util::isVacio($idClienteSedeC)) {
                $sql .= " AND cls.id_cliente_sede = :idClienteC ";
                $arrayParams[':idClienteC'] = $idClienteSedeC;
            }
            
            $sql .= " ORDER BY cse.id_cliente_sede_equipo ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                if (Arr::isNullArray($row['id_cliente_sede'], $result)) {
                    $object = new ClienteSedeDto();
                    
                    $object->setId_cliente_sede($row['id_cliente_sede']);
                    $object->setId_cliente($row['id_cliente']);
                    $object->setDireccion($row['direccion_sede']);
                    $object->setTelefono($row['telefono_sede']);
                    $object->setNombre($row['nombre_sede']);
                    
                    Util::setObjectRow($object->getClienteDto(), $row);
                } else {
                    $object = $result[$row['id_cliente_sede']];
                }
                
                $listEquipos = $object->getList_equipos();
                if (! Util::isVacio($row['id_cliente_sede_equipo'])) {
                    $equipo = new ClienteSedeEquipoDto();
                    Util::setObjectRow($equipo, $row);
                    Util::setObjectRow($equipo->getEquipoDto(), $row);
                    Util::setObjectRow($equipo->getEquipoDto()->getModeloDto(), $row);
                    Util::setObjectRow($equipo->getEquipoDto()->getMarcaDto(), $row);
                    $listEquipos[] = $equipo;
                }
                $object->setList_equipos($listEquipos);
                
                $result[$row['id_cliente_sede']] = $object;
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
     * @since {14/04/2018}
     * @param string $idClienteSedeC            
     * @throws Exception
     * @return multitype:unknown
     */
    public function getClienteListSede($idClienteC = null, $fechaMesC = null)
    {
        try {
            $result = array();
            $listIdSede = array();
            $arrayParams = array();
            $sql = "SELECT
                         cl.*,                         
                         cse.*,
                         coalesce(clf.contador_copia_bn_ant, cse.contador_copia_bn) as contador_copia_bn_ant,
                         coalesce(clf.contador_impresion_bn_ant, cse.contador_impresion_bn) as contador_impresion_bn_ant,
                         coalesce(clf.contador_copia_color_ant, cse.contador_copia_color) as contador_copia_color_ant,
                         coalesce(clf.contador_impresion_color_ant, cse.contador_impresion_color) as contador_impresion_color_ant,
                         coalesce(clf.contador_scanner_ant, cse.contador_scanner) as contador_scanner_ant,
                         clf.contador_copia_bn,
                         clf.contador_impresion_bn,
                         clf.contador_copia_color,
                         clf.contador_impresion_color,
                         clf.contador_scanner,
                         clf.id_cliente_sede_equipo_fecha,
                         eqp.*,
                         mdl.tipo,
                         mdl.modelo,
                         mdl.estilo,
                         mrc.nombre,
                         cls.id_cliente_sede,
                         cls.nombre nombre_sede,
                         cls.telefono telefono_sede,
                         cls.direccion direccion_sede,
                         cse.id_cliente_sede_equipo
                    FROM cliente_sede cls
                    INNER JOIN cliente cl
                        ON cl.id_cliente = cls.id_cliente
                    INNER JOIN cliente_sede_equipo cse
                        ON cse.id_cliente_sede = cls.id_cliente_sede
                    LEFT JOIN cliente_sede_equipo_fecha clf
                        ON clf.id_cliente_sede_equipo = cse.id_cliente_sede_equipo
                        AND clf.fecha_mes = '{$fechaMesC}'
                    INNER JOIN equipo eqp
                        ON eqp.id_equipo = cse.id_equipo
                    INNER JOIN equipo_modelo mdl
                        ON mdl.id_modelo = eqp.id_modelo
                    INNER JOIN equipo_marca mrc
                        ON mrc.id_marca = mdl.id_marca
                    WHERE 1 ";
            if (! Util::isVacio($idClienteC)) {
                $sql .= " AND cl.id_cliente = :idClienteC ";
                $arrayParams[':idClienteC'] = $idClienteC;
            }
            
            $sql .= " ORDER BY cse.id_cliente_sede_equipo ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                if (Arr::isNullArray($row['id_cliente'], $result)) {
                    $object = new ClienteDto();
                    Util::setObjectRow($object, $row);
                } else {
                    $object = $result[$row['id_cliente']];
                }
                
                $listSedes = $object->getList_sedes();
                if (Arr::isNullArray($row['id_cliente_sede'], $listSedes)) {
                    $sede = new ClienteSedeDto();
                    $sede->setId_cliente_sede($row['id_cliente_sede']);
                    $sede->setId_cliente($row['id_cliente']);
                    $sede->setDireccion($row['direccion_sede']);
                    $sede->setTelefono($row['telefono_sede']);
                    $sede->setNombre($row['nombre_sede']);
                } else {
                    $sede = $listSedes[$row['id_cliente_sede']];
                }
                
                $listEquipos = $sede->getList_equipos();
                if (! Util::isVacio($row['id_cliente_sede_equipo'])) {
                    $equipo = new ClienteSedeEquipoDto();
                    Util::setObjectRow($equipo, $row);
                    Util::setObjectRow($equipo->getEquipoDto(), $row);
                    Util::setObjectRow($equipo->getEquipoDto()->getModeloDto(), $row);
                    Util::setObjectRow($equipo->getEquipoDto()->getMarcaDto(), $row);
                    $listEquipos[] = $equipo;
                }
                $sede->setList_equipos($listEquipos);
                $listSedes[$row['id_cliente_sede']] = $sede;
                $object->setList_sedes($listSedes);
                $result[$row['id_cliente']] = $object;
                unset($listSedes, $listEquipos, $equipo, $sede, $object);
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
     * @since {25/01/2018}
     */
    public function geCountEquipos($listSedes = array())
    {
        $result = array();
        try {
            $arrayParams = array();
            $sql = " SELECT
                        cse.id_cliente_sede id,
                        COUNT(cse.id_equipo) num_equipos
                      FROM cliente_sede_equipo cse
                        WHERE 1 ";
            if (! Arr::isEmptyArray($listSedes)) {
                $sql .= " AND cse.id_cliente_sede IN (" . Arr::implode($listSedes) . ") ";
            }
            
            $sql .= " GROUP BY cse.id_cliente_sede ";
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $result[$row['id']] = $row['num_equipos'];
                unset($lis);
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
     * @since {25/01/2018}
     * @param string $searchC            
     * @throws Exception
     * @return multitype:unknown
     */
    public function getListAutoClientes($searchC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = 'SELECT
                         clt.*
                    FROM cliente clt
                WHERE 1 ';
            if (! Util::isVacio($searchC)) {
                $sql .= " AND (clt.nit LIKE :searchC OR UPPER(clt.nombre_empresa) LIKE UPPER(:searchC) )";
                $arrayParams[':searchC'] = "%" . $searchC . "%";
            }
            
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            
            foreach ($list as $row) {
                $object = new ClienteDto();
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
     * @since {22/01/2018}
     * @param string $searchC            
     * @throws Exception
     * @return multitype:\app\dtos\ClienteDto
     */
    public function getListCiudades($searchC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = 'SELECT
                         *
                    FROM ciudad
                WHERE 1 ';
            if (! Util::isVacio($searchC)) {
                $sql .= " AND nombre_ciudad LIKE :searchC ";
                $arrayParams[':searchC'] = "%" . $searchC . "%";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new CiudadDto();
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
     * @since {29/01/2018}
     * @param string $idEquipoC            
     * @param string $serialC            
     * @param string $activoC            
     * @return multitype:\app\enums\EnumGeneric
     */
    public function getEquiposEnum($idEquipoC = null, $serialC = null, $activoC = null)
    {
        $return = array();
        $lista = $this->getEquipos($idEquipoC = null, $serialC = null, $activoC);
        foreach ($lista as $l) {
            $return[] = new EnumGeneric($l->getId_equipo(), $l->getMarcaDto()->getNombre() . " (" . $l->getModeloDto()->getModelo() . ") " . $l->getSerial_equipo());
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/01/2018}
     * @param string $idEquipoC            
     * @param string $serialC            
     * @throws Exception
     * @return multitype:\app\models\EquipoDto
     */
    public function getEquipos($idEquipoC = null, $serialC = null, $activoC)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT
                        eqp.id_equipo,
                        eqp.id_modelo,
                        eqp.serial_equipo,
                        eqp.estado,
                        mdl.tipo,
                        mdl.modelo,
                        mdl.estilo,
                        mrc.nombre
                     FROM equipo eqp
                        INNER JOIN equipo_modelo mdl
                            ON mdl.id_modelo = eqp.id_modelo
                        INNER JOIN equipo_marca mrc
                            ON mrc.id_marca = mdl.id_marca
                     WHERE 1 ";
            if (! Util::isVacio($idEquipoC)) {
                $sql .= " AND eqp.id_equipo = :idEquipoC ";
                $arrayParams[':idEquipoC'] = $idEquipoC;
            }
            
            if (! Util::isVacio($serialC)) {
                $sql .= " AND eqp.serial_equipo = :serialC ";
                $arrayParams[':serialC'] = $serialC;
            }
            
            if (! Util::isVacio($activoC)) {
                $sql .= " AND eqp.estado IN ( ".$activoC." )";
                //$arrayParams[':estadoC'] = $activoC;
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
     * @since {22/01/2018}
     * @param ClienteDto $object            
     */
    public function setGuardarCliente(ClienteDto $object)
    {
        $result = false;
        try {
            if (Util::isVacio($object->getCiudadDto()->getId_ciudad())) {
                $dataTemp['nombre_ciudad'] = $object->getCiudadDto()->getNombre_ciudad();
                $idCiudad = Doctrine::insert('ciudad', $dataTemp);
                $object->getCiudadDto()->setId_ciudad($idCiudad);
                unset($dataTemp);
            }
            
            $data['id_ciudad'] = $object->getCiudadDto()->getId_ciudad();
            $data['nombre_empresa'] = $object->getNombre_empresa();
            $data['razon_social'] = $object->getRazon_social();
            $data['nit'] = $object->getNit();
            $data['telefono'] = $object->getTelefono();
            $data['movil'] = $object->getMovil();
            $data['email'] = $object->getEmail();
            $data['tipo_cliente'] = $object->getTipo_cliente();
            $data['observacion'] = $object->getObservacion();
            $data['contacto'] = $object->getContacto();
            $data['direcion'] = $object->getDirecion();
            $data['descuento_scanner'] = $object->getDescuento_scanner();
            $data['yn_activo'] = ESiNo::index(ESiNo::SI)->getId();
            
            if (Util::isVacio($object->getId_cliente())) {
                $data['id_usuario_registro'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('cliente', $data);
                $object->setId_cliente($result);
            } else {
                $data['id_usuario_modifica'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_modificacion'] = Util::fechaActual(true);
                $result = Doctrine::update('cliente', $data, [
                    'id_cliente' => $object->getId_cliente()
                ]);
            }
            
            foreach ($object->getList_sedes() as $sede) {
                $dataSede['id_cliente'] = $object->getId_cliente();
                $dataSede['nombre'] = $sede->getNombre();
                $dataSede['direccion'] = $sede->getDireccion();
                $dataSede['telefono'] = $sede->getTelefono();
                
                if (Util::isVacio($sede->getId_cliente_sede())) {
                    $result = Doctrine::insert('cliente_sede', $dataSede);
                } else {
                    $result = Doctrine::update('cliente_sede', $dataSede, [
                        'id_cliente_sede' => $sede->getId_cliente_sede()
                    ]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $object->getId_cliente();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {31/01/2018}
     * @param ClienteDto $object            
     * @throws Exception
     * @return number
     */
    public function setGuardarEquipo(ClienteSedeDto $object)
    {
        $result = false;
        try {
            foreach ($object->getList_equipos() as $equipo) {
                $equipo instanceof ClienteSedeEquipoDto;
                $data['id_cliente_sede'] = $object->getId_cliente_sede();
                $data['id_equipo'] = $equipo->getId_equipo();
                $data['separar_copia_impresion'] = $equipo->getSeparar_copia_impresion();
                $data['contador_scanner'] = Util::ceroToNull($equipo->getContador_scanner());
                $data['costo_scanner'] = Util::ceroToNull($equipo->getCosto_scanner());
                
                $data['contador_copia_bn'] = Util::ceroToNull($equipo->getContador_copia_bn());
                $data['contador_impresion_bn'] = Util::ceroToNull($equipo->getContador_impresion_bn());
                $data['costo_impresion_bn'] = Util::ceroToNull($equipo->getCosto_impresion_bn());
                
                $data['contador_copia_color'] = Util::ceroToNull($equipo->getContador_copia_color());
                $data['contador_impresion_color'] = Util::ceroToNull($equipo->getContador_impresion_color());
                $data['costo_impresion_color'] = Util::ceroToNull($equipo->getCosto_impresion_color());
                
                $data['plan_minimo'] = Util::ceroToNull($equipo->getPlan_minimo());
                $data['incluir_scanner'] = $equipo->getIncluir_scanner();
                // $data[''] = $equipo->getIncluir_scanner();
                
                if (Util::isVacio($equipo->getId_cliente_sede_equipo())) {
                    $data['fecha_registro'] = Util::fechaActual(true);
                    $data['id_usuario_registro'] = Util::userSessionDto()->getIdUsuario();
                    $result = Doctrine::insert('cliente_sede_equipo', $data);
                } else {
                    $result = Doctrine::update('cliente_sede_equipo', $data, [
                        'id_cliente_sede_equipo' => $equipo->getId_cliente_sede_equipo()
                    ]);
                }
                
                $result = Doctrine::update('equipo', [
                    'estado' => $equipo->getEstado()
                ], [
                    'id_equipo' => $equipo->getId_equipo()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $object->getId_cliente_sede();
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {24/01/2018}
     */
    public function setDeleteSeede($idSedeC)
    {
        $return = false; //
        if (! Util::isVacio($idSedeC)) {
            $return = Doctrine::delete('cliente_sede', [
                'id_cliente_sede' => $idSedeC
            ]);
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/04/2018}
     */
    public function setSaveEquipoSedeFecha($data = array(), $idEquipoSedeFechaC = null, $idEquipoSedeC = null, $columnC = null)
    {
        $result = $idEquipoSedeFechaC;
        if (Util::isVacio($idEquipoSedeFechaC)) {
            $data['fecha_registro'] = Util::fechaActual(true);
            $data['id_usuario_registro'] = Util::userSessionDto()->getIdUsuario();
            $result = Doctrine::insert('cliente_sede_equipo_fecha', $data);
        } else {
            $data['fecha_modificacion'] = Util::fechaActual(true);
            $data['id_usuario_modifica'] = Util::userSessionDto()->getIdUsuario();
            Doctrine::update('cliente_sede_equipo_fecha', $data, [
                'id_cliente_sede_equipo_fecha' => $idEquipoSedeFechaC
            ]);
        }
        
        // Rp. actualiza contadores en el equipo
        Doctrine::update('cliente_sede_equipo', [
            $columnC => $data[$columnC]
        ], [
            'id_cliente_sede_equipo' => $idEquipoSedeC
        ]);
        
        unset($data, $idEquipoSedeFecha, $idEquipoSedeC, $columnC);
        return $result;
    }
}