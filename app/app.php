<?php
require "helpers/helpers.php";
require "core/Router.php";
require "core/Store.php";
require "core/Database.php";
require "core/Model.php";
require "core/Validation.php";
require "models/User.php";
require "controllers/HomeController.php";
require "controllers/AuthController.php";

$configs = require_once "configs/main.php";
use app\core\Router;
use app\core\Store;

class App {

	private $router;

	public function __construct($configs) {

		$store = Store::store();
		$store->configs = $configs;

		$this->router = new Router;

		$this->router->get('/home', 'HomeController@index');
		$this->router->get('/login', 'AuthController@login_view');
		$this->router->post('/login', 'AuthController@login');
		
		$this->router->get('/product/new', function() {
			echo "return product controller create method";
		});
		$this->router->post('/product/new', function() {
			echo "return product controller store method ";
		});
		$this->router->get('/product/edit/{id}', function() {
			echo "return product controller edit method ";
		});
		$this->router->post('/product/edit/{id}', function() {
			echo "return product controller update method ";
		});
		$this->router->post('/product/delete/{id}', function() {
			echo "return product controller delete method ";
		});
		
		$this->router->run();
	}

}
$app = new App($configs);