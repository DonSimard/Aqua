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

<link rel="stylesheet" href="/css/LHVC.css">
<link rel="stylesheet" href="/css/navbar.css">

<!-- Include from the CDN -->
<!-- see https://www.geeksforgeeks.org/how-to-take-screenshot-of-a-div-using-javascript/#:~:text=1%20Create%20a%20blank%20HTML%20document.%202%20Include,handler%20for%20the%20button.%20...%20More%20items...%20 -->

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"> </script>

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
$noGuides = $_POST["Guides"];     // Guides is the number of Exhibit Guides
$rotation = $_POST["Rotation"];   // Rotation is the rotation assigned to app user

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
<div id="ShiftRotation">
  <h1>Schedule Rotation</h1>
  <h2>Number of Guides: <?php echo ($noGuides+3); ?> <br>
  Rotation: <?php echo ($rotation); ?> </h2> 

  <?php

  // $shift will contain the cell including the rotation assigned for a volunteer.
  // for example, the rotation A for 3 Volunteers in example snippet above is "A-IF-RF-A" 
  // using the example, $shift will be a 4 element array with the elements A, IF, RF, A
  $shift = array();
  $shift = explode("-",$data[$noGuides][$rotation]);
  ?>

  <!-- 
    Display a table for 4 shifts.
  -->
  <table style="width:100%">
    <tr style="font-size: 2.5em">
      <th style="text-align:right">Shift</th>
      <th style="text-align:left">Location</th>
    </tr>
    <tr style="font-size: 2em"> 
      <td style="text-align:right">First</td>
      <td style="text-align:left"> <?php echo $expand[$shift[0]]; ?> </td>
    <tr style="font-size: 2em">
      <td style="text-align:right">Second</td>
      <td style="text-align:left"><?php echo $expand[$shift[1]]; ?> </td>
    <tr style="font-size: 2em">
      <td style="text-align:right">Third</td>
      <td style="text-align:left"><?php echo $expand[$shift[2]]; ?> </td>
    </tr>
    <tr style="font-size: 2em">
      <td style="text-align:right">Fourth</td>
      <td style="text-align:left"><?php echo $expand[$shift[3]]; ?> </dr>
    </tr>
  </table>
  <!-- Define the button 
        that will be used to 
        take the screenshot -->
        <button onclick="takeshot()">
            Take Screenshot
        </button>
</div>
<h1>Screenshot:</h1>
    <div id="output"></div>
  
    <script type="text/javascript">
  
        // Define the function 
        // to screenshot the div
        function takeshot() {
            let div =
                document.getElementById('ShiftRotation');
  
            // Use the html2canvas
            // function to take a screenshot
            // and append it
            // to the output div
            html2canvas(div).then(
                function (canvas) {
                    document
                    .getElementById('output')
                    .appendChild(canvas);
                })
        }
    </script>
  
<button onclick="goBack()" style="width: 20em;  height: 2em;">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>

</body>
</html>
