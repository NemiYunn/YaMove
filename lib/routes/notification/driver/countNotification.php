<?php
include_once("../../../functions/notification_function.php");

$nt = new Notification();
$res = $nt -> drvNotification();
echo($res);
?>