<?php
include_once("../../../functions/driver_function.php");

$drv = new Driver();
$drv -> confirmDuty($_POST['aid']);

?>