<?php
include_once("../../functions/tcn_function.php");

$tcn = new Tech();
// key is pass from the viewBus
$tcn->startBrkWorking($_POST['assignedId']);
?>