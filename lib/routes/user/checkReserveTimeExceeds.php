<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->checkReserveTimeExceeds($_POST['trpId'],$_POST['date']);

?>