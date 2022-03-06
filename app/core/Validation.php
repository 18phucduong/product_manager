<?php


namespace app\core;

class Validation {

    public $validated = false;
    protected $data = array();

    protected $rules = [
        'max'      => 'checkMaxLength',
        'min'      => 'checkMinLength',
        'require'  => 'checkRequire',
        'email'    => 'checkEmail',
        'url'      => 'checkUrl'
    ];
    protected $validateDefaultMessage = [
        'success' => 'This filed is valid',
        'error' => 'This field is invalid'
    ];


    public function __construct( $data ) {
        $this->inputData = $data;
    }

	protected function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function validate($data = array()) {
        $keys = array_keys( $data );

        foreach($keys as $key ){
            $this->filterKeyInPostRequest($key);
            $inputData = $this->cleanData($_POST[$key]);
            
            
            $validated_data = $this->checkRules($key, $data[$key], $inputData);

            $this->data[$key]['value'] = $validated_data['value'];
            $this->data[$key]['status'] = $validated_data['status'];
            $this->data[$key]['message'] = $validated_data['message'];

        }

        return $this->data;
    }
    protected function filterKeyInPostRequest($key) {
        $postKeys = array_keys($_POST);

        foreach( $postKeys as $postKey) {
            if( !$key == $postKey ) {
                return "unknow  $key in validate";
            }
        }
    }

    protected function checkRules($name, $rules = array(), $value = '' ) {
        if( !empty($rules) ) {
            $current_status = false;
            foreach( $rules as $ruleKey => $ruleValue ) {
                $current_status = call_user_func_array($this->rules[$ruleKey], array($ruleValue, $value));
            }
            $message = $current_status == false ? $this->validateDefaultMessage['error'] : $this->validateDefaultMessage['success'];
            return [
                'status' => $current_status,
                'value' => $value,
                'message' => $name. ': '. $message
            ];
        }
    }    
}