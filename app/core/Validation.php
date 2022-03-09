<?php


namespace app\core;

class Validation {

    protected $validated = true;
    protected $data = array();
    protected $messages = array();

    protected $rules = [
        'max'      => 'checkMaxLength',
        'min'      => 'checkMinLength',
        'require'  => 'checkRequire',
        'email'    => 'checkEmail',
        'url'      => 'checkUrl'
    ];
    protected $invalidRuleMessages = [
        'max'      => 'Max length = {$} characters',
        'min'      => 'Min length = {$} characters',
        'require'  => 'This field is require',
        'email'    => 'This field is not email',
        'url'      => 'This field is not url'
    ];
    protected $validateDefaultMessage = [
        'success' => 'This filed is valid',
        'error' => 'This field is invalid'
    ];
    public function __construct( $data ) {
        $this->data = $data;
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

            $rules = $data[$key];
            $inputData = $this->cleanData($_POST[$key]);
            $validated_data = $this->checkRules($key, $rules, $inputData);

            if( $validated_data['status'] == false ) $this->validated = false;

            $this->data[$key] = $validated_data['value'];
            $this->messages[$key]['name'] = $key;
            $this->messages[$key]['status'] = $validated_data['status'];
            $this->messages[$key]['text'] = $validated_data['message'];
        }
    }
    protected function filterKeyInPostRequest($key) {
        $postKeys = array_keys($_POST);

        foreach( $postKeys as $postKey) {
            if( !$key == $postKey ) {
                return "unknow  $key in validate";
            }
        }
    }
    protected function checkRules($name, $rules = array(), $value = NULL ) {
        

        if( !empty($rules) ) {
            $current_status = true;
            $message = $this->validateDefaultMessage['success'];
            foreach( $rules as $ruleKey => $ruleValue ) {
                $method = $this->rules[$ruleKey];
                $current_status = call_user_func_array([$this, $method], array($ruleValue, $value));
                if  (!$current_status) { 
                    $message = str_replace('{$}', $ruleValue, $this->invalidRuleMessages[$ruleKey]);
                    break; 
                }
            }
            return [
                'status' => $current_status,
                'value' => $value,
                'message' => $name. ': '. $message
            ];
        }
    }
    public function getData() {
        return $this->data;
    }
    public function getMessage() {
        return $this->messages;
    }
    public function isValidated() {
        return $this->validated;
    }

    protected function checkMaxLength($number, $value) {
        if (is_numeric($number) ) {
            return strlen($value) <= $number ? true : false;
        }else {
            die("validate check max length rule invalid");
        }
    }
    protected function checkMinLength($number, $value) {
        if (is_numeric($number) ) {
            return strlen($value) >= $number ? true : false;
        }else {
            die("validate check min length rule invalid");
        }
    }
    protected function checkRequire($rule_value = false ,$value = false) {
        return ( $rule_value == true && !empty($value) ) ? true : false;
    }
}