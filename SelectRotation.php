<!DOCTYPE html>
<html lang="en">
<Title>Aquarium Shift Rotation</Title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Don Simard simard57@hotmail.com CC0260">
<link rel="shortcut icon" type="image/x-icon" href="/images/NA Logo.jpg">

<link rel="stylesheet" href="/css/LHVC.css">
<link rel="stylesheet" href="/css/navbar.css">

<?php
    $Day = array(
        "Mon"=>"Monday",
        "Tues"=>"Tuesday",
        "Wed"=>"Wednesday",
        "Thurs"=>"Thursday",
        "Fri"=>"Friday",
        "Sat"=>"Saturday",
        "Sun"=>"Sunday",
        "Test"=>"Testday"
    );

    $shift = $_GET["Shift"];
    $day = $_GET["Day"];
    $thisDay = $Day[$day];
?>
<body style="background-color: lightblue;">
    <h1>National Aquarium Shift Rotation</h1>
    <h2><?php echo $thisDay. " ". $shift ?> Shift</h2>
    <h3>Enter information Captain assigns</h2>
    <form action=ShowRotation.php method="get">
        <table style="table-layout: auto;">
            <thead>
            <tr> 
                <td class="right"><strong></strong></td>
                <td class="left"><strong></strong></td>
            </thead>
            <tbody>
                <tr style="font-size: 2.5em" class="left">
                    <td class="right"> # of Guides </td>
                    <td> <select name="Guides" style="font-size: 1em">
                            <option value="0">3</option>
                            <option value="1">4</option>
                            <option value="2">5</option>
                            <option value="3">6</option>
                            <option value="4">7</option>
                            <option value="5">8</option>
                            <option value="6">9</option>
                            <option value="7">10</option>
                        </select>
                    </td>
                </tr>
                <tr style="font-size: 2.5em" class="left">
                    <td class="right"> Rotation </td>
                    <td> <select name="Rotation" style="font-size: 1em">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="Day"       value="<?php echo $day; ?>" >
        <input type="hidden" name="Shift"     value="<?php echo $shift; ?>" >
<!--
            <input type="submit" name="Rotations" value="One" style="width: 20em;  height: 2em;"> <br>
-->
        <input type="submit" name="Rotations" value="All"  style="width: 20em;  height: 4em;">
    </form>
</body>
</html>
