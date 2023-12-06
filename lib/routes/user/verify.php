<?php
include_once("../../functions/user_function.php");

$usr = new User();

$result = $usr->verifyEmail($_POST['email'],$_POST['vcode']);
echo ($result);
?>