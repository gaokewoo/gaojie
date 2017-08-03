<?php
abstract class Model {
	
	public static function factory($name) {
		$class = 'Model_'.$name;
		return new $class;
	}
	
	private $_properties = array();
	
	public function __construct($data = array()) {
		if($data) {
			$this->_properties = $data;
		}
	}
	
	public function __set($item, $value) {
		if(is_string($item)) {
			$this->_properties[$item] = $value;
		}
		return $this;
	}
	
	public function __get($item) {
		return isset($this->_properties[$item]) ? $this->_properties[$item] : NULL;
	}

	public function getPropertyValue($property, $callback = NULL) {
		$value = $this->__get($property);

		if(function_exists($callback)) {
			// system defined function, such as trim, intval
			return call_user_func_array($callback, array($value));

		} else if(method_exists($this, $callback)) {

				//user defined method
				return call_user_func_array(array($this, $callback), array($value));
		}

		return $value;
	}

	public function getPropertyFromMethod($method) {
		if(substr($method, 0, 3) == 'get') {
			$method = substr($method, 3, strlen($method));
			$property = implode('_', preg_split('#(?=[A-Z])#', lcfirst($method)));
			$property = strtolower($property);
			return $property;
		}

		return FALSE;
	}
	
	public function __call($method, $arguments) {
		$property = $this->getPropertyFromMethod($method);
		if($property) {
			return $this->__get($property);
		}

		return NULL;
	}
	
	public function setArray(array $values = array()) {
		$this->_properties = $values;
		return $this;
	}
	
	public function asArray() {
		return $this->_properties;
	}
}