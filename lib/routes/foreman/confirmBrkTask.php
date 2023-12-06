<?php
include_once("../../functions/fmn_function.php"); 
$fmn = new Foreman();

$result = $fmn->confirmBrkTask($_POST['baId']);
echo ($result);
?>