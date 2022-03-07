<?php
namespace app\controllers;

use app\models\User;
use app\core\Validate;
use app\core\Validation;

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }

class AuthController {

   public function login_view() {
      require dirname(dirname(__FILE__)) . '\views\login.php';
   }

   public function login() {

      if(empty($_POST['login'])) return;
      // Validate
      $validate = new Validation($_POST);
      $data = $validate->validate([
         'user_name' => [
            'require' => true,
            'min' => '6'
         ],
         'password' => [
            'require' => true,
            'min' => 8,
            'max' => 50
         ]
      ]);

      if(  $validate->validated == false ) {
         echo "validated false";
         require dirname(dirname(__FILE__)) . '\views\login.php';
         return;
      }
      // Check user in database
      $user = $this->check_user($data['user_name']['value'],$data['password']['value']);
      

      if( !gettype($user) == 'array') {
         
         $data['user_name']['status'] = false;
         $data['user_name']['message'] = 'Username or Password is incorrect';
         $data['password']['status'] = false;
         $data['password']['message'] = 'Username or Password is incorrect';

         require dirname(dirname(__FILE__)) . '\views\login.php';
         return;
      }
      else {
         // remember account
         echo "login success";
         $this->rememberAccount($data['user_name']['value'], $data['password']['value']);
      }
   }

   protected function check_user($user_name, $password){
      $user_name = sql_value_formatting( $user_name );
      $password = sql_value_formatting( md5($password) );

      $sql="select * from users where user_name=". $user_name . 'and password='.  $password;
      $user_tabel = new User;

      return $user_tabel->get_data($sql)[0];
   }

   protected function rememberAccount($user_name, $password) {
      if(!empty($_POST["remember_pass"])) {
         setcookie ("user_name",  $user_name, time()+ (10 * 365 * 24 * 60 * 60));  
         setcookie ("password",	$password,	time()+ (10 * 365 * 24 * 60 * 60));
      } else {
         setcookie ("user_name",""); 
         setcookie ("password","");
      }
      $_SESSION["user"] = $user_name;
   }
   


}