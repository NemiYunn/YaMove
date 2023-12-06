<?php
include_once("../../functions/user_function.php"); 
$usr = new User();

$result = $usr->getHaltsDropping($_POST['from'],$_POST['to']);

?>