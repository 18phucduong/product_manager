<?php

namespace app\models;

use app\core\Model;
use app\core\Store;

class Authentication extends Model {

    private static $user;

    public function __construct(){
        parent::__construct();
    }
    public static function auth() {
		if(!self::$user) { // If no instance then make one
			self::$user = new self();
            self::$user->setTable('users');
            self::$user->isAuth = false;
		}
		return self::$user;
	}
    public function checkUser($user_name, $password){
        $user_name = sqlValueFormatting( $user_name );
        $password = sqlValueFormatting( md5($password) );
        $sql="select * from users where user_name=". $user_name . 'and password='.  $password;
        
        $data = $this->getData($sql);
        return gettype($data) == 'array' ? $data[0] : false;
    }
    public function check(){
        session_start();
        if(!isset($_COOKIE['user']) && router()->currentRoute != 'auth.loginPage'){
            redirect('http://localhost/product_manager/public/login'); 
        }
        $token = $_COOKIE['user'];

        $tokenSqlText = sqlValueFormatting($token);
        $sql="select * from users where token=$tokenSqlText";
        $data = $this->getData($sql);
        
        if (gettype($data) == 'array') {
            $this->fillModelPropertiesData($data[0]);
            $this->isAuth = true;   
        }
    }
    public function rememberAccount($id) {
        session_start();
        if(!empty($_POST["remember"])) {
           $token = randomString(50);
           setcookie("user",  $token, time()+ (10 * 365 * 24 * 60 * 60)); 
           $_SESSION["user"] = $token;
           $this->updateCol('token',$token, $id);
        }
    }
}
