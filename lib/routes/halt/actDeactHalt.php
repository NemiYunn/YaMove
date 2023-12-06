<?php
include_once("../../functions/halt_function.php");

$hlt = new Halts();
$res = $hlt->actDeactHalt($_POST['hltId']);
echo($res);
?>