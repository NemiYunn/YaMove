<?php
include_once("../../functions/tcn_function.php");

$tcn = new Tech();
// key is pass from the viewBus
$tcn->endBrkWorking($_POST['assignedId'],$_POST['completionMessage']);
?>