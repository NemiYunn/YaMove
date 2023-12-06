<?php
include_once("../../functions/conductor_function.php");

$con = new Conductor();
$res = $con -> confirmReservation($_POST['id']);
echo($res);

?>