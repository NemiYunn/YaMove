<?php
include_once("../../functions/trip_function.php");

$trp = new Trip();
// key is pass from the viewBus
$trp->searchTripData();
?>