<?php
include_once("../../functions/fmn_function.php"); 
$fmn = new Foreman();

$result = $fmn->asignTechnician($_POST['tech'],$_POST['brkId']);
echo ($result);
?>