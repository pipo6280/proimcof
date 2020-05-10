<?php
namespace system\Support;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 26/11/2016
 */
interface Jsonable
{

    /**
     *
     * @tutorial Metodo Descripcion: Convert the object to its JSON representation.
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 26/11/2016
     * @param number $options            
     */
    public function toJson($options = 0);
}
