<?php
include_once("../../functions/user_function.php");

$shRt = new User();
$res = $shRt -> searchRouteTo();
echo($res);
?>