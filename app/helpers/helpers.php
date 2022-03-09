<?php
// Validate 
function checkMaxLength($number, $value) {
	if (is_numeric($number) ) {
		return strlen($value) <= $number ? true : false;
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

	$configs = getConfigs();
	$defaultMasterLayout = getConfigs()['layout'];
	$appRootDir = $configs['app_root_dir'];
	$basePath = $configs['base_path'];
	$path;
	extract($data);

	$layout_path = empty($masterLayout) ? getLayoutPath( $defaultMasterLayout ) : getLayoutPath( $masterLayout );	
	
	if( file_exists($layout_path) ) {
		require  $layout_path;
	}else {
		die("not found layout path");
	}
}
function getLayoutPath(string $layout) {
	return getConfigs()['app_root_dir'] .'\\views\\layout\\'. $layout .'.php';
}
function view($path, $data) {

	$data;
	
	$requirePath = getConfigs()['app_root_dir'] .'\\views\\' . $path . '.php';
	if( file_exists($requirePath) ) {
		require  $requirePath;
	}else {
		return $requirePath." not found";
	}
}
function getConfigs() {
	$store = app\core\Store::store();
	return  $store->configs;
}
function getConfig($configName) {
	$store = app\core\Store::store();
	return  $store->configs[$configName];
}
function getSidebarCol(array $items, string $class) {

	echo "<nav class='nav nav-col $class'><ul>";	
	foreach( $items  as $item) {
		$text = $item['text'];
		$link = $item['link'];
		$icon = $item['icon'];
		$link_text = is_null($link) ? "href='$link'" : '';
		$icon_tag = !is_null($icon) ? "<i class='fa fa-$icon' aria-hidden='true'></i>" : '';

		if($item['link'] == null) {
			echo  "<li class='nav-item '><span $link_text>$icon_tag $text</span></li>";
		}else{
			echo "<li class='nav-item '><a $link_text>$icon_tag $text</a></li>";
		}
	}
	echo "</ul></nav>";
	
}