<?php
	namespace system\Session;
	use system\Core\Singleton;
    
    /**
	 * 
	 * @tutorial Clase de trabajo
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 */
class Session extends Singleton {
	
	const FLAS_KEY = 'flash';
	
	protected static function initialize() {
		self::_sess_run();
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion: regenerates session id
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 */
	public static function regenerate_id() {
		// copy old session data, including its id
		$old_session_id 			= session_id();
		$old_session_data 			= $_SESSION;
		
		// regenerate session id and store it
		session_regenerate_id();
		$new_session_id 			= session_id();
		
		// switch to the old session and destroy its storage
		session_id($old_session_id);
		session_destroy();
		
		// switch back to the new session id and send the cookie
		session_id($new_session_id);
		session_start();
		
		//restore the old session data into the new session
		$_SESSION 					= $old_session_data;
		// update the session creation time
		$_SESSION['regenerated'] 	= time();
		
		// session_write_close() patch based on this thread
		// http://www.codeigniter.com/forums/viewthread/1624/
		// there is a question mark ?? as to side affects
		// end the current session and store session data.
		session_write_close();
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion: destroys the session and erases session storage
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 */
	public static function destroy() {
		unset($_SESSION);
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 42000, '/');
		}
		session_destroy();
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion:
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 * @param string $item
	 * @return string|Ambigous <boolean, unknown>
	 */
	public static function getData($item) {
		if($item == 'session_id') {
			return session_id();
		} else {
			return (!isset($_SESSION[$item])) ? false : $_SESSION[$item];
		}
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion: Sets session attributes to the given values
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 * 
	 * @param array $newdata
	 * @param string $newval
	 */
	public static function setData($newdata = array(), $newval = '') {
		if(is_string($newdata)) {
			$newdata = array(
				$newdata=>$newval
			);
		}
		
		if(count($newdata) > 0) {
			foreach($newdata as $key => $val) {
				$_SESSION[$key] = $val;
			}
		}
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion: Erases given session attributes
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 * @param array $newdata
	 */
	public static function setRemoveData($newdata = array()) {
		if(is_string($newdata)) {
			$newdata = array(
				$newdata=>''
			);
		}
		
		if(count($newdata) > 0) {
			foreach($newdata as $key => $val) {
				$_SESSION[$key] = NULL;
				unset($_SESSION[$key]);
			}
		}
	}

	/**
	 * 
	 * @tutorial Metodo Descripcion: Starts up the session system for current request
	 * @author Rodolfo Perez || pipo6280@gmail.com
	 * @since 5/04/2015
	 */
	public static function _sess_run() {
		session_start();
		
		$session_id_ttl = config_item('csrf_expire');
		
		if(is_numeric($session_id_ttl)) {
			if($session_id_ttl < 1) {
				$session_id_ttl = (60 * 60 * 24 * 365 * 2);
			}
		}
		
		// check if session id needs regeneration
		if(self::_session_id_expired($session_id_ttl)) {
			// regenerate session id (session data stays the
			// same, but old session storage is destroyed)
			self::regenerate_id();
		}
		
		// delete old flashdata (from last request)
		self::_flashdata_sweep();
		
		// mark all new flashdata as old (data will be deleted before next
		// request)
		self::_flashdata_mark();
	}

	/**
	 * Checks if session has expired
	 */
	public static function _session_id_expired($session_id_ttl) {
		if(!isset($_SESSION['regenerated'])) {
			$_SESSION['regenerated'] = time();
			return false;
		}
		
		$expiry_time = time() - $session_id_ttl;
		
		if($_SESSION['regenerated'] <= $expiry_time) {
			return true;
		}
		
		return false;
	}

	/**
	 * Sets "flash" data which will be available only in next request (then it
	 * will be deleted from session). You can use it to implement "Save
	 * succeeded" messages after redirect.
	 */
	public static function set_flashdata($key, $value) {
		$flash_key = self::FLAS_KEY . ':new:' . $key;
		self::setData($flash_key, $value);
	}

	/**
	 * Keeps existing "flash" data available to next request.
	 */
	public static function keep_flashdata($key) {
		$old_flash_key = self::FLAS_KEY . ':old:' . $key;
		$value = self::getData($old_flash_key);
		
		$new_flash_key = self::FLAS_KEY . ':new:' . $key;
		self::setData($new_flash_key, $value);
	}

	/**
	 * Returns "flash" data for the given key.
	 */
	public static function flashdata($key) {
		$flash_key = self::FLAS_KEY . ':old:' . $key;
		return self::getData($flash_key);
	}

	/**
	 * PRIVATE: Internal method - marks "flash" session attributes as 'old'
	 */
	public static function _flashdata_mark() {
		foreach($_SESSION as $name => $value) {
			$parts = explode(':new:', $name);
			if(is_array($parts) && count($parts) == 2) {
				$new_name = self::FLAS_KEY . ':old:' . $parts[1];
				self::setData($new_name, $value);
				self::setRemoveData($name);
			}
		}
	}

	/**
	 * PRIVATE: Internal method - removes "flash" session marked as 'old'
	 */
	public static function _flashdata_sweep() {
		foreach($_SESSION as $name => $value) {
			$parts = explode(':old:', $name);
			if(is_array($parts) && count($parts) == 2 && $parts[0] == self::FLAS_KEY) {
				self::setRemoveData($name);
			}
		}
	}
	
	public static function getKeys() {
		return array_keys($_SESSION);
	}
}