<?php

include_once('../../functions/section_function.php');

//lets create an object from the class 
$sec = new Section();

$result = $sec ->addNewSection($_POST['secNo'],$_POST['secFare']);
echo($result);
?>