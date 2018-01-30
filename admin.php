<?php
session_start();
include_once "./models/users.php";
if (!isset($_SESSION["id"]) && !isset($_SESSION["pwd"]) ){
  header('Location: login.php');
  exit();
}
if (!isset($admin_obj)) {
      global $admin_obj;
      $admin_obj = new admin();
}

function addtable ($id, $name, $login, $password) {
  $construct_row =  "<tr style='background-color: #ffba66;'> \n"
                   ."<td> " . $id . " </td>\n"
                   ."<td> " . $name . " </td>\n"
                   ."<td> " . $login . " </td>\n"
                   ."<td> </td>\n"
                   ."<td>\n"
                   .'<button type="submit" name="'. $id .'edit" value="submitted">Edit</button>'
                   .'<button class="button-margin" type="submit" name="'. $id .'del" value="submitted">Delete</button>'
                   ." </td> </tr> \n";
return $construct_row;
}
function modifyuser ($id, $name, $login, $password) {
  $editted_row =  "<tr style='background-color: #ffba66;'> \n"
                   ."<td> " . $id . " </td>\n"
                   ."<td> <input type='text' name='". $id ."editted_name' value='" . $name . "'>  </td>\n"
                   ."<td> <input type='text' name='". $id ."editted_login' value='" . $login . "'>  </td>\n"
                   ."<td> <input type='password' name='". $id ."editted_pass'> </td>\n"
                   ."<td>\n"
                   .'<button type="submit" name="'. $id .'update" value="submitted">Update</button>'
                   .'<button class="button-margin" type="submit" name="'. $id .'can" value="submitted">Cancel</button>'
                   ." </td> </tr> \n";
return $editted_row;
}


if (isset($_POST['addnew']))
{
 $name = $_POST['login_name'];
 $login = $_POST['login_id'];
 $pass = $_POST['password'];
 if (empty($name) || empty($login) || empty($pass)){
   if (empty($name)){
     $insert_error .= 'Please enter valid value for User Name field.<br>';
   }
   if (empty($login)){
     $insert_error .= 'Please enter valid value for User Login field.<br>';
   }
   if (empty($pass)){
     $insert_error .= 'Please enter valid value for User Password field.<br>';
   }
 }
 else {
    if ($admin_obj->add_users($name, $login, $password) == 1) {
      $users_error .='Account Added sucessfully.<br>';
    }
    else {
        $users_error .= 'The Login is used by another user. <br>';
    }
  }
}
$list_user = $admin_obj->get_user_list();
foreach ($list_user as $key_n => $user_details)
{
   if (isset($_POST[$user_details['acc_id'].'update']))
  {  $e_name = $_POST[$user_details['acc_id'].'editted_name'];
     $e_login = $_POST[$user_details['acc_id'].'editted_login'];
     $e_pass =  $_POST[$user_details['acc_id'].'editted_pass'];
     if (empty($e_name) || empty($e_login) || empty($e_pass)){
       if (empty($e_name)){
         $users_error .= 'Please enter valid value for User Name field.<br>';
       }
       if (empty($e_login)){
         $users_error .= 'Please enter valid value for User Login field.<br>';
       }
       if (empty($e_pass)){
         $users_error .= 'Please enter valid value for Password field.<br>';
      }
      } else {
    if ( $admin_obj->update_user($user_details['acc_id'], $e_name, $e_login, $e_pass)  == 0) {
       $users_error .= 'The Login is used by another user. <br>';
}
   else  {
        $users_error .= "Account updated successfuly. <br>";
        unset($_POST[$user_details['acc_id'].'edit']);
        unset($_POST[$user_details['acc_id'].'update']);
   }
  }
}
  else if (isset($_POST[$user_details['acc_id'].'del']))
  {
    $admin_obj->del_user($user_details['acc_id']);
    unset($_POST[$user_details['acc_id'].'del']);
    $users_error .= "Account Deleted sucessfully. <br>";
  }
  else if (isset($_POST[$user_details['acc_id'].'can']))
  {
    unset($_POST[$user_details['acc_id'].'can']);
    unset($_POST[$user_details['acc_id'].'edit']);
  }
}
$list_user1 = $admin_obj->get_user_list();
foreach ($list_user1 as $key_n => $user_details) {
  if((isset($_POST[$user_details['acc_id'].'edit'])) || (isset($_POST[$user_details['acc_id'].'update']))) {
    $users_list .= modifyuser($user_details['acc_id'], $user_details['acc_name'], $user_details['acc_login'],$user_details['acc_password']);
}
  else {
    $users_list .= addtable($user_details['acc_id'], $user_details['acc_name'], $user_details['acc_login'],$user_details['acc_password']);
}
}


include_once "./views/users_view.php";
?>
