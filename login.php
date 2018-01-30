<?php
    session_start();
    include_once "./models/account.php";
    if (!isset($login_obj)) {
      $login_obj = new login_Users();
    }
    $check_error = "";
    if (isset($_POST['submit']))
    {
     $login = $_POST['login_id'];
     $pass = $_POST['password'];
     if (empty($login) || empty($pass)){
       if (empty($login)){
         $check_error .= 'Please enter valid value for User Login field.<br>';
       }
       if (empty($pass)){
         $check_error .= 'Please enter valid value for User Password field.<br>';
       }
     }
     else {
          $result = $login_obj->get_login($login);
          if ($result && mysqli_num_rows($result) > 0) {
             $row = mysqli_fetch_array($result, MYSQLI_NUM);
              if ($row[1] == sha1($pass)){
                $_SESSION["id"] = $login;
                $_SESSION["pwd"] = $pass;
                $_SESSION["username"] = $row[2];
                header('Location: calendar.php');
              }
              else {
                $check_error .= 'Password is incorrect: Please check the password and try again.';
              }
          }
         else  {
           $check_error .= 'Login is incorrect: User does not exist. Please check the login details and try again. ';
         }
       }
     }
     include_once "./views/login_view.php";
?>
