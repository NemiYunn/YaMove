<?php
include_once("../../functions/user_function.php");

$shRt = new User();
$res = $shRt -> searchRoute();
echo($res);
?>