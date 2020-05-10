<?php
namespace app\models;

use app\dtos\SubPaqueteDto;
use app\enums\EnumGeneric;
use system\Core\Doctrine;
use system\Support\Util;
use app\dtos\PaqueteDto;
use system\Support\Arr;
use app\enums\ESiNo;
use app\dtos\ClienteSubPaqueteDto;
use app\dtos\HorarioPaqueteDto;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {3/12/2016}
 */
class PaqueteModel
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     * @return array
     */
    public function getPaquetesEnums()
    {
        $return = array();
        $list = $this->getPaquetes();
        foreach ($list as $l) {
            $return[] = new EnumGeneric($l->getId_paquete(), $l->getNombre());
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/11/2016}
     * @throws Exception
     * @return PaqueteDto
     */
    public function getPaquetes($idPaqueteC = null, $exectoC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT 
                       pqp.*,
                       hpq.*,
                       pqt.*
                    FROM paquete pqt 
                    LEFT JOIN paquete_permiso pqp
                     ON pqt.id_paquete = pqp.id_paquete_principal
                    LEFT JOIN paquete_horario hpq
                     ON hpq.id_paquete = pqt.id_paquete
                    WHERE 1 ";
            if (! Util::isVacio($idPaqueteC)) {
                $sql .= " AND pqt.id_paquete = :paqueteC ";
                $arrayParams[':paqueteC'] = $idPaqueteC;
            }
            if (! Util::isVacio($exectoC)) {
                $sql .= " AND pqt.id_paquete NOT IN (:exectoC)";
                $arrayParams[':exectoC'] = $exectoC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                if (Arr::isNullArray($row['id_paquete'], $result)) {
                    $object = new PaqueteDto();
                    Util::setObjectRow($object, $row);
                    $list = array();
                    $listHorario = array();
                } else {
                    $object = $result[$row['id_paquete']];
                    $list = $object->getList_paquetes();
                    $listHorario = $object->getList_horario();
                }
                $list[$row['id_paquete_secundario']] = $row['id_paquete_secundario'];
                $object->setList_paquetes($list);
                $horarioDto = new HorarioPaqueteDto();
                Util::setObjectRow($horarioDto, $row);
                $listHorario[$horarioDto->getId_horario_paquete()] = $horarioDto;
                $object->setList_horario($listHorario);
                
                $result[$object->getId_paquete()] = $object;
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
     * @since {01/12/2016}
     * @param string $idClaseC            
     * @throws Exception
     * @return multitype:\app\dtos\PaqueteDto
     */
    public function getSubPaquetes($idSubPaqueteC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                       spq.*,
                       pqp.id_paquete,
                       pqp.nombre as nombre_paquete
                    FROM sub_paquete spq
                    INNER JOIN paquete pqp
                     ON pqp.id_paquete = spq.id_paquete
                    WHERE 1 ";
            if (! Util::isVacio($idSubPaqueteC)) {
                $sql .= " AND spq.id_sub_paquete = :subpaqueteC ";
                $arrayParams[':subpaqueteC'] = $idSubPaqueteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new SubPaqueteDto();
                Util::setObjectRow($object, $row);
                $object->getPaqueteDto()->setId_paquete($row['id_paquete']);
                $object->getPaqueteDto()->setNombre($row['nombre_paquete']);
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
     * @since {29/11/2016}
     * @param unknown $idCargoC            
     * @return Ambigous <boolean, unknown, number>
     */
    public function setDeletePaquete($idPaqueteC)
    {
        $return = false; // No se puede eliminar porque existen dependencias asociadas
        $listSubpaquetes = $this->getListSubPaquetes(null, $idPaqueteC);
        if (Util::isVacio($listSubpaquetes)) {
            $return = Doctrine::delete('paquete_permiso', [
                'id_paquete_principal' => $idPaqueteC
            ]);
            $return = Doctrine::delete('paquete_permiso', [
                'id_paquete_secundario' => $idPaqueteC
            ]);
            $return = Doctrine::delete('paquete', [
                'id_paquete' => $idPaqueteC
            ]);
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {29/11/2016}
     * @param string $idCargoC            
     * @param string $idRepresentanteC            
     * @throws Exception
     * @return multitype:\app\dtos\RhRepresentanteCargoDto
     */
    public function getListSubPaquetes($idSubPaqueteC = NULL, $idPaqueteC = NULL)
    {
        $result = false;
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                         spq.*
                    FROM sub_paquete spq WHERE 1 ";
            if (! Util::isVacio($idSubPaqueteC)) {
                $sql .= " AND spq.id_paquete = :paqueteC ";
                $arrayParams[':paqueteC'] = $idSubPaqueteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new SubPaqueteDto();
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
     * @since {01/12/2016}
     * @param PaqueteDto $paqueteDto            
     */
    public function savePaquete(PaqueteDto $object)
    {
        try {
            $result = FALSE;
            $data['nombre'] = $object->getNombre();
            $data['clases_concurrentes'] = $object->getClases_concurrentes();
            $data['cupo'] = $object->getCupo();
            $data['yn_grupal'] = $object->getYn_grupal();
            if (Util::isVacio($object->getId_paquete())) {
                $result = Doctrine::insert('paquete', $data);
                $object->setId_paquete($result);
            } else {
                $result = Doctrine::update('paquete', $data, [
                    'id_paquete' => $object->getId_paquete()
                ]);
            }
            $return = Doctrine::delete('paquete_permiso', [
                'id_paquete_principal' => $object->getId_paquete()
            ]);
            foreach ($object->getList_paquetes() as $lis) {
                $dataP['id_paquete_principal'] = $object->getId_paquete();
                $dataP['id_paquete_secundario'] = $lis;
                $result = Doctrine::insert('paquete_permiso', $dataP);
            }
            
            $return = Doctrine::delete('paquete_horario', [
                'id_paquete' => $object->getId_paquete()
            ]);
            
            foreach ($object->getList_horario() as $lis) {
                $dataH['id_paquete'] = $object->getId_paquete();
                $dataH['hora_inicio'] = $lis->getHora_inicio();
                $dataH['hora_fin'] = $lis->getHora_fin();
                $result = Doctrine::insert('paquete_horario', $dataH);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result ? $object->getNombre() : $result;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     * @param unknown $object            
     * @throws Exception
     * @return Ambigous <boolean, \system\Core\unknown, number>
     */
    public function setChangeState($idSubPaqueteC, $estadoC)
    {
        try {
            $data['yn_activo'] = ($estadoC == ESiNo::index(ESiNo::SI)->getId() ? ESiNo::index(ESiNo::NO)->getId() : ESiNo::index(ESiNo::SI)->getId());
            return Doctrine::update('sub_paquete', $data, [
                'id_sub_paquete' => $idSubPaqueteC
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     * @param unknown $idPaqueteC            
     * @return Ambigous <boolean, unknown, number>
     */
    public function setDeleteSubPaquete($idSubPaqueteC)
    {
        $return = false; // No se puede eliminar porque existen dependencias asociadas
        $listSubpaquetes = $this->getlistClienteSubPaquete($idSubPaqueteC);
        if (Util::isVacio($listSubpaquetes)) {
            $return = Doctrine::delete('sub_paquete', [
                'id_sub_paquete' => $idSubPaqueteC
            ]);
        }
        return $return;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     */
    public function getlistClienteSubPaquete($idSubPaqueteC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT
                         csp.*
                    FROM cliente_sub_paquete csp WHERE 1 ";
            if (! Util::isVacio($idSubPaqueteC)) {
                $sql .= " AND csp.id_sub_paquete = :paqueteC ";
                $arrayParams[':paqueteC'] = $idSubPaqueteC;
            }
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ClienteSubPaqueteDto();
                Util::setObjectRow($object, $row);
                $result[] = $object;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {3/12/2016}
     * @param SubPaqueteDto $object            
     * @throws Exception
     * @return Ambigous <string, boolean, number, unknown>
     */
    public function saveSubPaquete(SubPaqueteDto $object)
    {
        try {
            $result = FALSE;
            $data['nombre'] = $object->getNombre();
            $data['id_paquete'] = $object->getId_paquete();
            $data['precio'] = $object->getPrecio();
            $data['numero_sesiones'] = $object->getNumero_sesiones();
            $data['numero_excusas'] = $object->getNumero_excusas();
            $data['duracion'] = $object->getDuracion();
            if (Util::isVacio($object->getId_sub_paquete())) {
                $result = Doctrine::insert('sub_paquete', $data);
            } else {
                $result = Doctrine::update('sub_paquete', $data, [
                    'id_sub_paquete' => $object->getId_sub_paquete()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
}