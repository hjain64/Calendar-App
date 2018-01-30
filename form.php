<?php>
session_start();
if ( !isset($_SESSION["id"]) && !isset($_SESSION["pwd"]) ){
  header('Location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Calendar Input </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="centre">
    <h1> Calendar Input </h1>
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
  <div class="calendar-form">
    <div style="color:red">
    <?php>
     $file = "calendar.txt";
     function sorting($a, $b) {
       return ($a['starttime'] - $b['starttime']);
     }
    if (isset($_POST['clear']))
    {
      unlink($file);
      header('Location: calendar.php');
    }
    if (isset($_POST['submit']))
    {
        $eventname = $_POST['eventname'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $location = $_POST['location'];
        $day = $_POST['day'];
        if (empty($eventname) || empty($starttime) || empty($endtime) || empty($location))
        {
        if ( empty($eventname) ) {
            echo 'Please provide a value for Event Name.' . '<br>';
        }
        if ( empty($starttime) ) {
            echo 'Please Select a value for Start Time.'. '<br>';
        }
        if ( empty($endtime) ) {
            echo 'Please enter a value for End Time.' . '<br>';
        }
        if ( empty($location) ) {
            echo 'Please enter a value for Events Location.' . '<br>';
        }
      }
        else {
            $json = json_decode(file_get_contents($file), true);
            if (array_key_exists($day, $json))
            { echo 'This double';
              $appendnewevent = array("eventname" => $eventname, "starttime" => $starttime, "endtime" => $endtime, "location" => $location);
              array_push($json[$day], $appendnewevent);
              usort($json[$day], "sorting");
            }
            else {
            $json[$day] = array(array("eventname" => $eventname, "starttime" => $starttime, "endtime" => $endtime, "location" => $location));
            }
            file_put_contents($file, json_encode($json));
            header('Location: calendar.php');
            }
      }
  ?> </div>
    <form name="add-events" method="post" action="">
      <label class="form-label"> Event Name </label>
      <input type="text" name="eventname" class="form-input" > <br>
      <label class="form-label"> Start Time </label>
      <input type="time" name="starttime" class="form-input" > <br>
      <label class="form-label"> End Time </label>
      <input type="time" name="endtime" class="form-input" > <br>
      <label class="form-label"> Location </label>
      <input type="text" name="location" class="form-input" > <br>
      <label class="form-label"> Day of the week </label>
      <select name="day" class="form-select" >
        <option value="Monday"> Mon </option>
        <option value="Tuesday"> Tue </option>
        <option value="Wednesday"> Wed </option>
        <option value="Thursday"> Thur </option>
        <option value="Friday"> Fri </option>
      </select> <br>
      <label class="form-label">
      <input type="submit" name="clear" value="Clear"> </label>
      <input type="submit" value="Submit" name="submit" class="form-submit">
    </form>
</div>
<script src="form.js"></script>
</body>
</html>
