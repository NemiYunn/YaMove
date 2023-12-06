<?php

include_once('../../functions/tk_function.php');

//lets create an object from the Emp class 
$tool = new Tool();

$result = $tool ->addNewTool($_POST['name'],$_POST['des'],$_POST['qty']);
echo($result);
?>