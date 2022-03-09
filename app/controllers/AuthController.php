<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Authentication;
use app\models\User;

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }

class AuthController extends Controller {

   public function login_view() {

      Authentication::auth()->check();
      if( Authentication::auth()->isAuth ) {
         return redirectRoute('home.index');
      }
      
      $data['page'] = [
         'title' => ' Login Page'
      ];
      viewPage("auth\login", $data, 'no-header-footer');
   }

   public function login() {
      $data['page'] = [
         'title' => 'Login page'
      ];
      // Validate
      if(empty($_POST['login'])) { return; }
      $user = new User;
      $auth = Authentication::auth();     
      $dataUser = $auth->checkUser($user->user_name, $user->password);
      if( gettype($dataUser) == 'array' ) {     
         $user->fillModelPropertiesData($dataUser);
         print_r($auth);
         // die();
         $auth->rememberAccount($user->id);
         redirect('http://localhost/product_manager/public/home'); 
      }

      $user->setPropertyErrorMessage('user_name', 'Username or Password is incorrect');
      $user->setPropertyErrorMessage('password', 'Username or Password is incorrect');
      $this->isValidatedForm = false;

      $data['dataView']['user'] = $user;
      return viewPage('auth/login', $data,'no-header-footer');
   }
   public function logout() {
      session_start();
      
      if (isset($_COOKIE['user'])) {
         unset($_COOKIE['user']); 
         setcookie('user', null, time() - 3600); 

         print_r($_COOKIE['user']);
         
      } 
      redirect('http://localhost/product_manager/public/login'); 
   }
      
}