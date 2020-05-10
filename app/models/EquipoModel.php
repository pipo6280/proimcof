<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\ServicioDto;
use app\dtos\EquipoDto;
use app\dtos\MarcaDto;
use app\dtos\ModeloDto;
use app\enums\EnumGeneric;

/**
 *
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class EquipoModel
{

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function getEquipos($idEquipoC = null, $serialC = null)
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
                        eqp.contador_inicial_copia,
                        eqp.contador_inicial_scanner,   
                        mdl.tipo,
                        mdl.modelo,
                        mdl.estilo,
                        mrc.id_marca,
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
     * @since {18/01/2018}
     * @param string $searchC            
     * @throws Exception
     * @return multitype:\app\dtos\MarcaDto
     */
    public function getListMarcas($searchC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT
                        mrc.*
                     FROM equipo_marca mrc
                     WHERE 1 ";
            if (! Util::isVacio($searchC)) {
                $sql .= " AND mrc.nombre LIKE :searchC ";
                $arrayParams[':searchC'] = "%" . $searchC . "%";
            }
            $sql .= " ORDER BY mrc.id_marca ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new MarcaDto();
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
     * @since {19/01/2018}
     */
    public function getListaModelosEnum()
    {
        $lista = array();
        $listaTemp = $this->getListModelos();
        foreach ($listaTemp as $temp) {
            $lista[] = new EnumGeneric($temp->getId_modelo(), $temp->getModelo()." - ". $temp->getTitleTipo());
        }
        return $lista;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {18/01/2018}
     * @param string $searchC            
     * @throws Exception
     * @return multitype:\app\dtos\MarcaDto
     */
    public function getListModelos($searchC = null, $idModeloC = null)
    {
        try {
            $result = array();
            $arrayParams = array();
            $sql = " SELECT
                        *
                     FROM equipo_modelo mdl
                        INNER JOIN equipo_marca mrc
                        ON mrc.id_marca = mdl.id_marca
                     WHERE 1 ";
            if (! Util::isVacio($searchC)) {
                $sql .= " AND mdl.modelo LIKE :searchC ";
                $arrayParams[':searchC'] = "%" . $searchC . "%";
            }
            if (! Util::isVacio($idModeloC)) {
                $sql .= " AND mdl.id_modelo =:idModeloC ";
                $arrayParams[':idModeloC'] = $idModeloC;
            }
            $sql .= " ORDER BY mdl.id_modelo ";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ModeloDto();
                Util::setObjectRow($object, $row);
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
     * @since {19/01/2018}
     * @param EquipoDto $object
     * @throws Exception
     * @return number
     */
    public function save(EquipoDto $object)
    {
        try {
            $result = false;
            $data['contador_inicial_scanner'] = $object->getContador_inicial_scanner();
            $data['contador_inicial_copia'] = $object->getContador_inicial_copia();
            $data['serial_equipo'] = $object->getSerial_equipo();
            $data['descripcion'] = $object->getDescripcion();
            $data['id_modelo'] = $object->getId_modelo();
            $data['estado'] = $object->getEstado();
            
            if (Util::isVacio($object->getId_equipo())){
                $data['id_usuario_registro'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('equipo', $data);
            } else {
                $data['id_usuario_modifica'] = Util::userSessionDto()->getIdUsuario();
                $data['fecha_modificacion'] = Util::fechaActual(true);
                $result = Doctrine::update('equipo', $data, [
                    'id_equipo' => $object->getId_equipo()
                ]);
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
     * @since {18/01/2018}
     * @param ServicioDto $object            
     * @throws Exception
     * @return Ambigous <boolean, number, unknown>
     */
    public function save_modelo(ModeloDto $object)
    {
        try {
            $result = false;
            
            if (Util::isVacio($object->getMarcaDto()->getId_marca())) {
                $dataTemp['nombre'] = $object->getMarcaDto()->getNombre();
                $result = Doctrine::insert('equipo_marca', $dataTemp);
                $idMarca = $result;
                $object->getMarcaDto()->setId_marca($idMarca);
            }
            
            $data['id_marca'] = $object->getMarcaDto()->getId_marca();
            $data['descripcion'] = $object->getDescripcion();
            $data['modelo'] = $object->getModelo();
            $data['estilo'] = $object->getEstilo();
            $data['tipo'] = $object->getTipo();
            
            if (Util::isVacio($object->getId_modelo())) {
                $data['fecha_registro'] = Util::fechaActual(true);
                $result = Doctrine::insert('equipo_modelo', $data);
            } else {
                $result = Doctrine::update('equipo_modelo', $data, [
                    'id_modelo' => $object->getId_modelo()
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $result;
    }
}