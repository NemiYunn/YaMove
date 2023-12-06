
<?php
include_once("../../functions/duty_function.php");

$dt = new Duty();
$rec =$dt->saveChangedDuty($_POST['dId'],$_POST['newEmpId'],$_POST['newBusNo']);
echo($rec);

// $rec1 =$dt->saveChangedBusDuty($_POST['dId'],$_POST['newEmpId'],$_POST['newBusNo']);
// echo($rec1);


?>