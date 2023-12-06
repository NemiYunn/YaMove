<?php
include_once("../../functions/fmn_function.php"); 
$fmn = new Foreman();

$result = $fmn->asignMntTechnician($_POST['tech'],$_POST['mntId']);
echo ($result);
?>