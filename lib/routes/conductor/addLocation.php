<?php
include_once("../../functions/conductor_function.php");

$con = new Conductor();
$res = $con -> addLocation($_POST['hlt']);
echo($res);

?>