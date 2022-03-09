<?php
error_reporting(E_ERROR | E_PARSE);

require_once "helpers/helpers.php";
require_once "core/AutoLoad.php";
$configs = require_once "configs/main.php";
use app\core\AutoLoad;
use app\core\Router;
use app\core\Store;
class App {

	public function __construct($configs) {
		new AutoLoad($configs['root_dir']);
		$store = Store::store();
		$store->configs = $configs;

		$routes = require_once "routes.php";
		new Router($routes);
	}

}
$app = new App($configs);