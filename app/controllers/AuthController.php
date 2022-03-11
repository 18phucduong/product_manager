<?php
namespace app\controllers;

use app\models\User;
use app\core\Validation;

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }

class AuthController {

   public function login_view() {
      $data['page'] = [
         'title' => ' Login Page'
      ];
      viewPage("auth\login", $data, 'no-header-footer');
   }

   public function login() {

      if(empty($_POST['login'])) { return; }
      // Validate
      $user = new User;
      // Check user in database
      $dataUser = $this->checkUser($user->user_name, $user->password);

      
      if( gettype($dataUser) == 'array' ) {     
         echo "<pre>";
      print_r($dataUser);
      echo "</pre>";
         $this->rememberAccount($user->user_name, $user->password);
         $user->fillModelPropertiesData($dataUser);
         redirect('http://localhost/product_manager/public/home');  
      }
      $user->message->user_name['status'] = false;
      $user->message->user_name['text']  = 'Username or Password is incorrect';
      $this->isValidatedForm = false;
      $data['dataView']['user'] = $user;
      return viewPage('auth/login', $data,'no-header-footer');
      
   }

   protected function checkUser($user_name, $password){
      $user_name = sqlValueFormatting( $user_name );
      $password = sqlValueFormatting( md5($password) );
      $sql="select * from users where user_name=". $user_name . 'and password='.  $password;
      
      $user = new User;
      $data = $user->getData($sql);
      return gettype($data) == 'array' ? $data : false;
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

   protected function validateFail($data) {
      echo "validated false";
      require dirname(dirname(__FILE__)) . '\views\login.php';
      return;
   }

   protected function accountVerificationFailed($id_name, $pass_name) {
      
   }
}