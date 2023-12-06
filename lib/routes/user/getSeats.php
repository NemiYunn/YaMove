<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->getSeats($_POST['trpId'], $_POST['resDate']);

?>