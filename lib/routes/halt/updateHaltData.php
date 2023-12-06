<?php
include_once("../../functions/halt_function.php");
//lets create an object from the Bus class 
$hlt = new Halts();

$result = $hlt->haltUpdate($_POST['rtId'],$_POST['hltUpId'],$_POST['hltUpName'], $_POST['hltUpDis'], $_POST['secUpNo']);
echo ($result);
?>