<?php
// Validate 
function checkMaxLength($number, $value) {
	if (is_numeric($number) ) {
		return strlen($value) >= $number ? false : true;
	}else {
		die("validate check max length rule invalid");
	}
}
function checkMinLength($number, $value) {
	if (is_numeric($number) ) {
		return strlen($value) >= $number ? true : false;
	}else {
		die("validate check min length rule invalid");
	}
}
function checkRequire($rule_value = false ,$value = false) {
	return ( $rule_value == true && !empty($value) ) ? true : false;
}
// input value in SQL
function sql_value_formatting($value) {
    switch (gettype($value)) {
        case "string":
            return "'". $value . "'";
            break;
        case "boolean":
            return $value == false ? 'false' : 'true';
            break;
        default:
            return $value;
    }
}