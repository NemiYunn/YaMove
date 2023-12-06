<?php

include_once('../../functions/sk_function.php');

//lets create an object from the Emp class 
$stock = new Stock();

$result = $stock ->rfq($_POST['partNo'],$_POST['Rqty'],$_POST['Ldate']);
echo($result);
?>