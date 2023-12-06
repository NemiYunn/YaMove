<?php

include_once('../../functions/sk_function.php');

//lets create an object from the Emp class 
$stock = new Stock();

$fileName = $_FILES['itmPic']['name'];
$tmpFile = $_FILES['itmPic']['tmp_name'];

$result = $stock ->addNewItem($_POST['cats'],$_POST['partNo'],$_POST['des'],$_POST['type'],$_POST['unit'],$_POST['level'], $fileName, $tmpFile);
echo($result);
?>