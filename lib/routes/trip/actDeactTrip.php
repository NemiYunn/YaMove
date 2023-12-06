<?php
include_once("../../functions/trip_function.php");

$trp = new Trip();
$res = $trp->actDeactTrip($_POST['trpId'],$_POST['schNo']);
echo $res;
?>