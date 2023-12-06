<?php
include_once("../../functions/emp_function.php");

$emp = new EmpProcess();
// key is pass from the viewEmp
$emp->tempActiveDeactive($_POST['empId']);
?>