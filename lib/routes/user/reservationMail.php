<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->reservationMail($_POST['trpId'],$_POST['from'],$_POST['to'],
$_POST['boarding'],$_POST['dropping'],$_POST['resDate'],$_POST['NoofPassengers'],
$_POST['totFare'],$_POST['seatArray'],$_POST['refNo'],$_POST['busNo'],
$_POST['dep'],$_POST['arr']);

echo($result);
?>