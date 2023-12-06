<?php
include_once("../../functions/sk_function.php"); 
$sk = new Stock();

$result = $sk->getRfqItemNo($_POST['rId']);

?>