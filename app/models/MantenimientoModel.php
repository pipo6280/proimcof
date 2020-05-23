<?php
namespace app\models;

use system\Support\Util;
use system\Core\Doctrine;
use app\dtos\GastoDto;
use app\dtos\ServicioDto;
/**
 * 
 * @tutorial Working Class
 * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
 * @since {14/02/2017}
 */
class MantenimientoModel
{
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {14/02/2017}
     */
    public function getServicios($idServicioC = null) {
        try {
            $result = array();
            $arrayParams = array();
            $sql = "SELECT srv.* FROM servicio srv WHERE 1 ";
            if (! Util::isVacio($idServicioC)) {
                $sql .= " AND srv.id_servicio = :idServicio ";
                $arrayParams[':idServicio'] = $idServicioC;
            }
            $sql .= " ORDER BY srv.id_servicio DESC";
            $statement = Doctrine::prepare($sql);
            $statement->execute($arrayParams);
            $list = $statement->fetchAll();
            foreach ($list as $row) {
                $object = new ServicioDto();
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
     * @since {17/01/2018}
     * @param ServicioDto $object
     * @throws Exception
     * @return Ambigous <boolean, number, unknown>
     */
    public function save(ServicioDto $object)
    {
        try {
            $result = false;
            $data['descripcion'] = $object->getDescripcion();
            $data['fecha_registro'] = Util::fechaActual(true);
            $data['yn_activo'] = $object->getYn_activo();
            if (Util::isVacio($object->getId_servicio())) {
                $result = Doctrine::insert('servicio', $data);
            } else {
                $result = Doctrine::update('servicio', $data, [
                    'id_servicio' => $object->getId_servicio()
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
     * @since {17/01/2018}
     * @param unknown $idServicioC
     * @return Ambigous <boolean, number, unknown>
     */
    public function setDeleteServicio($idServicioC)
    {
        $return = false; //
        if (! Util::isVacio($idServicioC)) {
            $return = Doctrine::delete('servicio', [
                'id_servicio' => $idServicioC
            ]);
        }
        return $return;
    }
    

}