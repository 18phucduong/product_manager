<?php
namespace app\core;

class Database {

	protected $host_name = '';
	protected $username = '';
	protected $pass = '';
	protected $db_name = '';

	protected $connect;


	public function __construct() {

		$this->host_name = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->db_name = 'manager_product';
	}

	public function connect() {
		if (!$this->connect){
			$this->connect =  new \mysqli( $this->host_name, $this->username, $this->password, $this->db_name );
			if ($this->connect->connect_errno) {
				return "Failed to connect to MySQL:" . $this->connect->connect_error ;
			} 
		}	
	}

	public function dis_connect() {
		$this->connect->close();
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

  
}