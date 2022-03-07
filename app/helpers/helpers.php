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

function viewPage($path, array $data, string $masterLayout =''){
	$defaultMasterLayout = getMasterLayout();

	$layout_path = empty($masterLayout) ? getLayoutPath( $defaultMasterLayout ) : getLayoutPath( $masterLayout );

	$path;
	extract($data);

	if( file_exists($layout_path) ) {
		require  $layout_path;
	}else {
		die("not found layout path");
	}
}
function getLayoutPath(string $layout) {
	return appRootDir().'\\views\\layout\\'. $layout .'.php';
}
function view($path, $data) {

	$data;
	
	$requirePath = appRootDir() .'\\views\\' . $path . '.php';
	if( file_exists($requirePath) ) {
		require  $requirePath;
	}else {
		return $requirePath." not found";
	}
}
function appRootDir() {
	$store = app\core\Store::store();
	return  $store->configs['app_root_dir'];
}
function publicRootDir() {
	$store = app\core\Store::store();
	return  $store->configs['public_root_dir'];
}
function getMasterLayout() {
	$store = app\core\Store::store();
	return  $store->configs['layout'];
}
