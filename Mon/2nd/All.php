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
<link rel="shortcut icon" type="image/x-icon" href="NA Logo.jpg">

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
$expand = array("IF"=>"Info Desk",
				"RF"=>"Rain Forest",
				"A"=>"Australia",
				"LS"=>"Living Seashore",
				"BT"=>"Black Tip Reef",
				"3"=>"3rd Floor",
				"4"=>"4th Roam",
				"UV"=>"BTR Underwater",
				"2"=>"2nd Floor",
				"J"=>"Jellies",
				"R"=>"Roam");

// gather selection from calling webpage.
$noGuides = $_POST["Guides"];     // NoGuides is the number of Exhibit Guides
$rotation = $_POST["Rotation"];   // rotation is the rotation assigned to user (A, B, C, ...)

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
$csv = file_get_contents('Schedule.csv', FILE_USE_INCLUDE_PATH);
$lines = explode(PHP_EOL, $csv);

// the first row from the CSV is header for the file.
$head = str_getcsv(array_shift($lines));

// $data will be an associative array indexed by # volunteers and Shift rotation
$data = array();
foreach ($lines as $line) {
  $data[] = array_combine($head, str_getcsv($line));
}
?>

<!--
<h1>National Aquarium Shift Rotation</h1>
<h2>Tuesday 1st Shift</h2>
<h3>Number of Guides: <?php echo ($noGuides+3); ?> </h3>
-->

<h3> All Rotations: </h3> 

<!-- Display a table for a 4 shift rotation. -->
<table style="width:100%">
  <tr style="font-size: 2.5em">
    <th style="text-align:right">Guide</th>
    <th style="text-align:left">Location</th>
  </tr>

  <?php
  
// $shift will contain the cell including the rotation assigned for a volunteer.
// for example, the rotation A for 3 Volunteers in example snippet above is "A-IF-RF-A" 
// using the example, $shift will be a 4 element array with the elements A, IF, RF, A
  $shift = array();
  for ($i=1; $i<=$noGuides+3; $i++)
  {
    $shift = explode("-", $data[$noGuides][$i]);
    $shift = explode("-", $data[$noGuides][$head[$i]]);
    echo '<tr style="font-size: 2em">';
      echo '<td style="text-align:right">'. $head[$i]. '</td>'; 
      echo '<td style="text-align:left" >'. $expand[$shift[0]]. '</td>';
    echo '</tr>';
    echo '<tr style="font-size: 2em">';
      echo '<td style="text-align:right"></td>';
      echo '<td style="text-align:left">'. $expand[$shift[1]]. '</td>';
    echo '</tr>';
    echo '<tr style="font-size: 2em">';
      echo '<td style="text-align:right"></td>';
      echo '<td style="text-align:left">'. $expand[$shift[2]]. '</td>';
    echo '</tr>';
    echo '<tr style="font-size: 2em">';
      echo '<td style="text-align:right"></td>';
      echo '<td style="text-align:left">'. $expand[$shift[3]]. '</td>';
    echo '</tr>';
  }
  ?>
</table>

<!--
<button onclick="goBack()" style="width: 20em;  height: 2em;">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
-->

</body>
</html>
