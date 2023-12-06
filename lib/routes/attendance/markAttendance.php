<?php

include_once('../../functions/attendance_function.php');

//lets create an object from the Emp class 
$att = new Attendance();

$result = $att ->markAttendance($_POST['nic']);
echo($result);
?>