<?php
include_once("../../functions/bus_function.php");
//lets create an object from the Bus class 
$emp = new Buses();

$result = $emp->busUpdate($_POST['upBusId'],$_POST['upBusType'], $_POST['upBusGrade'], $_POST['upBusCategory'],
            $_POST['upBusSeats'], $_POST['upBusKms'], $_POST['upBusState']);
echo ($result);
?>