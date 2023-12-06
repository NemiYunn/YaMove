<?php
include_once("../../../functions/notification_function.php");

$nt = new Notification();
$res = $nt -> reservationCount();
echo($res);
?>