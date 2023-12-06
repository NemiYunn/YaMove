<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->makeReservation($_POST['trpId'],$_POST['resDate'], $_POST['NoofPassengers'],$_POST['totFare'],$_POST['seatArray']);

?>