<?php
include_once("../../../functions/report_function.php");

$rp = new Report();
$rp -> reservationIncomeReport($_POST['stdate'],$_POST['endate']);

?>