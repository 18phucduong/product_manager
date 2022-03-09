<?php
require "helpers/helpers.php";
require "core/Router.php";
require "core/Store.php";
require "core/Database.php";
require "core/Model.php";
require "core/Validation.php";
require "models/User.php";
require "models/Tag.php";
require "controllers/HomeController.php";
require "controllers/TagController.php";
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
		

		$this->router->get('/tag/new', 'TagController@create');
		$this->router->post('/tag/new', 'TagController@store');
		$this->router->get('/tag/edit', 'TagController@edit');
		$this->router->post('/tag/update', 'TagController@update');
		
		$this->router->run();
	}

}
$app = new App($configs);