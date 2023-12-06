<?php
// Assuming you have the function try() defined in the Report class
include_once("../../../functions/report_function.php");

$rp = new Report();
// Call the try() method to retrieve category-wise issue data
$data = $rp->costOfCats($_POST['stdateC'],$_POST['endateC']);

// Set the appropriate Content-Type header to indicate JSON response
header('Content-Type: application/json');

// Output the JSON data
echo json_encode($data);
?>
