<?php
include_once("../../../functions/report_function.php");

$rp = new Report();
$rp -> lateReturns($_POST['stdate'],$_POST['endate']);

?>