<?php
include_once("../../functions/supplier_function.php"); 
$sup = new Supplier();

$result = $sup->fetchDetails($_POST['rId']);

?>