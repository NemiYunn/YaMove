<?php

include_once("../../functions/emp_function.php");

//lets create an object from the Emp class 
$emp = new EmpProcess();

$fileName = $_FILES['editProfilePic']['name'];
$tmpFile = $_FILES['editProfilePic']['tmp_name'];

$result = $emp->empUpdate($_POST['editId'], $_POST['editName'], $_POST['editEmail'], $_POST['editPhone'], $_POST['gender'], $fileName, $tmpFile);
echo ($result);


?>
