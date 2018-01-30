<?php
include_once "./database_info.php";
class admin {
  public $conn;
  public function __construct() {
        $this->conn = mysqli_connect($db_servername, $db_name, $db_port, $db_username, $db_password);
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      }
  public function get_user_list() {
        $list_query = 'SELECT * FROM tbl_accounts';
        $list_result =  mysqli_query($this->conn, $list_query);
        $userlist = array();
        while ($rows = mysqli_fetch_assoc($list_result))
        {
          array_push($userlist, $rows);
        }
        return $userlist;
   }
  public function add_users($new_username, $new_login, $new_pass) {
    $check_login = 'SELECT * FROM tbl_accounts WHERE acc_login = "'.$new_login.'";';
    $login_result =  mysqli_query($this->conn, $check_login);
    if ($login_result && mysqli_num_rows($login_result) > 0) {
      return 0;
    }
    $iquery = 'INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES (\''.$new_username.'\', \''.$new_login.'\',\''.sha1($new_pass).'\');';
    $insert_result =  mysqli_query($this->conn, $iquery);
    return 1;
 }

 public function del_user($id) {
   $dquery = 'DELETE FROM tbl_accounts WHERE acc_id ='.(int)$id.' LIMIT 1;';
   $del_result =  mysqli_query($this->conn, $dquery);
 }
 public function update_user($id, $name, $login, $pass) {
   $check_login = 'SELECT * FROM tbl_accounts WHERE acc_login = "'.$login.'" and acc_id !="'.$id.'";';
   $login_result =  mysqli_query($this->conn, $check_login);
   if ($login_result && mysqli_num_rows($login_result) > 0) {
     return 0;
   }
   $uquery = 'UPDATE tbl_accounts SET acc_login = \''.$login.'\', acc_name = \''.$name.'\', acc_password = \''.sha1($pass).'\' WHERE acc_id ='.(int)$id.';';
   $update_result =  mysqli_query($this->conn, $uquery);
   return 1;
 }
}
?>
