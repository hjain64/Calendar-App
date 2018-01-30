<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Users Page </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="centre">
    <h1> Admin Page </h1>
  </div>
  <div>
  <?php
    echo '<h2 class="welcome"> Welcome ' . $_SESSION["username"] . '</h2><br>';
    ?>
    <button onclick="location.href = 'logout.php';" class="logout-submit">Logout</button>
  </div>
  <nav id="nav">
    <a href="calendar.php" class="nav-link"> My Calendar </a>
    <a href="form.php" class="nav-link"> Form Input </a>
    <a href="admin.php" class="nav-link"> Admin </a>
  </nav>
  <div class="user-container">
    <form class="table-form" method="post" action="">
    <h1> List of Users </h1>
    <div style="color:red">
      <?php
       echo $users_error;
      ?>
    </div>
    <table>
            <tr>
                <td> <b> ID </b> </td>
                <td> <b> Name </b> </td>
                <td> <b> Login </b> </td>
                <td> <b> New Password </b> </td>
                <td> <b> Action </b> </td>
            </tr>
            <?php echo $users_list; ?>
        </table>
      </form>
  </div>
  <div class="insert-form">
  <h1> Add New Users </h1>
  <div style="color:red">
    <?php
     echo $insert_error;
    ?>
  </div>
  <form name = "add-form" method = "post" action ="" >
    <label class = "login-label"> Name: </label>
    <input type="text" name="login_name" class="login-input1"> <br>
    <label class = "login-label"> Login: </label>
    <input type="text" name="login_id" class="login-input1"> <br>
    <label class = "login-label"> Password: </label>
    <input type="password" name="password" class="login-input2"> <br>
    <input type="submit" value="Add User" name="addnew" class="login-submit">
  </form>
</div>
</body>
</html>
