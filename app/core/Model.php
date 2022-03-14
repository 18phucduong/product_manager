<?php

namespace app\core;

use app\core\Database;
use app\core\Store;
use app\core\Validation;

class Model {
    
    public function __construct() {
        $this->setModelProperties();
        
    }
    public function validate($modelRules = null) {

        if( is_null( $modelRules ) ) { $modelRules = $this->modelRules; }
        $modelName = $this->getModelName();
        $validate = new Validation($modelName,$this->table);
        $validate->validate($this->ableProperties
        , $modelRules);
        $store = Store::store();
        $store->addElementToArrayInStore('validate', $modelName, $validate);
        return $validate->data;
    }
    public function fillModelPropertiesData(array $properties){
        foreach($properties as $property => $value) {
            $this->$property = $value;
        }
    }

    public function setModelProperties() {
        if( !isset($this->ableProperties) ) { return; }
        
        $modelProperties = $this->ableProperties;
        foreach( $modelProperties as $property ) {
            $this->$property = null;
        }
    }
    public function setTable($tableName) {
        $this->table = $tableName;
    }
    protected function getModelName() {
        $className = get_class($this);
        $modelName = str_replace('app\\models\\' , '', $className );
        return strtolower($modelName);
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
