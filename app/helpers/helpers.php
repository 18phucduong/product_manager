<?php

// input value in SQL
function sqlValueFormatting($value) {
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
	$defaultMasterLayout = $configs['layout'];

	$path;
	extract( $data );

	$layout_path = empty($masterLayout) ? getLayoutPath( $defaultMasterLayout ) : getLayoutPath( $masterLayout );	
	
	if( file_exists($layout_path) ) {
		require  $layout_path;
	}else {
		die("not found layout path");
	}
}
function getLayoutPath(string $layout) {
	return getConfigs('app_root_dir').'\\views\\layout\\'. $layout .'.php';
}
function view($path, $data = null) {
	extract($data);
	
	$requirePath = getConfigs('app_root_dir').'\views\\' . $path . '.php';
	if( file_exists($requirePath) ) {
		require  $requirePath;
	}else {
		return $requirePath." not found";
	}
}
function getConfigs($config = null) {
	$store = app\core\Store::store();

	if( $config ) {
		return $store->configs[$config];
	}
	return  $store->configs;
}
function getConfig($configName) {
	$store = app\core\Store::store();
	return  $store->configs[$configName];
}
// toSlug
function toSlug( $str, string $str1 = null) {
	if( !empty($str1) ) { return $str1; }
	
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}
function redirect($url, $statusCode = 303){
   header('Location: ' . $url, true, $statusCode);
   die();
}
function randomString(int $number)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randString = '';
	for ($i = 0; $i < $number; $i++) {
		$randString .= $characters[rand(0, strlen($characters))];
	}
	return $randString;
}
function viewValidateMessage($data) {
	$name = $data['name'];
	$text = $data['text'];
	
	echo "<label for='$name' generated='true' class='error'>$text</label>";
}
function isChecked($value, $checkList) {
	if(gettype($checkList) == 'string' && $value == $checkList) {
		return true;
	}
	foreach($checkList as $check) {
		if($check == $value) { return true; }
	}
	return false;
}

function setRoute($method, $url, $controllerMethod, $name = null ) {
	return [
		'method' => $method,
		'url' => $url,
		'controller_method' => $controllerMethod
	];
}

function router() {
	$store = \app\core\Store::store();
	return $store->router;
}
function route($name, $param = null) {
	$routeUrl = router()->routes[$name]['url'];
	$url = $routeUrl;
	if( $param != null && gettype($param) == 'string') {
		$paramName = explode( '=', $param )[0];
		$paramValue = explode( '=', $param )[1];
		$replaceValue =  '{' . $paramName . '}';
		$url = str_replace($replaceValue, $paramValue, $routeUrl);
	}
	return getUrlFromBasePath($url);
}

function breadcrumbs($currentPageName) {
	// get controller index 
	$router = router();
	$curentController = $router->currentController;
	$nameWithNotController = str_replace('Controller','', $curentController);
	$lowerName = strtolower($nameWithNotController);
	$routeName = $lowerName.'.index';
	$url = $router->routes[$routeName]['url'];


    $breadcrumbsData[] = [
        'slug' => '/home',
        'name' => 'Home'
    ];
	if( $routeName != 'home.index' ) {
		$breadcrumbsData[] = [
			'slug' => $url,
			'name' => $nameWithNotController
		];
		$breadcrumbsData[] = [
			'slug' => null,
			'name' => $currentPageName
		];
	}
    

	echo "<p id='breadcrumbs'>";
		for( $index = 0; $index < count($breadcrumbsData); $index++ ) {
			if($index == count($breadcrumbsData) - 1) {
				?>
					<span><?php echo $breadcrumbsData[$index]['name']?></span>
				<?php
			}else {
				?>
					<a href="<?php echo getUrlFromBasePath($breadcrumbsData[$index]['slug'])?>"><?php echo $breadcrumbsData[$index]['name']?></a> <span>/</span>
				<?php
			}
		}
    echo "</p>";
}
function getUrlFromBasePath($path) {
	return 'http://localhost'. getConfig('base_path').$path;
}

function redirectRoute($routeName, $data = null) {
	// die(router()->currentRoute);
	$url = route($routeName);
	if( router()->currentRoute == $routeName) { return; }
	session_start();
    if ( $data != null) { 

       $_SESSION['dataPage'] =  $data;
    }	
	$_SESSION['dataPage'] =  $data;
	
	header('Location: ' . $url, true);
	die();
}
function auth() {
	return app\models\Authentication::auth();
}
function convertSizeToNumber(string $string) {
	$number = explode('|', $string)[0];
	
	$tail = explode('|', $string)[1];
	if( !is_numeric($number) ) { return false; }
	if( $tail == 'M' ) {
		return floatval($number) * 1024*1024;
	}
	if( $tail == 'K' ) {
		return floatval($number) * 1024;
	}
	return false;
}