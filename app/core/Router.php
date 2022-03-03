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
			if( strpos( $request_method, $method) === FALSE ) 	continue;
			if( strcmp( strtolower( $request_url ),  strtolower( $url ) ) === 0 ){
				if( is_callable( $action ) ) {				
					$action();
				}
				return;
			}else {
				continue;
			}
		}

	}

	public function run() {
		$this->map_routers();
	}
}