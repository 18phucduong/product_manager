<?php

namespace app\core;

use app\core\Database;
use app\core\Validation;


class Model extends Database {

    protected $table;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getData($sql) {
        $db = Database::getInstance();
        $mysqli = $db->getConnection(); 
        $result = $mysqli->query($sql);
        $db->disConnect();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }else {
            return "0 results";
        }   
    }
    protected function validate($data) {
        $validate = new Validation($_POST);
        $validate->validate($data);
        $this->isValidatedForm = $validate->isValidated();
        $this->setModelPropeties($validate->getData());
        $this->setMessagePropeties($validate->getMessage()); 
    }

    public function insert($data) {
        $tableCols = array_keys($data);
        $tableColsValue = array_values($data);
        $tableColsText = '';

        for( $i=0; $i < count($tableCols); $i++ ) {
            if($i < count($tableCols) -1 ) {
                $tableColsText .= $tableCols[$i] . ', ';
            }else{
                $tableColsText .= $tableCols[$i];
            }
        }
        $tableColsValue_text = '';
        for( $i=0; $i < count($tableColsValue); $i++ ) {
            $value = sqlValueFormatting($tableColsValue[$i]);

            $tableColsValue_text .= ($i < count($tableColsValue) -1 ) ?  ( $value . ', ') : $value;
        }
        $sql = "INSERT INTO $this->table ( $tableColsText )
        VALUES ( $tableColsValue_text )";
        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $result =  $mysqli->query($sql);
        if($result == 1) {
            $data = $this->getData("SELECT * FROM $this->table ORDER BY id DESC LIMIT 1")[0];
            $this->fillModelPropertiesData($data);
            return true;
        }
        $db->disConnect();
        return false;
    }
    public function updateCol($colName, $colValue, $id) {
        $tokenSqlText = sqlValueFormatting($colValue);
        $sql = "UPDATE $this->table SET $colName = $tokenSqlText WHERE id =$id";
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $result =  $mysqli->query($sql);

        if($result == 1) {
            $data = $this->getData("SELECT * FROM $this->table ORDER BY id DESC LIMIT 1")[0];
            $this->fillModelPropertiesData($data);
        }
        $db->disConnect();
    }
    public function hasColValue($colName, $value){
        $sqlValue = sqlValueFormatting($value);
        $sql = "SELECT * FROM $this->table WHERE $colName = $sqlValue";
        return  gettype($this->getData($sql)) == 'array' ? true : false;
    }
    public function getAll() {
        return $this->getData("SELECT * FROM $this->table");
    }
    public function findId( $id, $id_col = 'id' ) {
        return $this->getData("SELECT * FROM $this->table WHERE $id_col=$id");
    }

    public function deleteId( $id, $id_col = 'id' ) {
        return $this->getData("DELETE FROM $this->table WHERE $id_col=$id");
    }
    public function fillModelPropertiesData(array $properties){
        foreach($properties as $property => $value) {
            $this->$property = $value;
        }
    }

    public function getRelationValueFromThirdTable($value, $linkedTable, $linkedCol, $relationColName){
        $sql = "SELLECT $relationColName from $linkedTable WHERE $linkedCol = sqlValueFormatting($value)";
        return $this->getData($sql);
    }
    public function insertRelationValueFromThirdTable(string $linkedTable, string $colName, string $relationName,$value, array $relationValues){
       
        $relationValuesText = '';
        for( $i=0; $i < count($relationValues); $i++ ) {

            $relationValue_text =  sqlValueFormatting($relationValues[$i]);
            $valueText = sqlValueFormatting($value);
            $valueSqlText = "( $valueText, $relationValue_text )";

            $relationValuesText .= ($i < count($relationValues) -1 ) ?  ( $valueSqlText . ', ') : $valueSqlText;
        }
        $sql = "INSERT INTO $linkedTable( $colName, $relationName )
        VALUES  $relationValuesText ";

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $result =  $mysqli->query($sql);
        $db->disConnect();
    }

    public function setModelPropeties(array $data) {
        $replaceList = $this->replaceList;
        foreach( $replaceList as $key => $value) {
            $this->$key = isset( $data[$value] ) ? $data[$value] : null;
        }
    }
    protected function setMessagePropeties(array $data) {
        $replaceList = $this->replaceList;
        $newArr = [];
        foreach( $replaceList as $key => $value) {
            if( isset( $data[$value] )) { $newArr[$key] = $data[$value]; }
        }
        $this->message = $newArr;
    }
    public function setPropertyErrorMessage($property_name, $message) {

        $this->message[$property_name]['name']  = $property_name;
        $this->message[$property_name]['status'] = false;
        $this->message[$property_name]['text'] = $message;
    }
    public function setTable($tableName) {
        $this->table = $tableName;
    }

}
