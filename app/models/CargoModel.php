<?php
namespace app\models;

use app\dtos\RhRepresentanteCargoDto;
use app\enums\EnumGeneric;
use system\Support\Util;
use app\dtos\RhCargoDto;
use system\Support\Arr;
use app\enums\ESiNo;
use system\Core\Doctrine;

class CargoModel
{

    /**
     *
     * @tutorial Metodo Descripcion: consulta los cargos disponibles
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     * @param string $idCargoC            
     * @param string $nombreC            
     * @param string $idCategoriaCargoC            
     * @throws Exception
     * @return multitype:\app\dtos\RhCargoDto
     */
    public function getCargos($idCargoC = NULL, $nombreC = NULL, $idCategoriaCargoC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT rhc.* FROM  rh_cargo rhc WHERE 1 ";
            if (! Util::isVacio($idCargoC)) {
                $sql .= " AND rhc.id_cargo = :idCargoC ";
                $arrayParams[':idCargoC'] = $idCargoC;
            }
            if (! Util::isVacio($nombreC)) {
                $sql .= " AND rhc.nombre LIKE :nombreC ";
                $arrayParams[':nombreC'] = "%" . $nombreC . "%";
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new RhCargoDto();
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
     * @tutorial Metodo Descripcion: cambia el estado del cargo
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     * @param RhCargoDto $object            
     * @throws Exception
     * @return number
     */
    public function setChangeState($object)
    {
        try {
            $data['yn_activo'] = ($object->getYn_activo() == ESiNo::index(ESiNo::SI)->getId() ? ESiNo::index(ESiNo::NO)->getId() : ESiNo::index(ESiNo::SI)->getId());
            return Doctrine::update('rh_cargo', $data, [
                'id_cargo' => $object->getId_cargo()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial guarda los datos para el cargo
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/10/2015}
     * @param RhCargoDto $object            
     * @return boolean
     */
    public function setGuardarCargo($object)
    {
        try {
            $result = FALSE;
            $data['nombre'] = $object->getNombre();
            $data['yn_activo'] = $object->getYn_activo();
            if (Util::isVacio($object->getId_cargo())) {
                $result = Doctrine::insert('rh_cargo', $data);
            } else {
                $result = Doctrine::update('rh_cargo', $data, [
                    'id_cargo' => $object->getId_cargo()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result ? $object->getNombre() : $result;
    }

    /**
     *
     * @tutorial elimina la categoria
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/10/2015}
     * @param integer $idCategoriaC            
     * @return boolean
     */
    public function setEliminarCategoria($idCategoriaC)
    {
        $listaCargos = $this->getCargos(NULL, NULL, $idCategoriaC);
        $return = false; // No se puede eliminar porque existen dependencias asociadas
        if (Util::isVacio($listaCargos)) {
            $return = Util::delete('rh_categoria_cargo', $whereC = 'id_categoria = ?', [
                $idCategoriaC
            ]);
        }
        return $return;
    }

    /**
     *
     * @tutorial elimina el cargo
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {12/10/2015}
     * @param integer $idCategoriaC            
     * @return boolean
     */
    public function setDeleteCargo($idCargoC)
    {
        $return = false; // No se puede eliminar porque existen dependencias asociadas
        $listRepresentantes = $this->getListCargosRerpesentantes($idCargoC);
        if (Util::isVacio($listRepresentantes)) {
            $return = Doctrine::delete('rh_cargo', [
                'id_cargo' => $idCargoC
            ]);
        }
        return $return;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta y obtiene en un enumerado los cargos
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 9/06/2015
     * @return multitype:\app\enums\EnumeradoGenerico
     */
    public function getCargosEnumerado()
    {
        $result = array();
        $listaCargos = $this->getCargos();
        foreach ($listaCargos as $lis) {
            $result[] = new EnumGeneric($lis->getId_cargo(), $lis->getNombre());
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
    public function getCargosRepresentanteAsociados($idRepresentanteC = NULL, $idCargoC = NULL)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                        rhr.id_representante,
                        rhr.id_cargo,
                        rhr.yn_activo,
                        rhc.id_cargo AS idCargo,
                        rhc.nombre AS nombreCargo
                    FROM rh_representante_cargo rhr
                        RIGHT JOIN rh_cargo rhc
                            ON rhr.id_cargo = rhc.id_cargo";
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND rhr.id_representante = :idRepresentanteC ";
                $arrayParams[':idRepresentanteC'] = $idRepresentanteC;
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
                $object->getCargoDto()->setId_cargo($row['idCargo']);
                $object->getCargoDto()->setNombre($row['nombreCargo']);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Metodo Descripcion: consulta los datos de un representante y su respectivo cargo
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since 9/06/2015
     * @param string $idCargoC            
     * @param string $idRepresentanteC            
     * @throws \Exception
     * @return multitype:\app\dtos\RhRepresentanteCargoDto
     */
    public function getListCargosRerpesentantes($idCargoC = NULL, $idRepresentanteC = NULL)
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
                        rhr.id_representante,
                        rep.id_cargo,
                        rep.yn_activo,
                        rhc.nombre
                    FROM persona per 
                        INNER JOIN rh_representante rhr ON rhr.id_persona = per.id_persona
                        INNER JOIN rh_representante_cargo rep ON rep.id_representante = rhr.id_representante 
                        INNER JOIN rh_cargo rhc ON rhc.id_cargo = rep.id_cargo ";
            if (! Util::isVacio($idCargoC)) {
                $sql .= " AND rep.id_cargo = :idCargoC ";
                $arrayParams[':idCargoC'] = $idCargoC;
            }
            if (! Util::isVacio($idRepresentanteC)) {
                $sql .= " AND rhr.id_representante = :idRepresentanteC ";
                $arrayParams[':idRepresentanteC'] = $idRepresentanteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new RhRepresentanteCargoDto();
                Util::setObjectRow($object, $row);
                Util::setObjectRow($object->getRepresentanteDto(), $row);
                Util::setObjectRow($object->getRepresentanteDto()->getPersonaDto(), $row);
                Util::setObjectRow($object->getCargoDto(), $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     *
     * @tutorial Method Description: guarda la asociacion entre cargo y representante
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {4/11/2015}
     * @param integer $idRepresentanteC            
     * @param integer $listaCargos            
     * @param integer $listaActivos            
     * @return Ambigous <boolean, \system\Database\unknown, string>
     */
    public function setSaveAsociar($idRepresentanteC, $listaCargos, $listaActivos)
    {
        try {
            $result = Doctrine::delete('rh_representante_cargo', [
                'id_representante' => $idRepresentanteC
            ]);
            if (! Util::isVacio($listaCargos) && $result) {
                foreach ($listaCargos as $lis) {
                    $data = array();
                    $data['id_cargo'] = $lis;
                    $data['id_representante'] = $idRepresentanteC;
                    $data['yn_activo'] = Arr::isNullArray($lis, $listaActivos) ? ESiNo::index(ESiNo::NO)->getId() : $listaActivos[$lis];
                    $result = Doctrine::insert('rh_representante_cargo', $data);
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}