<?php
abstract class Business {
	
	static public function factory($name) {
		$class = 'Business_'.$name;
		
		return new $class;
	}
} 
