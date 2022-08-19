<!DOCTYPE html>
<html lang="en">
<!-- 
    using code example from 
    https://phpbuilder.com/read-csv-data-into-a-php-array/#:~:text=%20Read%20CSV%20Data%20into%20a%20PHP%20Array,we%20are%20ready%20to%20load%20the...%20More%20 
-->
<Title>Aquarium Shift Rotation</Title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Don Simard simard57@hotmail.com CC0260">
<link rel="shortcut icon" type="image/x-icon" href="/images/NA Logo.jpg">

<!-- sorttable.js is borrowed from https://kryogenix.org/code/browser/sorttable/ -->
<link rel="stylesheet" href="/css/LHVC.css">
<link rel="stylesheet" href="/css/navbar.css">

<body style="background-color: lightblue;">

<?php
  //ini_set('display_errors', 1);
  ini_set('allow_url_fopen', TRUE);
  ini_set('log_errors', 1);
  ini_set('error_log', 'ERROR.LOG');
  error_reporting(E_ALL);

  // Associative array to expand abbreviations in CSV to long names
  $expand = array(
      "IF"=>"Info Desk",
      "RF"=>"Rain Forest",
      "A"=>"Australia",
      "LS"=>"Living Seashore",
      "BT"=>"Black Tip Reef",
      "3"=>"3rd Floor",
      "4"=>"4th Roam",
      "UV"=>"BTR Underwater",
      "2"=>"2nd Floor",
      "J"=>"Jellies",
      "R"=>"Roam"
    );
  $Day = array(
    "Mon"=>"Monday",
    "Tues"=>"Tuesday",
    "Wed"=>"Wednesday",
    "Thurs"=>"Thursday",
    "Fri"=>"Friday",
    "Sat"=>"Saturday",
    "Sun"=>"Sunday",
    "Test"=>"TestDay"
  );

  // gather selection from calling webpage.
  $noGuides = $_GET["Guides"];     // NoGuides is the number of Exhibit Guides
  $rotation = $_GET["Rotation"];   // rotation is the rotation assigned to user
  $rotations = $_GET["Rotations"]; // Show All or just One Rotation
  $day = $_GET["Day"];
  $shift = $_GET["Shift"];
  $schedule = $day."/".$shift."/Schedule.csv"; // create path to shift schedule selection
  $thisDay = $Day[$day];

  // Read the spreadsheet CSV used to list assignments
  // snippet from spreadsheet
  // Guides,A,B,C,D,E,F,G,H,I,J
  // 3,A-IF-RF-A,RF-A-IF-RF,IF-RF-A-IF,,,,,,,
  // 4,A-LS-IF-RF,LS-IF-RF-A,IF-RF-A-LS,RF-A-LS-IF,
  // ... ... 
  // .., ...
  //
  // 1st row is a header
  // 1st column is the number of volunteers on shift
  // row contains rotations. there are 4 shift assignments per cell per volunteer
  $csv = file_get_contents("$schedule", FILE_USE_INCLUDE_PATH);
  $lines = explode(PHP_EOL, $csv);

  // the first row from the CSV is header for the file.
  $head = str_getcsv(array_shift($lines));

  // $data will be an associative array indexed by # volunteers and Shift rotation
  $data = array();
  foreach ($lines as $line) {
    if (substr_count($line,"end") > 0) break;
    $data[] = array_combine($head, str_getcsv($line));
}
?>

<h1>National Aquarium Shift Rotation</h1>
<h2><?php echo $thisDay. " ". $shift ?> Shift</h2>
<h3>Number of Guides: <?php echo ($noGuides+3); ?> <br>
Rotation: <?php echo ($rotation); ?> </h3> 

<?php
  // $shift will contain the cell including the rotation assigned for a volunteer.
  // for example, the rotation A for 3 Volunteers in example snippet above is "A-IF-RF-A" 
  // using the example, $shift will be a 4 element array with the elements A, IF, RF, A
  $shift = array();
  $shift = explode("-",$data[$noGuides][$rotation]);
?>

<!-- Display a table for a 4 shift rotation. -->
<table style="width:100%">
  <thead>
    <tr style="font-size: 2.5em">
      <th style="text-align:right">Shift</th>
      <th style="text-align:left">Location</th>
    </tr>
  </thead>
  <tbody>
    <tr style="font-size: 2em"> 
      <td style="text-align:right">First</td>
      <td style="text-align:left"> <?php echo $expand[$shift[0]]; ?> </td>
    </tr>
    <tr style="font-size: 2em">
      <td style="text-align:right">Second</td>
      <td style="text-align:left"><?php echo $expand[$shift[1]]; ?> </td>
    </tr>
    <tr style="font-size: 2em">
      <td style="text-align:right">Third</td>
      <td style="text-align:left"><?php echo $expand[$shift[2]]; ?> </td>
    </tr>
    <tr style="font-size: 2em">
      <td style="text-align:right">Fourth</td>
      <td style="text-align:left"><?php echo $expand[$shift[3]]; ?> </dr>
    </tr>
  </tbody>
</table>

<button onclick="goBack()" style="width: 25em;  height: 4em;">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>

<br> <br>
  <a href="https://photos.app.goo.gl/9BHVpWXa76RESzh58" target=showtell> 
    <button type="button"> Aquarium Animal Album<br>Show & Tell</button>
  </a>

<?php
  if($rotations=="All") {
    //User hit the All Rotations button, handle accordingly
    // $Rot will contain the cell including the rotation assigned for a volunteer.
    // for example, the rotation A for 3 Volunteers in example snippet above is "A-IF-RF-A" 
    // using the example, $Rot will be a 4 element array with the elements A, IF, RF, A

    echo '<h3> All Rotations: </h3>'.PHP_EOL;
    echo '<table style="width:100%">'.PHP_EOL;
    echo '  <thead>'.PHP_EOL;
    echo '    <tr style="font-size: 2.5em">'.PHP_EOL;
    echo '      <th style="text-align:right">Guide</th>'.PHP_EOL;
    echo '      <th style="text-align:left">Location</th>'.PHP_EOL;
    echo '    </tr>'.PHP_EOL;
    echo '  </thead>'.PHP_EOL;
    echo '  <tbody>'.PHP_EOL;

    $Rot = array();
    for ($i=1; $i<=$noGuides+3; $i++)
    {
      $Rot = explode("-", $data[$noGuides][$head[$i]]);
      echo '<tr style="font-size: 2em">'.PHP_EOL;
        echo '<td style="text-align:right">'. $head[$i]. '</td>'.PHP_EOL; 
        echo '<td style="text-align:left" >'. $expand[$Rot[0]]. '</td>'.PHP_EOL;
      echo '</tr>'.PHP_EOL;
      echo '<tr style="font-size: 2em">'.PHP_EOL;
        echo '<td style="text-align:right"></td>'.PHP_EOL;
        echo '<td style="text-align:left">'. $expand[$Rot[1]]. '</td>'.PHP_EOL;
      echo '</tr>'.PHP_EOL;
      echo '<tr style="font-size: 2em">'.PHP_EOL;
        echo '<td style="text-align:right"></td>'.PHP_EOL;
        echo '<td style="text-align:left">'. $expand[$Rot[2]]. '</td>'.PHP_EOL;
      echo '</tr>'.PHP_EOL;
      echo '<tr style="font-size: 2em">'.PHP_EOL;
        echo '<td style="text-align:right"></td>'.PHP_EOL;
        echo '<td style="text-align:left">'. $expand[$Rot[3]]. '</td>'.PHP_EOL;
      echo '</tr>'.PHP_EOL;
    }
    echo '  </tbody>'.PHP_EOL;
    echo '</table>'.PHP_EOL;
//  include("All.php"); 
  }
?>

</body>
</html>
