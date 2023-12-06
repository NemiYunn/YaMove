<?php
include_once("../../functions/sk_function.php");
//lets create an object from the Bus class 
$sk = new Stock();

$result = $sk->itemUpdate($_POST['upcats'],$_POST['uppartNo'],$_POST['updes'],$_POST['uptype']
,$_POST['upunit'],$_POST['uplevel']);
echo ($result);
?>