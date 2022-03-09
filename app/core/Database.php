<?php
namespace app\core;

// use app\core\Store;

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

		$db_configs = getConfig('db_configs');

		$this->_host_name = $db_configs['host_name'];
		$this->_username = $db_configs['username'];
		$this->_password = $db_configs['password'];
		$this->_db_name = $db_configs['db_name'];

		$this->connect(); 
	}

	public function connect() {

		$this->_connect =  new \mysqli( $this->_host_name, $this->_username, $this->_password, $this->_db_name );
		if ($this->_connect->connect_errno) {
			trigger_error("Failed to conenct to MySQL: " . $this->connect->connect_error, E_USER_ERROR);
		} 
	
	}

	public function disConnect() {
		$this->_connect->close();
	}

	public function query($sql) {
		$this->connect();
		$result = $this->_connect->query($sql);
		
		return $result->num_rows > 0 ? $result : ("Error: " . $sql . "<br>" . $this->connect->error);
	}
	public function getConnection() {
		$this->connect();
		return $this->_connect;
	}
}