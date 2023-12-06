<?php

include_once('../../functions/route_function.php');

//lets create an object from the Emp class 
$route = new Routes();

$result = $route ->addNewRoute($_POST['rtNo'],$_POST['rtStarts'],$_POST['rtEnds'],$_POST['rtDes']);
echo($result);
?>