<?php
namespace app\core;
class Database {

	private $_host_name = '';
	private $_username = '';
	private $_password = '';
	private $_db_name = '';

	private $_connect;
	private static $_instance;

	public function __construct() {
		$db_configs = getConfig('db_configs');

		$this->_host_name = $db_configs['host_name'];
		$this->_username = $db_configs['username'];
		$this->_password = $db_configs['password'];
		$this->_db_name = $db_configs['db_name'];
		$this->connect(); 
	}
	
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	use QueryBuilder;

	public function connect() {

		$this->_connect =  new \mysqli( $this->_host_name, $this->_username, $this->_password, $this->_db_name );
		if ($this->_connect->connect_errno) {
			trigger_error("Failed to connect to MySQL: " . $this->connect->connect_error, E_USER_ERROR);
		} 
	}

	public function disConnect() {
		$this->_connect->close();
	}

	public function getConnection() {
		$this->connect();
		return $this->_connect;
	}
    public function query($sql) {
        $mysqli = $this->getConnection();
        $result = $mysqli->query( $sql );
		$this->disConnect();
        return $result;
    }

	public function getData($sql) {
        $mysqli = $this->getConnection(); 
        $result = $mysqli->query($sql);
        $this->disConnect();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }else {
            return false;
        }   
    }
	
	public function updateById($colName, $colValue, $idValue) {
		$colValue = sqlValueFormatting($colValue);
		$sql = "UPDATE $this->table SET $colName = $colValue WHERE id =$idValue";
		$result = $this->query($sql);
		return $result != false;
	}
	


	public function getRelationValueFromThirdTable($value, $linkedTable, $linkedCol, $relationColName){
        $sql = "SELECT $relationColName from $linkedTable WHERE $linkedCol = sqlValueFormatting($value)";
        return $this->getData($sql);
    }
	

    
}