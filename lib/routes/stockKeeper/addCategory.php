<?php

include_once('../../functions/sk_function.php');

//lets create an object from the Emp class 
$stock = new Stock();

$result = $stock ->addNewCategory($_POST['catNo'],$_POST['catDes']);
echo($result);
?>