<?php

namespace app\models;

use app\core\DataBase;
use app\core\Store;

class Authentication {

    private static $auth;
    protected $user;
    private $validateRules = [
        'user_name' => [
            'require' => true,
            'min' => '5'
        ],
        'password' => [
            'require' => true,
            'min' => 7,
            'max' => 50
        ]
    ];
    public function __construct(){

    }
    public static function auth() {
		if(!self::$auth) { // If no instance then make one
			self::$auth = new self();
            self::$auth->isAuth = false;
		}
		return self::$auth;
	}
    public function ValidateAndCheckUser($user_name, $password){

        $validate = $this->validate();
        

        if( !$validate->validated ) { redirectRoute('auth.loginPage'); }

        $user = $this->validateInDB($user_name, $password);
        $password =  md5($password);
        $user = Database::table('users')->select('*')->where('user_name', '=', $user_name)->where('password', '=', $password)->get()[0];
        // print_r($user);
        // die();
        if( $user != false ) {
            $this->login($user);
            redirectRoute('home.index');
        }

        redirectRoute('auth.loginPage');
    }
    public function check(){
        if( !isset($_SESSION['user']) && !isset($_COOKIE['user']) ) { redirectRoute('auth.loginPage'); }
        // die('qq');
        if( isset($_SESSION['user']) ) {
            // die($_SESSION['user']);
            $this->checkDbAndRedirect($_SESSION['user'], 'auth.loginPage');
            $this->isAuth = true;
            return;
        }else if( isset($_COOKIE['user']) ) {
            die($_COOKIE['user']);
            setcookie("PHPSESSID", $_COOKIE['user'], time()+ (10 * 365 * 24 * 60 * 60)); 
            // $_COOKIE['PHPSESSID'] = $_COOKIE['user'];
            $this->checkDbAndRedirect($_SESSION['user'], 'auth.loginPage');
            $this->isAuth = true;  
        }    
    }
    public function rememberAccount($id) {
        if(!empty($_POST["remember"])) {
           setcookie("user", $_COOKIE['PHPSESSID'], time()+ (10 * 365 * 24 * 60 * 60)); 
        }
    }

    function checkDbAndRedirect($token, $routeName) {
        $isInDatabase = Database::table('users')->inDatabase('id', $token);
        if ( !$isInDatabase ) {
            redirectRoute($routeName);
        }
    }

    public function logout() {
        if (isset($_COOKIE['user'])) {
            setcookie("user", "", time()-3600);         
        } 
        session_destroy();
        redirectRoute('auth.login');
    }
    private function validate() {
        $validate = new \app\core\Validation( 'auth', 'users' );
        $validate->validate(['user_name', 'password'],$this->validateRules);

        $store = Store::store();
        $store->addElementToArrayInStore('validate', 'auth', $validate);
         
        return  $validate;
    }

    private function validateInDB($user_name, $password) {
        $password =  md5($password);
        $sql="select * from $this->table where user_name=". $user_name . 'and password='.  $password;
        
        $data = Database::getInstance()->getData($sql);
        $data = Database::table('users')->getData($sql);

        if(gettype($data) == 'array') {
            return $data[0]; 
        }

        $validate = new \stdClass;
        $validate->validated = false;
        $validate->data = [
            'user_name' => $user_name,
            'password' => $password
        ];
        $validate->message['user_name']['text']= 'User_name or password was wrong ';

        $store = Store::store();
        $store->addElementToArrayInStore('validate', 'auth', $validate);

        return false;
    }

    public function login($user) {
        $_SESSION['user'] =  $user['id']; 
        $this->rememberAccount($user['id']);
        $this->user = $user;
    }

}
