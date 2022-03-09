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

            $rules = $data[$key];
            $inputData = $this->cleanData($_POST[$key]);
            $validated_data = $this->checkRules($key, $rules, $inputData);

            if( $validated_data['status'] == false ) $this->validated = false;

            $this->data[$key] = $validated_data['value'];
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
                $current_status = call_user_func_array($this->rules[$ruleKey], array($ruleValue, $value));
                if  (!$current_status) { break; }
            }
            $message = $current_status == false ? $this->validateDefaultMessage['error'] : $this->validateDefaultMessage['success'];
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
}