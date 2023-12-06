<?php
include_once("../../functions/route_function.php");

$rt = new Routes();
$res = $rt->actDeactRoute($_POST['rtId']);
echo $res;
?>