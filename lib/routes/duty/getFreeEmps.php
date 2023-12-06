<?php
include_once("../../functions/duty_function.php");

$dt = new Duty();
$rec =$dt->getFreeEmps($_POST['dId']);
echo($rec);
?>