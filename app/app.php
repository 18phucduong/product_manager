<?php

function checkMaxLength($number, $value) {
	if (is_numeric($number) ) {
		if(strlen($value) >= $number) {
			return true;
		}else {
			return false;
		}
	}else {
		die("validate check max length rule invalid");
	}
	
}
function checkMinLength($number, $value) {
	if (is_numeric($number) ) {
		if(strlen($value) >= $number) {
			return true;
		}else {
			return false;
		}
	}else {
		die("validate check min length rule invalid");
	}
}
function checkRequire($rule_value = false ,$value = false) {
	if( $rule_value == true && !empty($value)) {
		return true;
	}
	else {
		return false;
	}
}
function checkEmail($string) {
	return true;

}
function checkUrl($string) {
	return true;
}
 

function sql_value_formatting($value) {
    if( gettype($value) == 'string') {
        return "'". $value . "'";
    }elseif( gettype($value) == 'boolean'){
        if($value == false) {
            return 'false';
        }else return 'true';
    }else return $value;
}

require "core/Router.php";
require "core/Database.php";
require "core/Model.php";
require "core/Validation.php";
require "models/User.php";
require "controllers/HomeController.php";
require "controllers/AuthController.php";

use app\Router;

class App {

	private $router;

	public function __construct() {
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