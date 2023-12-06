<?php
include_once("../../../functions/reservation_function.php");

$reser = new Reservation();
$res = $reser -> confirmReservation($_POST['id']);
echo($res);
?>