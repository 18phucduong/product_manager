<?php


namespace app\core;

class Validation {

    public $data = array();
    public $error = array();

	
	public function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function validate($data = array()) {
        $keys = array_keys( $data );

        foreach($keys as $key ){
            $this->filterKeyInPostRequest($key);
        }

        




    }
    function filterKeyInPostRequest($key) {
        $postKeys = array_keys($_POST);

        foreach( $postKeys as $postKey) {
            if( !$key == $postKey ) {
                return "unknow  $key in validate";
            }
        }
    }
    public function validatePostMethod($value, $type='clean') {

        $this->data[$value] = isset($_POST[$value]) ? $this->cleanData($_POST[$value]) : '';
        
        if( $type="email") {
            if (!filter_var($this->data[$value], FILTER_VALIDATE_EMAIL)) {
                $this->error[$value] = "Invalid email format";
            }
        }
        if( $type="url") {
            if (!filter_var($this->data[$value], FILTER_VALIDATE_URL)) {
                $this->error[$value] = "Invalid email format";
            }
        }
    }
    
}