<?php
include_once("../../functions/route_function.php"); 
$rt = new Routes();

$result = $rt->routeUpdate($_POST['rtUpId'],$_POST['rtUpNo'], $_POST['rtUpStarts'],
            $_POST['rtUpEnds'], $_POST['rtUpDes']);
echo ($result);
?>