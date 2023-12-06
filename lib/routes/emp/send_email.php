<?php

include_once("../../functions/emp_function.php");

//lets create an object from the Emp class 
$emp = new EmpProcess();

$result = $emp->sendEmail($_POST['empId'],$_POST['empRole'],$_POST['empName'],$_POST['empEmail'],$_POST['empPwd']);
echo ($result);


?>