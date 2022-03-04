<?php


namespace app;

class Router {
	
	public $routers = array();

	public function __construct() {

	}

	private function get_request_url() {

		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace('product_manager/public/', '', $url);
		return $url;
	}

	private function get_request_method(){
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

	public function map_routers() {
		$request_url = $this->get_request_url();
		$request_method = $this->get_request_method();
		$routes = $this->routers;

		foreach( $routes as $route) {


			list( $method, $url, $action ) = $route;
			$is_route = false;
			if( strpos( $request_method, $method) === FALSE ) 	continue;

			if( strpos( $url, '{' ) === false ) {
		    	if( strcmp( strtolower( $request_url ),  strtolower( $url ) ) === 0 ){
		    		$is_route = true;
		    	}else {
		    		continue;
		    	}
			}

			if( $is_route == true ) {
				$params = [];
				$this->call_method( $action, $params);
				return;
			}
		}

	}
	private function call_method( $action, $params ) {

		if( is_callable( $action ) ) {				
			call_user_func_array($action, $params);
		}elseif( is_string( $action ) ) {
			$class_name = explode( '@', $action )[0];
			$method_name = explode( '@', $action )[1];
			
			$class_name_in_name_space = 'app\\controllers\\'. $class_name;

			if( class_exists($class_name_in_name_space) ) {
				if( method_exists( $class_name_in_name_space, $method_name ) ) {
					call_user_func_array(array( new $class_name_in_name_space, $method_name ), $params);
				}
			}
		}
	}

	public function run() {
		$this->map_routers();
	}
}