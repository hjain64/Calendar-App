<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Login - Page </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="centre">
    <h1> Login Page </h1>
    <div style="color:red">
      <?php
       echo $check_error;
      ?>
    </div>
    <p> Please enter your user's login name and password. Both value are case sensitive. </p>
  </div>
  <div class="login-form">
  <form name = "login" method = "post" action ="" >
    <label class = "login-label"> Login: </label>
    <input type="text" name="login_id" class="login-input1"> <br>
    <label class = "login-label"> Password: </label>
    <input type="password" name="password" class="login-input2"> <br>
    <input type="submit" value="Submit" name="submit" class="login-submit">
  </form>
</div>
</body>
</html>
