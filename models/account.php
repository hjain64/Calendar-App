<?php
include_once "./database_info.php";
class login_Users
{
  public $conn;
  public function __construct() {
          $this->conn = mysqli_connect($db_servername, $db_name, $db_port, $db_username, $db_password);
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      }

      public function get_login($login) {
        $query1 = 'SELECT acc_login, acc_password, acc_name FROM tbl_accounts WHERE acc_login = "'.$login.'";';
         $result1 = mysqli_query($this->conn, $query1);
         return $result1;
      }
}



?>
