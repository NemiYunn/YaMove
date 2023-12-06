<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->seatPlan($_POST['seatArray'],$_POST['trpId'], $_POST['resDate']);

?>