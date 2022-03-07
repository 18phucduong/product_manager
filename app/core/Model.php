<?php

namespace app\core;

use app\core\Database;


class Model extends Database {

    protected $table_name;
    
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
            echo "0 results";
        }   
    }

    public function insert($data) {
        $table_cols = array_keys($data);
        $table_cols_value = array_values($data);
        $table_cols_text = '';

        for( $i=0; $i < count($table_cols); $i++ ) {
            if($i < count($table_cols) -1 ) {
                $table_cols_text .= $table_cols[$i] . ', ';
            }else{
                $table_cols_text .= $table_cols[$i];
            }
        }
        $table_cols_value_text = '';
        for( $i=0; $i < count($table_cols_value); $i++ ) {
            $value = sql_value_formatting($table_cols_value[$i]);

            $table_cols_value_text = ($i < count($table_cols_value) -1 ) ?  ( $value . ', ') : $value;
        }
        $sql = "INSERT INTO $this->table_name ( $table_cols_text )
        VALUES ( $table_cols_value_text )";

        $db = Database::getInstance();
        $mysqli = $db->getConnection(); 
        $mysqli->query($sql);
        $db->disConnect();

    }

    public function findId( $id, $id_col = 'id' ) {
        $this->getData("SELECT * FROM $this->table_name WHERE $id_col=$id");
    }

    public function deleteId( $id, $id_col = 'id' ) {
        $this->getData("DELETE FROM $this->table_name WHERE $id_col=$id");
    }


}

