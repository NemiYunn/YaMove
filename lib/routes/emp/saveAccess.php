<?php
include_once("../../functions/emp_function.php");

if(isset($_POST['toggleActive'])){
    // if the toggle button state is active
    $emp = new EmpProcess();
    $status=1;
    $result= $emp-> changeLoginAccess($_POST['empId'],$_POST['empRole'],$_POST['empName'],$_POST['empEmail'],$_POST['empPwd'],$_POST['EmpLicense'],$status);
    echo($result);
}else{
    // toggle button unchecked(deactive)
    $emp = new EmpProcess();
    $status=0;
    $result=$emp-> changeLoginAccess($_POST['empId'],$_POST['empRole'],$_POST['empName'],$_POST['empEmail'],$_POST['empPwd'],$_POST['empLicense'],$status);
    echo($result);
}

?>