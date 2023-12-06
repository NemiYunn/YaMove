<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->getHaltsBoarding($_POST['from'],$_POST['to']);

?>