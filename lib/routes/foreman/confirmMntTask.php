<?php
include_once("../../functions/fmn_function.php"); 
$fmn = new Foreman();

$result = $fmn->confirmMntTask($_POST['maId']);
echo ($result);
?>