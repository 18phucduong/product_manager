<?php
namespace app\controllers;

use app\models\User;

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }

class AuthController {

   public function login_view() {
      // $user = new User;
      // $user->insert([
      //    'user_name' => 'supper_admin',
      //    'password' => md5('123456789')
      // ]);

      require dirname(dirname(__FILE__)) . '\views\login.php';
   }

   public function login() {
      $error = array();
      $data = array();
      if (!empty($_POST['login'])){
         // Lấy dữ liệu
         $data['user_name'] = isset($_POST['user_name']) ? test_input($_POST['user_name']) : '';
         $data['password'] = isset($_POST['password']) ? test_input($_POST['password']) : '';
      
         // Kiểm tra định dạng dữ liệu
         if (empty($data['user_name'])){
            $error['user_name'] = 'Please provide a user_name';
         }
         else if (empty($data['password'])){
            $error['password'] = 'Please provide a password';
         }

         $user_name = sql_value_formatting( $data['user_name'] );
         $password = sql_value_formatting( md5($data['password']) );

      
         // Lưu dữ liệu
         $sql="select * from users where user_name=". $user_name . 'and password='.  $password;

         $user_tabel = new User;
         $users = $user_tabel->get_data($sql);

         if( !gettype($users) == 'array') {
            echo "nope";
         }else {
            echo "login success";
            if(!empty($_POST["remember_pass"])) {
               setcookie ("user_name",  $data['user_name'], time()+ (10 * 365 * 24 * 60 * 60));  
               setcookie ("password",	$data['password'],	time()+ (10 * 365 * 24 * 60 * 60));
            } else {
               setcookie ("user_name",""); 
               setcookie ("password","");
            }
            $_SESSION["user"] = $users[0]['user_name'];
         }

      }
   
      echo "</br>";
      echo "<pre>";
      print_r($_POST);
      echo "</pre>";
   }


}