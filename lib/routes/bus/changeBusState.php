<?php
include_once("../../functions/bus_function.php");

$bus = new Buses();
// key is pass from the viewEmp
$bus->changeBusState($_POST['busId'],$_POST['value']);
?>