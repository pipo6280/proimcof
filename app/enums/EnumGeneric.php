<?php
	namespace app\enums;
	/**
	 * @tutorial Clase de trabajo
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 29/03/2015
	 */
class EnumGeneric extends AEnum {
	/**
	 * 
	 * @tutorial 
	 * @author Rodolfo Perez ~ pipo6280@gmail.com
	 * @since {20/09/2015}
	 * @return multitype:number string
	 */
	public function getAjaxJson() {
		return array('id' => $this->id, 'descripcion' => utf8_encode($this->descripcion));
	}
}