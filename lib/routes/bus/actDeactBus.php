<?php
include_once("../../functions/bus_function.php");

$bus = new Buses();
// key is pass from the viewEmp
$res = $bus->actDeactBus($_POST['busId']);
echo($res);
?>