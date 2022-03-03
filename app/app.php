<?php

require "core/Router.php";
use app\Router;

class App {

	private $router;

	public function __construct() {
		$this->router = new Router;

		$this->router->get('/', function() {
			echo "return admin view";
		});
		$this->router->get('/login', function() {
			require_once "views/login.php";
		});
		
		$this->router->get('/product/new', function() {
			echo "return new product view";
		});
		$this->router->post('/product/new', function() {
			echo "process new product ";
		});
		
		$this->router->run();
	}

}