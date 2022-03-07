<?php
namespace app\core;

use app\core\Store;

class Database {

	private $_host_name = '';
	private $_username = '';
	private $_password = '';
	private $_db_name = '';

	private $_connect;
	private static $_instance;

	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		$store = Store::store();
		$db_config = $store;

		$this->_host_name = $db_config['host_name'];
		$this->_username = $db_config['username'];
		$this->_password = $db_config['password'];
		$this->_db_name = $db_config['db_name'];

		$this->connect(); 
	}

	public function connect() {
		if (!$this->connect){
			$this->_connect =  new \mysqli( $this->_host_name, $this->_username, $this->_password, $this->_db_name );
			if ($this->_connect->connect_errno) {
				trigger_error("Failed to conencto to MySQL: " . $this->connect->connect_error, E_USER_ERROR);
			} 
		}	
	}

	public function disConnect() {
		$this->_connect->close();
	}

	public function query($sql) {
		$this->connect();
		$result = $this->connect->query($sql);
		
		return $result->num_rows > 0 ? $result : ("Error: " . $sql . "<br>" . $this->connect->error);
	}
	public function getConnection() {
		return $this->_connect;
	}
}