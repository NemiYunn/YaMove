<?php

include_once('../../functions/schedule_function.php');

//lets create an object from the class 
$schedule = new schedules();

$result = $schedule ->addNewSchedule($_POST['rtNo'],$_POST['schNo'],$_POST['busNo'],$_POST['stTime'],$_POST['endTime'], $_POST['ntStay']);
echo($result);
?>