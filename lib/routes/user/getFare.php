<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->getTotFare($_POST['boarding'],$_POST['dropping'],$_POST['NoofPassengers']);

?>