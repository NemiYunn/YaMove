<?php
include_once("../../functions/halt_function.php");
//lets create an object from the Bus class 
$hlt = new Halts();

$result = $hlt->addNewHalt($_POST['hltName'],$_POST['hltDis'],$_POST['secNo'],$_POST['rtId']);
echo ($result);
?>