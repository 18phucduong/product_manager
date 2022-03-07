<?php
namespace app\core;

class Database {

	private $_host_name = 'localhost';
	private $_username = 'root';
	private $_pass = '';
	private $_db_name = 'manager_product';

	private $_connect;
	private static $_instance;

	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		$this->connect(); 
	}

	public function connect() {
		if (!$this->connect){
			$this->_connect =  new \mysqli( $this->host_name, $this->username, $this->password, $this->db_name );
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
		if ($result->num_rows > 0) {
		  return $result;
		} else {
            return "Error: " . $sql . "<br>" . $this->connect->error;
		}
        
	}
	public function getConnection() {
		return $this->_connection;
	}

  
}