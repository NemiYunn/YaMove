<?php

include_once('../../functions/sk_function.php');

//lets create an object from the Emp class 
$stock = new Stock();

$result = $stock ->restockItem($_POST['parts'],$_POST['qty'],$_POST['price']);
echo($result);
?>