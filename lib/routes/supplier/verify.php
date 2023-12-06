<?php
include_once("../../functions/supplier_function.php");

$sup = new Supplier();
// key is pass from the viewEmp
$result = $sup->verifyEmail($_POST['email'],$_POST['vcode']);
echo ($result);
?>