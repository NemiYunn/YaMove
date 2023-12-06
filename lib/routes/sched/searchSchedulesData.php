<?php
include_once("../../functions/schedule_function.php");

$sch = new schedules();
// key is pass from the viewBus
$sch->searchScheduleData();
?>