<?php


namespace app\core;
class Validation {
    private $modelName;
    private $table;
    public $validated = true;
    public $data = array();
    public $filesData = array();
    public $messages = array();
    

    private $rules = [
        'max'      => [
            'name' => 'checkMaxLength',
            'type' => 'normal'
        ],
        'min'      => [
            'name' => 'checkMinLength',
            'type' => 'normal'
        ],
        'require'  => [
            'name' => 'checkRequire',
            'type' => 'normal'
        ],
        'email'    => [
            'name' => 'checkEmail',
            'type' => 'normal'
        ],
        'url'      => [
            'name' => 'checkUrl',
            'type' => 'normal'
        ],
        'unique'   => [
            'name' => 'checkNotInDB',
            'type' => 'database'
        ],
        'inDB'   => [
            'name' => 'checkInDB',
            'type' => 'database'
        ],
        'number'   =>   [
            'name' => 'checkNumber',
            'type' => 'normal',
        ],
        'compare'  => [
            'name' => 'compareFields',
            'type' => 'compare'
        ],
        'requireFile' => [
            'name' => 'requireFile',
            'type' => 'file'
        ],
        'maxSize' => [
            'name' => 'maxSize',
            'type' => 'file'
        ],
        'fileType' => [
            'name' => 'fileType',
            'type' => 'file'
        ],
        
        

    ];
    private $invalidRuleMessages = [
        'max'      => '{$field} Max length is {$value} characters',
        'min'      => '{$field} Min length is {$value} characters',
        'require'  => '{$field} already need require',
        'email'    => '{$field}  is not email',
        'url'      => '{$field} is not url',
        'unique'      => '{$field}  already exists',
        'inDB'      => '  Have no Data',
        'compare'      => '{$field}  must be {$operator} {$compareToField}',
        'fileType'      => '{$field}  must be {$value} ',
        'maxSize'      => 'File too big, max size is{$value}',
        'requireFile'      => 'u need provide image',
    ];

    public function __construct( $modelName, $tableName = null) {
        $this->data = $_POST;
        $this->filesData = $_FILES;
        $this->modelName = $modelName;
        if(is_null($tableName)) {
            $this->table = $modelName . 's';
        }else {
            $this->table = $tableName;
        }
    }

	private function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    
    public function validate( $ableProperties, $modelRules = array() ) {

        $files = [];
        foreach($ableProperties as $property ){
            $fileData =  $this->checkFilesData($property);
            if ( gettype($fileData) == 'array') {
                $files[$property] = $fileData;
                $inputData = $fileData;
            }else{
                $inputData = $this->cleanData($_POST[$property]);
            }
            $rules = $modelRules[$property];    
            $validatedData = $this->checkRules($property, $rules, $inputData);

            $this->data[$property] = $validatedData['value'];
            $this->messages[$property]['name'] = $property;
            $this->messages[$property]['text'] = $validatedData['message'];
        }
        // print_r($files);
        foreach( $files as $key => $file ) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = toSlug(str_replace($ext, '',$file['name'])).".$ext";
            $this->data[$key] = $fileName;
        }

        return $this;
    }

    public function checkRules($property, $rules = array(), $value = NULL ) {
        
        if( empty($rules) ) { return [ 'value' => $value ]; }

        foreach( $rules as $ruleKey => $ruleValue ) {

            
            $method = $this->rules[$ruleKey]['name'];
            if( $this->rules[$ruleKey]['type']  == 'file') {
 
                $status = call_user_func_array([$this, $method], array($ruleValue, $value));              
                if( !$status ) {
                    $this->validated = false;
                    $message = str_replace('{$value}', $ruleValue, $this->invalidRuleMessages[$ruleKey]);
                    $message = str_replace('{$field}', $property, $message);
                    break;
                }
            }

            if( $this->rules[$ruleKey]['type']  == 'normal') {

                 $status = call_user_func_array([$this, $method], array($ruleValue, $value));
                
                if( !$status ) {
                    $this->validated = false;
                    $message = str_replace('{$value}', $ruleValue, $this->invalidRuleMessages[$ruleKey]);
                    $message = str_replace('{$field}', $property, $message);
                    break;
                }
            }
            if( $this->rules[$ruleKey]['type']  == 'database') {
                $status = call_user_func_array([$this, $method], array($ruleValue, $property, $value));
                if( !$status ) {
                    $message = str_replace('{$field}', $property, $this->invalidRuleMessages[$ruleKey]);
                    break;
                }
            }
            if( $this->rules[$ruleKey]['type']  == 'compare') {
                $status = $this->compareFields( $rules[$ruleKey], $value );                
                if( !$status ) {
                    switch($ruleValue['operator']) {
                        case '>' :
                            $operator = 'bigger than';
                            break;
                        case '>=' :
                            $operator = 'bigger than or equal';
                            break;
                        case '<' :
                            $operator = 'less than';
                            break;
                        default :
                            $operator = 'less than or equal';
                    }
                    $message = str_replace('{$field}', $ruleValue['field1'], $this->invalidRuleMessages[$ruleKey]);
                    $message = str_replace('{$operator}', $operator, $message);
                    $message = str_replace('{$compareToField}', $ruleValue['field2'], $message);
                    break;
                }
            }
            if( $ruleKey == 'slugByField') {
                $compareToFieldKey = $ruleValue;
                $compareToFieldValue = $this->data[$compareToFieldKey];
                if( empty($value) ) { 
                    $value = toSlug($compareToFieldValue, $value);
                }
                break;
            }
        }
        return [
            'value' => $value,
            'message' => isset($message) ? $message : ''
        ];
    }

    private function checkMaxLength($ruleNumber, $value) {
        if (is_numeric($ruleNumber) ) {
            return (strlen($value) <= $ruleNumber);
        }else {
            die("validate check max length rule invalid");
        }
    }
    private function checkMinLength($ruleNumber, $value) {
        if (is_numeric($ruleNumber) ) {
            return strlen($value) >= $ruleNumber ? true : false;
        }else {
            die("validate check min length rule invalid");
        }
    }
    public function checkNumber($ruleNumber, $value) {
        return is_numeric($ruleNumber);
    }
    private function checkRequire($ruleValue = false ,$value = false) {
        // echo "q";
        return ( $ruleValue == true && !empty($value) );
    }
    private function compareFields(array $relation, $fieldValue ) {
        $operator = $relation['operator'];
        $compareToFieldKey = $relation['field2'];
        $compareToField = $this->data[$compareToFieldKey];
        switch ($operator) {
            case '<':
                return $this->lessThan( $fieldValue, $compareToField );
            case '<=':
                return $this->lessThanOrEqual( $fieldValue, $compareToField );
            case '>' :
                return $this->biggerThan( $fieldValue, $compareToField );
            default :
            return $this->biggerThanOrEqual( $fieldValue, $compareToField );
        }
    }
    private function lessThan( $field, $compareToField ) {

        return ($field < $compareToField); 
    }
    private function lessThanOrEqual( $field, $compareToField ) {

        return ($field <= $compareToField); 
    }
    private function biggerThan( $field, $compareToField ) {

        return ($field > $compareToField); 
    }
    private function biggerThanOrEqual( $field, $compareToField ) {

        return ($field >= $compareToField); 
    }
    public function checkNotInDB($ruleValue, $property, $value) {
        
        if( $ruleValue == false ) { return false; }
        return !Database::table($this->table)->inDataBase($property, $value);
    }
    public function checkInDB($ruleValue, $property, $value) {
        if( $ruleValue == false ) { return false; }
        return Database::table($this->table)->inDataBase($property, $value);
    }

    private function checkFilesData($property) { 
        if( array_key_exists($property, $this->filesData) ) {
            return $this->filesData[$property];
        }
        return false;
    }

    private function requireFile($ruleValue ,$file) {
        if ( $ruleValue ) {
            return !$file['error'];
        }
        return false;
    }
    private function maxSize($ruleValue ,$file) {
        $maxSize = convertSizeToNumber($ruleValue);
        return $file['size'] <= $maxSize;
    }
    private function fileType($ableTypes ,$file) {
        $ableTypesList = explode('|', $ableTypes);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (in_array($ext, $ableTypesList)) { return true; }
        return false;
    }

    public static function validateAll() {
        $store = \app\core\Store::store();
        $dataList = $store->validate;
        $validateStatus = true;
        foreach($dataList as $element) {
            if( $element->validated == false ) { $validateStatus = false; }
        }
        return [
            'data' => $dataList,
            'status' => $validateStatus
        ];
    }

    public static function validateList($validateId, $list, $table, $col, $rules) {
        
        $validate = new Validation($validateId, $table);
        $validate->data = null;
        
        foreach($list as $value) {
           
            $validatedData = $validate->checkRules($col, $rules, $value);
            $validate->data[] = $validatedData['value'];
            if( !empty($validatedData['message']) ) {
                $validate->messages = $validatedData['message'];
                $validate->validated = false;
                break;
            }
        }  
        $validate->validated = empty($validate->messages);

        $store = Store::store();
        $store->addElementToArrayInStore('validate', $validateId, $validate);

        return $validate->data;
    }
}