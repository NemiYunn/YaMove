<?php
include_once("../../functions/sk_function.php");
//lets create an object from the Bus class 
$sk = new Stock();

$result = $sk->catUpdate($_POST['updCatNo'],$_POST['upCatDes']);
echo ($result);
?>