<?php
include_once("../../functions/roster_function.php");

$ros = new Roster();
// key is pass from the viewBus
$ros->searchRoster();
?>