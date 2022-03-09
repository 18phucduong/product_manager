<?php
namespace app\core;

class Store {
	public static $instance;
	private $store;


	public static function store() {
		if( !isset( self::$instance ) )
			self::$instance = new self;
		return self::$instance;
	}
	public function __set($name, $value) {
		if( !isset( $this->store[$name] ) ) 
			$this->store[$name] = $value;
		else 
			die( "Can't set {$value} to {$name}" );	
	}
	public function __get($name) {
		return isset( $this->store[$name] ) ? $this->store[$name] : null;
	}
	public function resetValue($valueName, $value) {
		$this->store[$valueName] = $value;
	}
    

}