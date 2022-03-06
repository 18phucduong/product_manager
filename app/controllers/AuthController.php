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
         // Lấy dữ liệu
      $validate = new Validation($_POST);
      
      $data = $validate->validate([
         'user_name' => [
            'require' => true,
            'min' => '6'
         ],
         'password' => [
            'require' => true,
            'min' => 8,
            'max' => 50,
         ]
         ]);

      if(  $validate->validated == false ) {
         require dirname(dirname(__FILE__)) . '\views\login.php';
         return;
      }


      // $user_name = sql_value_formatting( $data['user_name']['value'] );
      // $password = sql_value_formatting( md5($data['password']['value']) );

      
 
      // $sql="select * from users where user_name=". $user_name . 'and password='.  $password;
      // $user_tabel = new User;
      // $users = $user_tabel->get_data($sql);

      // if( !gettype($users) == 'array') {
      //    echo "nope";
      // }else {
      //    echo "login success";
      //    if(!empty($_POST["remember_pass"])) {
      //       setcookie ("user_name",  $data['user_name'], time()+ (10 * 365 * 24 * 60 * 60));  
      //       setcookie ("password",	$data['password'],	time()+ (10 * 365 * 24 * 60 * 60));
      //    } else {
      //       setcookie ("user_name",""); 
      //       setcookie ("password","");
      //    }
      //    $_SESSION["user"] = $users[0]['user_name'];
      // }
   }
   


}