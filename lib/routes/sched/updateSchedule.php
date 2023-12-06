<?php
include_once("../../functions/schedule_function.php"); 
$sch = new schedules();

$result = $sch->scheduleUpdate($_POST['upSchId'],$_POST['busUpNo'],$_POST['stTimeUp'], $_POST['endTimeUp'], $_POST['ntStayUp']);
echo ($result);
?>