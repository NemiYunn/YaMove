<?php
include_once("../../functions/section_function.php"); 
$sec = new Section();

$result = $sec->secFareUpdate($_POST['secOldFare'],$_POST['secNewFare']);
echo ($result);
?>