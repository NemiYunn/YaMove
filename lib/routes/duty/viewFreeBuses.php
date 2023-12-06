<?php
include_once("../../functions/duty_function.php");

$dt = new Duty();
$res = $dt -> viewFreeBuses($_POST['dId']);

?>