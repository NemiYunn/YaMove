<?php

include_once('../../functions/tk_function.php');

//lets create an object from the Emp class 
$tk = new Tool();

$result = $tk ->fillTool($_POST['rtlId'],$_POST['up'],$_POST['Fqty']);
echo($result);
?>