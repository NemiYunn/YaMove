<?php

include_once('../../functions/sk_function.php');

//lets create an object from the Emp class 
$stock = new Stock();

$result = $stock ->issueItem($_POST['bus'],$_POST['qty'],$_POST['prtNo']);
echo($result);
?>