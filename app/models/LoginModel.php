<?php
namespace app\models;

use system\Session\Session;
use system\Core\Doctrine;
use system\Support\Util;
use app\dtos\UsuarioDto;
use app\dtos\SessionDto;
use app\enums\ESiNo;
use system\Support\Arr;
use app\dtos\UsuarioPerfilDto;
use app\dtos\UsuarioPerfilAsignadoDto;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 17, 2016
 */
class LoginModel
{

    /**
     *
     * @tutorial Metodo Descripcion: verifica si el usuario existe para el logueo
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 26/03/2015
     * @param string $logginC            
     * @param string $claveC            
     * @throws \Exception
     * @return boolean|multitype:
     */
    public function setLogin($logginC = NULL, $claveC = NULL)
    {
        try {
            $result = lang('login.incorrect_user');
            $sql = "SELECT per.*, usu.* FROM persona per INNER JOIN usuario usu ON usu.id_persona = per.id_persona WHERE usu.loggin LIKE :logginC";
            $arrayParams[':logginC'] = $logginC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $usuarioDto = new UsuarioDto();
                Util::setObjectRow($usuarioDto, $row);
                Util::setObjectRow($usuarioDto->getPersonaDto(), $row);
                if (! Util::isVacio($usuarioDto->getPersonaDto()->getId_persona())) {
                    $password = $usuarioDto->getYn_ingreso() == ESiNo::index(ESiNo::NO)->getId() ? $claveC : Util::sha1($claveC);
                    if ($usuarioDto->getYn_activo() == ESiNo::index(ESiNo::NO)->getId()) {
                        $result = lang('login.expired_user');
                    } else 
                        if ($usuarioDto->getPassword() == $password) {
                            $changePassword = FALSE;
                            if ($usuarioDto->getYn_ingreso() == ESiNo::index(ESiNo::NO)->getId()) {
                                $changePassword = Doctrine::update('usuario', array(
                                    'password' => Util::sha1($claveC),
                                    'yn_ingreso' => ESiNo::index(ESiNo::SI)->getId()
                                ), array(
                                    'id_usuario' => $usuarioDto->getId_usuario()
                                ), FALSE);
                            }
                            $listPerfilesAsignados = $this->getListUsuarioPerfilesAsignados($usuarioDto->getId_usuario());
                            $arrayLLaves = array();
                            foreach ($listPerfilesAsignados as $lis) {
                                $arrayLLaves[] = $lis->getId_perfil();
                            }
                            $listPerfiles = $this->getListUsuarioPerfil($arrayLLaves, NULL, ESiNo::index(ESiNo::SI)->getId());
                            $sessionDto = new SessionDto();
                            $sessionDto->setIdUsuario($usuarioDto->getId_usuario());
                            $sessionDto->setLoggin($logginC);
                            $sessionDto->setChangePassword($changePassword);
                            $sessionDto->setPassword(Util::sha1($claveC));
                            $sessionDto->setAccess(TRUE);
                            $sessionDto->setPrimerNombre($usuarioDto->getPersonaDto()
                                ->getPrimer_nombre());
                            $sessionDto->setSegundoNombre($usuarioDto->getPersonaDto()
                                ->getSegundo_nombre());
                            $sessionDto->setPrimerApellido($usuarioDto->getPersonaDto()
                                ->getPrimer_apellido());
                            $sessionDto->setSegundoApellido($usuarioDto->getPersonaDto()
                                ->getSegundo_apellido());
                            $sessionDto->setPhotoProfile($usuarioDto->getPersonaDto()
                                ->getFoto_perfil());
                            $sessionDto->setPersonaDto($usuarioDto->getPersonaDto());
                            $sessionDto->setListProfiles($listPerfiles);
                            Session::setRemoveData("INTENTOS{$logginC}");
                            Util::setUserSessionDto($sessionDto);
                            return ($changePassword ? ESiNo::index(ESiNo::SI)->getId() : ESiNo::index(ESiNo::NO)->getId());
                        } else {
                            $INTENTOS = Session::getData('INTENTOS' . $logginC);
                            if (! $INTENTOS) {
                                $INTENTOS = 0;
                            }
                            $INTENTOS ++;
                            if ($INTENTOS <= lang('login.max_allowed')) {
                                $result = lang('login.incorrect_user');
                            } else {
                                $array = array();
                                $arrayDatos['yn_activo'] = ESiNo::index(ESiNo::NO)->getId();
                                Doctrine::update('usuario', array(
                                    'password' => Util::sha1($claveC),
                                    'yn_ingreso' => ESiNo::index(ESiNo::NO)->getId()
                                ), array(
                                    'id_usuario' => $logginC
                                ), FALSE);
                                $result = lang('login.blocked_blocked', array(
                                    lang('login.max_allowed')
                                ));
                                $INTENTOS = 0;
                            }
                            Session::setData("INTENTOS{$logginC}", $INTENTOS);
                        }
                } else {
                    $result = lang('login.incorrect_user');
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los perfiles asignados
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param string $idUsuarioC            
     * @throws Exception
     * @return multitype:\app\dtos\UsuarioPerfilAsignadoDto
     */
    private function getListUsuarioPerfilesAsignados($idUsuarioC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT id_usuario, id_perfil FROM usuario_perfil_asignado WHERE 1";
            if (! Util::isVacio($idUsuarioC)) {
                $sql .= " AND id_usuario = :idUsuarioC";
                $arrayParams[':idUsuarioC'] = $idUsuarioC;
            }
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
     * @tutorial Metodo Descripcion: consulta los perfiles
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 3/12/2016
     * @param string $idPerfilB            
     * @param string $nombreB            
     * @param string $ynEstadoB            
     * @throws \Exception
     * @return multitype:\app\models\UsuarioPerfilDto
     */
    private function getListUsuarioPerfil($idPerfilB = array(), $nombreB = NULL, $ynEstadoB = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT id_perfil, nombre, yn_activo FROM usuario_perfil WHERE 1 ";
            if (! Util::isVacio($idPerfilB)) {
                $sql .= " AND id_perfil IN (" . Arr::implode($idPerfilB) . ") ";
            }
            if (! Util::isVacio($nombreB)) {
                $sql .= ' AND nombre LIKE :nombreB';
                $arrayParams[':nombreB'] = "%" . $nombreB . "%";
            }
            if (! Util::isVacio($ynEstadoB)) {
                $sql .= " AND yn_activo = :ynEstadoB ";
                $arrayParams[':ynEstadoB'] = $ynEstadoB;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new UsuarioPerfilDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
            unset($list);
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description: consulta los datos del usuario
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {10/01/2016}
     * @param string $idPersonaC            
     * @param string $emailC            
     * @throws \Exception
     * @return multitype:\app\dtos\PersonaDto
     */
    public function getPersonaDatos($idPersonaC = NULL, $emailC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT usu.*, per.* FROM usuario usu INNER JOIN persona per ON usu.id_persona = per.id_persona WHERE 1 ";
            if (! Util::isVacio($idPersonaC)) {
                $sql .= " AND usu.id_usuario = :idPersonaC ";
                $arrayParams[':idPersonaC'] = $idPersonaC;
            }
            if (! Util::isVacio($emailC)) {
                $sql .= " AND (per.email = :emailC OR usu.loggin = :emailC)";
                $arrayParams[':emailC'] = $emailC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $objeto = new UsuarioDto();
                Util::setObjectRow($objeto, $row);
                Util::setObjectRow($objeto->getPersonaDto(), $row);
                $result[] = $objeto;
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
        if (Util::isVacio($idUsuarioC)) {
            return false;
        }
        $result = Doctrine::update('usuario', [
            'password' => $passwordC,
            'yn_ingreso' => ESiNo::index(ESiNo::SI)->getId(),
            'fecha_modificacion' => Util::fechaActual(true)
        ], [
            'id_usuario' => $idUsuarioC
        ]);
        if ($result) {
            $sessionDto = Util::userSessionDto();
            $sessionDto->setPassword($passwordC);
            Util::setUserSessionDto($sessionDto);
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {oct 17, 2016}
     * @param integer $idUsuarioC            
     * @param string $passwordC            
     * @return boolean|number
     */
    public function setPasswordEmail($idUsuarioC, $passwordC)
    {
        try {
            if (Util::isVacio($idUsuarioC)) {
                return false;
            }
            $result = Doctrine::update('usuario', [
                'password' => $passwordC,
                'yn_ingreso' => ESiNo::index(ESiNo::NO)->getId(),
                'fecha_modificacion' => Util::fechaActual(true)
            ], [
                'id_usuario' => $idUsuarioC
            ], FALSE);
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {25/02/2017}
     * @param unknown $logginC
     */
    public function getUsuariologin($logginC) {
        $result = null;
        try {
            $sql = "SELECT per.*, usu.* FROM persona per INNER JOIN usuario usu ON usu.id_persona = per.id_persona WHERE usu.loggin LIKE :logginC";
            $arrayParams[':logginC'] = $logginC;
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $result = $row['id_usuario'];
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
}