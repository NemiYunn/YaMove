<?php
include_once("../../functions/tk_function.php");
//lets create an object from the Bus class 
$tk = new Tool();

$result = $tk->toolUpdate($_POST['id'],$_POST['Uname'],$_POST['Udes']);
echo ($result);
?>