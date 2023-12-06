<?php
include_once("../../functions/roster_function.php");

$ros = new Roster();
$res = $ros->deleteRoster($_POST['rosId']);
echo $res;
?>