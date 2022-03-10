<?php

namespace app\core;

use app\core\Database;


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
    protected function fillModelPropertiesData(array $properties){
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

}
