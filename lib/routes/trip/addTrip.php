<?php

include_once('../../functions/trip_function.php');

//lets create an object from the class 
$trip = new trip();

$result = $trip ->addNewTrip($_POST['depFrom'],$_POST['depAt'],$_POST['arrTo'],$_POST['arrAt'],$_POST['schNo']);
echo($result);
?>