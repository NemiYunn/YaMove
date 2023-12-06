<?php
include_once("../../functions/schedule_function.php");

$sch = new schedules();
$res = $sch->actDeactSchedule($_POST['schId']);
echo ($res);
?>