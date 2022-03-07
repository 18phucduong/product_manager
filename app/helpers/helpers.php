<?php
function checkMaxLength($number, $value) {
	if (is_numeric($number) ) {
		if(strlen($value) >= $number) {
			return false;
		}else {
			return true;
		}
	}else {
		die("validate check max length rule invalid");
	}
	
}
function checkMinLength($number, $value) {
	if (is_numeric($number) ) {
		if(strlen($value) >= $number) {
			return true;
		}else {
			return false;
		}
	}else {
		die("validate check min length rule invalid");
	}
}
function checkRequire($rule_value = false ,$value = false) {
	if( $rule_value == true && !empty($value)) {
		return true;
	}
	else {
		return false;
	}
}
function checkEmail($string) {
	return true;

}
function checkUrl($string) {
	return true;
}
 

function sql_value_formatting($value) {
    if( gettype($value) == 'string') {
        return "'". $value . "'";
    }elseif( gettype($value) == 'boolean'){
        if($value == false) {
            return 'false';
        }else return 'true';
    }else return $value;
}