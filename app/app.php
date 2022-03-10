<?php
require "helpers/helpers.php";
require "core/Router.php";
require "core/Store.php";
require "core/Database.php";
require "core/Model.php";
require "core/Validation.php";
require "models/User.php";
require "models/Tag.php";
require "models/Product.php";
require "controllers/HomeController.php";
require "controllers/TagController.php";
require "controllers/AuthController.php";
require "controllers/ProductController.php";

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
		$this->router->get('/tag/edit/{id}', 'TagController@edit');
		$this->router->post('/tag/update/{id}', 'TagController@update');
		$this->router->post('/tag/delete/{id}', 'TagController@delete');
		$this->router->delete('/tag/destroy/{id}', 'TagController@destroy');

		$this->router->get('/product', 'ProductController@index');
		$this->router->get('/product/new', 'ProductController@create');
		$this->router->post('/product/new', 'ProductController@store');
		$this->router->get('/product/edit/{id}', 'ProductController@edit');
		$this->router->post('/product/update/{id}', 'ProductController@update');
		$this->router->post('/product/delete/{id}', 'ProductController@delete');
		$this->router->delete('/product/destroy/{id}', 'ProductController@destroy');
		
		$this->router->run();
	}

}
$app = new App($configs);