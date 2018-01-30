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
  <title> My Calendar </title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfSX27yYwMAryvmtCK5xzITz1X25FQ6bw&callback=initMap&libraries=places">
  </script>
    <script src="calendar.js"> </script>
</head>
<body>
  <div class="centre">
    <h2> My Calendar </h2>
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
  <div class="calendar-contents">
  <?php>
      $file = "calendar.txt";
      if (file_exists($file)) {
        echo '<table id="table-div">';
        $events = json_decode(file_get_contents($file),true);
        if (!isset($events)) {
          exit();
        }
        $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        for ($i = 0; $i<=4; $i++) {
          $day = $days[$i];
          if (isset ($events[$day])) {
            echo '<tr class="row-'.$i;
            echo '">';
            echo  '<td> <b>';
            echo $day;
            echo '</b> </td>';
            foreach ($events[$day] as $de) {
              echo '<td><p class="time-style">';
              echo $de['starttime'];
              echo ' - ';
              echo $de['endtime'];
              echo '</p>';
              echo '<p class="location-style data-value">';
              echo $de['eventname'];
              echo ' - <span class="location-markers">';
              echo $de['location'];
              echo '</span> </p> </td>';
            }
            echo '</tr>';
          }
        }
            echo '</table>';
            }
      else {
        echo '<br><div style="color:red">Calendar has no events. Please use the form page to enter some events.</div><br>';
}
?>
  </div>
<div id="search-form">
    <form name="search">
      <label> Radius: </label>
      <input type="number" name="radius" value="500" max="50000">
      <input type="button" value="Find Nearby Restaurant" onclick="findPlaces()">
    </form>
    <form name="directions" id="direction">
      <label> Destination: </label>
      <input type="text" name="destination">
      <input type="button" value="Get Directions" onclick="locate_Direction()"> <br>
      <input type="radio" name="mode"  value="WALKING"> Walking
      <input type="radio" name="mode"  value="DRIVING"> Driving
      <input type="radio" name="mode"  value="TRANSIT"> Transit
      <input type="radio" name="mode"  value="BICYCLING"> Bicycling
    </form>
</div>
<div class="centring">
<div id="right-panel"> </div>
<div id="map"></div>
</div>
</body>
</html>
