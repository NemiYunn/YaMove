<?php
include_once("../../functions/sk_function.php");

$sk = new Stock();
// key is pass from the viewEmp
$res = $sk->actDeactCat($_POST['catNo']);
echo($res);
?>