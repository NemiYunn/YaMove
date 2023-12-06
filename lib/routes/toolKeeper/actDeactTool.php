<?php
include_once("../../functions/tk_function.php");

$tk = new Tool();
// key is pass from the viewEmp
$res = $tk->actDeactTool($_POST['Id']);
echo($res);
?>