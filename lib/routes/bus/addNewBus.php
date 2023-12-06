<?php

include_once('../../functions/bus_function.php');

//lets create an object from the Emp class 
$bus = new Buses();

$result = $bus ->addNewBus($_POST['busNo'],$_POST['busType'],$_POST['busGrade'],$_POST['busCatag'],$_POST['busSeats'],$_POST['busKms'],$_POST['busState']);
echo($result);
?>