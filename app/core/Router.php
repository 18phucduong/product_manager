<?php
namespace app\core;

class Router {
	
	public $routers = array();

	private function getRequestUrl() {
		$basePath = getConfigs()['base_path'];
		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace($basePath, '', $url);
		return $url;
	}

	private function getRequestMethod(){
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		return $method;
	}

	public function add_router($method, $url, $action) {
		$this->routers[] = [$method, $url, $action];
	}

	public function get($url, $action) {
		$this->add_router('GET', $url, $action);
	}
	public function post($url, $action) {
		$this->add_router('POST', $url, $action);
	}
	public function delete($url, $action) {
		$this->add_router('DELETE', $url, $action);
	}

	public function mapRouters() {
		$requestUrl = $this->getRequestUrl();
		$requestMethod = $this->getRequestMethod();
		$routes = $this->routers;
		$methodParams = [];
		foreach( $routes as $route) {
			list( $method, $url, $action ) = $route;

			if( $this->isInvalidMethod($method, $requestMethod) ) {continue;}
			if( $this->hasNoOpenParamCharacter($url)) {
		    	if( $this->isValidRequestUrl($url, $requestUrl) ){
					$this->callMethod( $action, []);
					return;
		    	}
		    	continue;
			}
			if ($this->hasNoCloseParamCharacter($url)) {continue;}

			$routeParams = array_filter(explode( '/', $url));
			$requestParams = array_filter(explode( '/', $requestUrl));
			
			if($this->isNotValidCompareParams($routeParams, $requestParams)) {continue;}

			foreach( $routeParams as $index => $param) {
				if( preg_match('/^{\w+}$/', $param) ) { $methodParams[] = $requestParams[$index]; }
			}
			$this->callMethod($action, $methodParams);
			return;	
		}
		die("khong tim thay trang");
	}
	private function callMethod( $action, $params = [] ) {
		if( is_callable( $action ) ) {				
			call_user_func_array($action, $params);
			return;
		}
		if( is_string( $action ) ) {
			$class_name = explode( '@', $action )[0];
			$method_name = explode( '@', $action )[1];
		
			$class_name_in_name_space = 'app\\controllers\\'. $class_name;				
			if( !class_exists($class_name_in_name_space) ) { die("not found this Controller"); }

			if( !method_exists( $class_name_in_name_space, $method_name ) ) { die("this method is not exists"); }
			call_user_func_array([new $class_name_in_name_space, $method_name ], $params);
		}else {
			die("this action is not found");
		}
	}
	private function hasNoOpenParamCharacter(string $url) {
		return strpos( $url, '{' ) === false ? true : false; 
	}
	private function hasNoCloseParamCharacter(string $url) {
		return strpos( $url, '}' ) === false ? true : false; 
	}
	private function isValidRequestUrl(string $url, string $requestUrl) {
		$lowerUrl = strtolower( $url );
		$lowerRequestUrl = strtolower( $requestUrl );
		return strcmp( $lowerUrl,  $lowerRequestUrl ) === 0 ? true : false;
	}
	private function isInvalidMethod(string $routeMethod,string $requestMethod) {
		return  $requestMethod !== $routeMethod ? true :false;
	}
	private function isNotValidCompareParams(array $routeParams,array $requestParams) {	
		$continue = false;
		// compare params count
		$continue = count( $routeParams ) !==  count( $requestParams ) ? true : false;
		// compare params value
		$paramPositions = [];
		foreach($routeParams as $index => $param) {
			if(strpos($param, '{') !== false ) {
				$paramPositions[] = $index;
			}
		}
		foreach($paramPositions as $position) {
			unset($routeParams[$position]);
			unset($requestParams[$position]);
		}
		$continue = array_diff($routeParams, $requestParams ) != false ? true : false;
		
		return $continue;
	}
	public function run() {
		$this->mapRouters();
	}
}