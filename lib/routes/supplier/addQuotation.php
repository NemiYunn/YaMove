<?php

include_once('../../functions/supplier_function.php');

//lets create an object from the Emp class 
$sup = new Supplier();

$result = $sup ->addQuotation($_POST['rfqNo'],$_POST['uPrice']);
echo($result);
?>