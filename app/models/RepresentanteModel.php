<?php
namespace app\models;

use app\dtos\RhRepresentanteServicioDto;
use app\dtos\RhRepresentanteCargoDto;
use app\dtos\RhRepresentanteDto;
use app\dtos\ClienteCitaDto;
use system\Core\Doctrine;
use app\dtos\PersonaDto;
use app\dtos\UsuarioDto;
use app\dtos\ClienteDto;
use system\Support\Util;
use system\Support\Str;
use system\Support\Arr;
use app\enums\ESiNo;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 22/11/2016
 */
class RepresentanteModel
{

    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {17/01/2018}
     * @param unknown $representanteDto
     * @throws Exception
     * @return Ambigous <number, unknown>
     */
    public function setGuardarRepresentante($representanteDto)
    {
        try {
            $arrayPersona['email'] = $representanteDto->getPersonaDto()->getEmail();
            $arrayPersona['movil'] = $representanteDto->getPersonaDto()->getMovil();
            $arrayPersona['genero'] = $representanteDto->getPersonaDto()->getGenero();
            $arrayPersona['barrio'] = $representanteDto->getPersonaDto()->getBarrio();
            $arrayPersona['telefono'] = $representanteDto->getPersonaDto()->getTelefono();
            $arrayPersona['direccion'] = $representanteDto->getPersonaDto()->getDireccion();
            $arrayPersona['foto_perfil'] = lang('representante.foto_perfil', [
                $representanteDto->getPersonaDto()->getNumero_identificacion()
            ]);
            $arrayPersona['primer_nombre'] = $representanteDto->getPersonaDto()->getPrimer_nombre();
            $arrayPersona['segundo_nombre'] = $representanteDto->getPersonaDto()->getSegundo_nombre();
            $arrayPersona['primer_apellido'] = $representanteDto->getPersonaDto()->getPrimer_apellido();
            $arrayPersona['segundo_apellido'] = $representanteDto->getPersonaDto()->getSegundo_apellido();
            $arrayPersona['fecha_nacimiento'] = Util::fecha($representanteDto->getPersonaDto()->getFecha_nacimiento(), 'Y-m-d');
            $arrayPersona['tipo_identificacion'] = $representanteDto->getPersonaDto()->getTipo_identificacion();
            $arrayPersona['ciudad'] = $representanteDto->getPersonaDto()->getCiudad();
            $arrayPersona['numero_identificacion'] = $representanteDto->getPersonaDto()->getNumero_identificacion();
            if (Util::isVacio($representanteDto->getPersonaDto()->getId_persona())) {
                $arrayPersona['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('persona', $arrayPersona);
                $representanteDto->setId_persona($result);
                list ($login, $password) = $this->setLoginPassword($representanteDto->getPersonaDto());
                $arrayUsuario['id_persona'] = $representanteDto->getId_persona();
                $arrayUsuario['loggin'] = $login;
                $arrayUsuario['password'] = $password;
                $arrayUsuario['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('usuario', $arrayUsuario);
            } else {
                $result = Doctrine::update('persona', $arrayPersona, [
                    'id_persona' => $representanteDto->getId_persona()
                ]);
            }
            if (Util::isVacio($representanteDto->getId_representante())) {
                $arrayRepresentante['id_persona'] = $representanteDto->getId_persona();
                $arrayRepresentante['fecha_creacion'] = Util::fechaActual(TRUE);
                $arrayRepresentante['id_usuario_creacion'] = Util::userSessionDto()->getIdUsuario();
                $representante = Doctrine::insert('rh_representante', $arrayRepresentante);
                $representanteDto->setId_representante($representante);
            }
            Doctrine::delete('rh_representante_cargo', [
                'id_representante' => $representanteDto->getId_representante()
            ]);
            foreach ($representanteDto->getListCargos() as $cargo) {
                $arrayCargos = array();
                $arrayCargos['id_representante'] = $representanteDto->getId_representante();
                $arrayCargos['id_cargo'] = $cargo;
                $arrayCargos['yn_Activo'] = ESiNo::index(ESiNo::SI)->getId();
                $result = Doctrine::insert('rh_representante_cargo', $arrayCargos);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result ? $representanteDto->getPersonaDto()->getNombreCompleto() : $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {20/12/2015}
     * @param PersonaDto $personaDto            
     * @return boolean
     */
    public function setGuardarDatosRepresentante($personaDto)
    {
        // guarda la ciudad sino existe
        if (Util::isVacio($personaDto->getId_ciudad_documento())) {
            $arrayCiuadad['nombre'] = $personaDto->getCiudadDto()->getNombre();
            $id_ciudad = Util::insertArray($arrayCiuadad, 'ciudad');
            $personaDto->setId_ciudad_documento($id_ciudad);
        }
        
        $arrayPersona['movil'] = $personaDto->getMovil();
        $arrayPersona['barrio'] = $personaDto->getBarrio();
        $arrayPersona['telefono'] = $personaDto->getTelefono();
        $arrayPersona['direccion'] = $personaDto->getDireccion();
        $arrayPersona['estado_civil'] = $personaDto->getEstado_civil();
        $arrayPersona['primer_nombre'] = $personaDto->getPrimer_nombre();
        $arrayPersona['segundo_nombre'] = $personaDto->getSegundo_nombre();
        $arrayPersona['primer_apellido'] = $personaDto->getPrimer_apellido();
        $arrayPersona['segundo_apellido'] = $personaDto->getSegundo_apellido();
        $arrayPersona['fecha_nacimiento'] = $personaDto->getFecha_nacimiento();
        $arrayPersona['id_ciudad_documento'] = $personaDto->getId_ciudad_documento();
        try {
            $result = Util::updateArray($arrayPersona, 'persona', 'id_persona=?', [
                $personaDto->getId_persona()
            ]);
            return $result ? $personaDto->getNombreCompleto() : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @tutorial Method Description: consulta los datos de las personas
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param string $idPersonaC            
     * @param string $numeroIdentificacionC            
     * @throws \Exception
     * @return multitype:\app\dtos\PersonaDto
     */
    public function getDatosPersona($idPersonaC = NULL, $numeroIdentificacionC = NULL, $emailC = NULL)
    {
        try {
            $arrayParams = [];
            $result = [];
            $sql = 'SELECT per.* FROM persona per WHERE 1 ';
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND per.id_persona = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
            }
            if (! Util::isVacio($numeroIdentificacionC)) {
                $sql .= " AND per.numero_identificacion = :numeroIdentificacionC ";
                $arrayParams[':numeroIdentificacionC'] = $numeroIdentificacionC;
            }
            if (! Util::isVacio($emailC)) {
                $sql .= " AND per.email = :emailC ";
                $arrayParams[':emailC'] = $emailC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new PersonaDto();
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
     * @tutorial Method Description: consulta los datos del usuario
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {20/12/2015}
     * @param string $idUsuarioC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioDto
     */
    public function getDatosUsuarios($idUsuarioC = NULL)
    {
        try {
            $result = [];
            $arrayParams = [];
            $sql = 'SELECT
                    usu.*
                FROM usuario usu
                WHERE 1 ';
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND usu.id_persona = :idUsuarioC ";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioDto();
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
     * @since {24/04/2016}
     * @param integer $idUsuarioC            
     * @param sha1 $passwordC            
     * @return boolean
     */
    public function setPassword($idUsuarioC, $passwordC)
    {
        try {
            Doctrine::update('usuario', [
                'password' => $passwordC,
                'fecha_modificacion' => Util::fechaActual(true)
            ], $identifier = [
                'id_usuario' => $idUsuarioC
            ]);
            $result = TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {31/10/2015}
     * @param PersonaDto $personaDto            
     * @return multitype:string number
     */
    public function setLoginPassword($personaDto)
    {
        $primerNombre = Util::trim(Str::lower($personaDto->getPrimer_nombre()));
        $primerApellido = Util::trim(Str::lower($personaDto->getPrimer_apellido()));
        
        $primerNombre = Str::quitAccent($primerNombre);
        $primerApellido = Str::quitAccent($primerApellido);
        
        $letter = Str::substr($primerNombre, 0, 1);
        $loginTemporal = $letter . $primerApellido;
        
        $loginTemporal = Str::lower($loginTemporal);
        $arrayLogin = $this->getUsuarioLogin(NULL, $loginTemporal);
        $ultimoMayor = 0;
        foreach ($arrayLogin as $lis) {
            $partes = Arr::explode($lis->getLoggin(), $loginTemporal);
            if (isset($partes[1])) {
                if (is_numeric($partes[1])) {
                    if ($partes[1] > $ultimoMayor) {
                        $ultimoMayor = $partes[1];
                    }
                }
            }
        }
        
        $nuevoLoggin = $loginTemporal . ($ultimoMayor + 1);
        $nuevoPassword = Util::rand(1000, 9999);
        return array(
            $nuevoLoggin,
            $nuevoPassword
        );
    }

    /**
     *
     * @tutorial Method Description: consulta el usuario
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {31/10/2015}
     * @param string $idUsuarioC            
     * @param string $loginC            
     * @throws \Exception
     * @return multitype:\app\dtos\UsuarioDto
     */
    public function getUsuarioLogin($idUsuarioC = NULL, $loginC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT * FROM usuario WHERE 1 ";
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND id_usuario = :idUsuarioC ";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
            if (! Util::isVacio($loginC)) {
                $sql .= " AND loggin LIKE :loginC ";
                $arrayParams[':loginC'] = "%" . $loginC . "%";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los representantes
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 21/11/2016
     * @param string $idRepresentanteC            
     * @param string $documentoC            
     * @param string $nombreC            
     * @throws \Exception
     * @return multitype:\app\dtos\RhRepresentanteDto
     */
    public function getListRepresentantes($idRepresentanteC = NULL, $numeroDocumentoC = NULL, $nombreC = NULL)
    {
        try {
            $arrayLlaves = [];
            $arrayParams = [];
            $result = [];
            $sql = 'SELECT
                        rep.*,
                        per.*,
                        usu.*
                    FROM rh_representante rep
                        INNER JOIN persona per
                            ON per.id_persona = rep.id_persona
                        INNER JOIN usuario usu
                            ON usu.id_persona = per.id_persona
                    WHERE 1 ';
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND rep.id_representante = :idOdontologoC ";
                $arrayParams[':idOdontologoC'] = $idRepresentanteC;
            }
            if (! Util::isVacio($numeroDocumentoC)) {
                $sql .= " AND per.numero_identificacion = :numeroDocumentoC ";
                $arrayParams[':numeroDocumentoC'] = $numeroDocumentoC;
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
                $object->getPersonaDto()->setId_usuario($row['id_usuario']);
                $object->getPersonaDto()->setLoggin($row['loggin']);
                $object->getPersonaDto()->setPassword($row['password']);
                $arrayLlaves[$object->getId_representante()] = $object->getId_representante();
                $result[] = $object;
            }
            // $arrayServices = $this->getListRepresentanteServicios($arrayLlaves);
            $arrayCargos = $this->getCargosRepresentante($arrayLlaves);
            foreach ($result as $lis) {
                $listCargos = Arr::isNullArray($lis->getId_representante(), $arrayCargos) ? [] : $arrayCargos[$lis->getId_representante()];
                $lis->setListCargos($listCargos);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description: consulta los servicios asociados al representante
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {3/11/2015}
     * @param unknown $idRepresentanteC            
     * @param string $idServicioC            
     * @throws \Exception
     * @return Ambigous <multitype:, \app\dtos\RhRepresentanteServicioDto>
     */
    public function getListRepresentanteServicios($idRepresentanteC = [], $idServicioC = NULL)
    {
        try {
            $result = [];
            $arrayParams = [];
            $sql = "SELECT
                        rrs.*,
                        ser.*
                    FROM rh_representante_servicio rrs
                        INNER JOIN servicio ser
                            ON rrs.id_servicio = ser.id_servicio
                    WHERE 1 ";
            if (! Util::isVacio($idServicioC)) {
                $sql .= " AND ser.id_servicio = :idServicioC ";
                $arrayParams[':idServicioC'] = $idServicioC;
            }
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND rrs.id_representante IN (" . Arr::implode($idRepresentanteC) . ") ";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new RhRepresentanteServicioDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getServicioDto(), $row);
                Util::setObjectRow($object->getRepresentanteDto(), $row);
                $result[$object->getId_representante()][$object->getId_servicio()] = $object;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los representantes por cargos
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 9/06/2015
     * @param string $idRepresentanteC            
     * @param integer $idCargoC            
     * @throws \Exception
     * @return multitype:\app\dtos\RhRepresentanteCargoDto
     */
    public function getCargosRepresentante($idRepresentanteC = NULL, $idCargoC = NULL)
    {
        $result = array();
        $arrayParams = array();
        try {
            $sql = "SELECT
                        rhr.id_representante,
                        rhr.id_cargo,
                        rhr.yn_activo
                    FROM rh_representante_cargo rhr 
                    WHERE rhr.yn_activo = " . ESiNo::index(ESiNo::SI)->getId();
            if (! Util::isVacio($idRepresentanteC)) {
                $idRepresentanteC = Arr::isArray($idRepresentanteC) ? $idRepresentanteC : [
                    $idRepresentanteC
                ];
                $sql .= " AND rhr.id_representante IN (" . Arr::implode($idRepresentanteC) . ") ";
            }
            if (! Util::isVacio($idCargoC)) {
                $sql .= " AND rhr.id_cargo = :idCargoC";
                $arrayParams[':idCargoC'] = $idCargoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new RhRepresentanteCargoDto();
                Util::setObjectRow($object, $row);
                $result[$object->getId_representante()][$object->getId_cargo()] = $object;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     * @param RhRepresentanteDto $object            
     */
    public function setDeleteRepresentante($object)
    {
        $return = false;
        if (! Util::isVacio($object->getId_representante())) {
            $listCitas = $this->getCitasRepresententantes($object->getId_representante());
            if (Util::isVacio($listCitas)) {
                $listCitas = $this->getDatosCliente($object->getId_persona());
                if (Util::isVacio($listCitas)) {
                    $return = Util::delete('rh_representante_cargo', $whereC = 'id_representante = ?', [
                        $object->getId_representante()
                    ]);
                    $return = Util::delete('rh_representante_servicio', $whereC = 'id_representante = ?', [
                        $object->getId_representante()
                    ]);
                    $return = Util::delete('rh_representante', $whereC = 'id_representante = ?', [
                        $object->getId_representante()
                    ]);
                }
            }
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description: consulta las citas del representante
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     * @param string $idRepresentanteC            
     * @throws \Exception
     * @return multitype:\app\dtos\ClienteCitaDto
     */
    public function getCitasRepresententantes($idRepresentanteC = NULL)
    {
        try {
            $result = [];
            $arrayParams = [];
            $sql = 'SELECT
                    cita.*
                FROM cliente_cita cita
                WHERE 1 ';
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND cita.id_representante = :idRepresentanteC ";
                $arrayParams[':idRepresentanteC'] = $idRepresentanteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteCitaDto();
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
     * @tutorial Method Description: consulta los datos del cliente
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {13/01/2016}
     * @param string $idRepresentanteC            
     * @throws \Exception
     * @return multitype:\app\dtos\ClienteCitaDto
     */
    public function getDatosCliente($idPersonaC = NULL)
    {
        try {
            $result = [];
            $arrayParams = [];
            $sql = 'SELECT
                    cli.*
                FROM cliente cli
                WHERE 1 ';
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND cli.id_persona = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
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
     * @tutorial Metodo Descripcion: change password
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 26/11/2016
     * @param string $idUsuarioC            
     * @param string $passwordC            
     * @return number
     */
    public function setPasswordRepresentante($idUsuarioC, $passwordC)
    {
        try {
            $arrayDatos = array(
                'password' => $passwordC,
                'yn_ingreso' => ESiNo::index(ESiNo::NO)->getId()
            );
            return Doctrine::update('usuario', $arrayDatos, [
                'id_usuario' => $idUsuarioC
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}