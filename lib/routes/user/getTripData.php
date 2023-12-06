<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->showTripData($_POST['from'],$_POST['to'], $_POST['date']);

?>