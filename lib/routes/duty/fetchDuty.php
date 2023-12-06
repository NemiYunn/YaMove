<?php

include_once("../../functions/duty_function.php");

$dt = new Duty();
$dt->fetchDuty($_POST['dId']);

?>