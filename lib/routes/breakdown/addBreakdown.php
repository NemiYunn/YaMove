<?php

include_once('../../functions/brk_function.php');

//lets create an object from the Emp class 
$brk = new Breakdown();

$result = $brk ->addBreakdown($_POST['issue']);
echo($result);
?>