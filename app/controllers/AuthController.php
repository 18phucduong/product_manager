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

      auth()->check();
      if( Authentication::auth()->isAuth ) {
         return redirectRoute('home.index');
      }
      
      $data['page'] = [
         'title' => ' Login Page'
      ];
      viewPage("auth\login", $data, 'no-header-footer');
   }

   public function login() {
      auth()->ValidateAndCheckUser($_POST['user_name'], $_POST['password']);
   }
   public function logout() {
      auth()->logout();
   }  
}