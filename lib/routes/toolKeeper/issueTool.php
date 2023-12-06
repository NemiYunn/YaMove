<?php

include_once('../../functions/tk_function.php');

//lets create an object from the Emp class 
$tk = new Tool();

$result = $tk ->issueTool($_POST['tlId'],$_POST['emp'],$_POST['qty']);
echo($result);
?>