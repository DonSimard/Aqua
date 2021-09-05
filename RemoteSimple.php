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

<body>

<script>
function goBack() {
  window.history.back();
}
</script>

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

        function get_content($URL){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $URL);
          $data = curl_exec($ch);
          curl_close($ch);
          return $data;
      }
  
//      $file = get_content('https://docs.google.com/spreadsheets/d/e/2PACX-1vTFGIDX5n1l0xRbdoHMUUBHvk9RbKn9U0DrbDZVguT2uAYrox4uIjjpFv_mftfnKojuaeRGSJH__yId/pubhtml');
//      echo ($file);
  

$noGuides = $_POST["Guides"];
$rotation = $_POST["Rotation"];

// $csv = file_get_contents('https://drive.google.com/file/d/19AJaULPwfzkO_C0G7Kn_Es_vH4UreH3t/view?usp=sharing', FILE_USE_INCLUDE_PATH);
$csv = get_content('https://docs.google.com/spreadsheets/d/e/2PACX-1vTFGIDX5n1l0xRbdoHMUUBHvk9RbKn9U0DrbDZVguT2uAYrox4uIjjpFv_mftfnKojuaeRGSJH__yId/pub?gid=662842275&single=true&output=csv');
echo ($csv);
// $csv = get_content('https://docs.google.com/spreadsheets/d/e/2PACX-1vTFGIDX5n1l0xRbdoHMUUBHvk9RbKn9U0DrbDZVguT2uAYrox4uIjjpFv_mftfnKojuaeRGSJH__yId/pubhtml');
$lines = explode(PHP_EOL, $csv);

//remove the first element from the array
$head = str_getcsv(array_shift($lines));

$data = array();
foreach ($lines as $line) {
  $data[] = array_combine($head, str_getcsv($line));
}
?>

<h1>Schedule Rotation</h1>
<h2>Number of Guides: <?php echo ($noGuides+3); ?> <br>
Rotation: <?php echo ($rotation); ?> </h2> 

<?php 
$shift = array();
$shift = explode("-",$data[$noGuides][$rotation]);
?>

<table style="width:100%">
  <tr style="font-size: 2.5em">
    <th style="text-align:right">Shift</th>
    <th style="text-align:left">Location</th>
  </tr>
  <tr style="font-size: 2em"> 
    <td style="text-align:right">0900-1000</td>
    <td style="text-align:left"> <?php echo $expand[$shift[0]]; ?> </td>
  <tr style="font-size: 2em">
    <td style="text-align:right">1000-1100</td>
    <td style="text-align:left"><?php echo $expand[$shift[1]]; ?> </td>
  <tr style="font-size: 2em">
    <td style="text-align:right">1100-1200</td>
    <td style="text-align:left"><?php echo $expand[$shift[2]]; ?> </td>
  </tr>
  <tr style="font-size: 2em">
    <td style="text-align:right">1200-1300</td>
    <td style="text-align:left"><?php echo $expand[$shift[3]]; ?> </dr>
  </tr>
</table>

<button onclick="goBack()">Go Back</button>

</body>
</html>
