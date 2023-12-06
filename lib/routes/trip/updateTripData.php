<?php
include_once("../../functions/trip_function.php"); 
$trp = new Trip();

$result = $trp->tripUpdate($_POST['trpUpId'],$_POST['depFromUp'], $_POST['depAtUp'], $_POST['arrToUp'], $_POST['arrAtUp'],$_POST['schNo']);
echo ($result);
?>