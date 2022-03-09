<?php
namespace app\core;

use app\core\Store;
class Router {
	
	public $routes = array();
	public $currentRoute;
	public $currentController;

	public function __construct($routes){
		Store::store()->router = $this;
		foreach($routes  as $name => $route) {
			call_user_func_array([$this, $route['method']], [$route['url'], $route['controller_method'], $name]);
		}
		$this->run();
	}

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

	private function add_router($method, $url, $action, $name) {
		$this->routes[$name] = [
			'method' => $method,
			'url' => $url,
			'action' => $action
		];
	}
	public function get($url, $action, $name) {
		$this->add_router('GET', $url, $action, $name);
	}
	public function post($url, $action, $name) {
		$this->add_router('POST', $url, $action, $name);
	}
	public function delete($url, $action, $name) {
		$this->add_router('DELETE', $url, $action, $name);
	}

	private function mapRouters() {

		$requestUrl = $this->getRequestUrl();
		$requestMethod = $this->getRequestMethod();
		$routes = $this->routes;
		$methodParams = [];
		foreach( $routes as $routeName => $route) {
			
			if( $this->isInvalidMethod($route['method'], $requestMethod) ) {continue;}
			if( $this->hasNoOpenParamCharacter($route['url'])) {
		    	if( $this->isValidRequestUrl($route['url'], $requestUrl) ){
					$this->currentRoute = $routeName;
					$this->callMethod( $route['action'], []);
					return;
		    	}
		    	continue;
			}
			if ($this->hasNoCloseParamCharacter($route['url'])) {continue;}

			$routeParams = array_filter(explode( '/', $route['url']));
			$requestParams = array_filter(explode( '/', $requestUrl));
			
			if($this->isNotValidCompareParams($routeParams, $requestParams)) {continue;}

			foreach( $routeParams as $index => $param) {
				if( preg_match('/^{\w+}$/', $param) ) { $methodParams[] = $requestParams[$index]; }
			}
			$this->callMethod($route['action'], $methodParams);
			return;	
		}
		die("404 page not found");
	}
	private function callMethod( $action, $params = [] ) {
		if( is_callable( $action ) ) {		
			call_user_func_array($action, $params);
			return;
		}
		if( is_string( $action ) ) {
			$className = explode( '@', $action )[0];
			$method_name = explode( '@', $action )[1];
			$this->currentController = $className;
			$classNameInNameSpace = 'app\\controllers\\'. $className;				
			if( !class_exists($classNameInNameSpace) ) { die("not found this Controller"); }

			if( !method_exists( $classNameInNameSpace, $method_name ) ) { die("this method is not exists"); }
			call_user_func_array([new $classNameInNameSpace, $method_name ], $params);
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
		// compare params count
		if( count( $routeParams ) !==  count( $requestParams ) ) { return true;}
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
		return  array_diff($routeParams, $requestParams ) == false ? false : true;
	}
	private function run() {
		$this->mapRouters();
	}
}