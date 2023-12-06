<?php
include_once('../../functions/supplier_function.php');
// include_once('../../functions/mail.php');

// Create an object from the Emp class 
$sup = new Supplier();
// $mailer = new MyClass();

$uname = $_POST['userName'];
$vcode = sha1($uname.time());
$vUrl = 'http://localhost/yamove/lib/views/RFQ.php?username=' . urlencode($uname) . '&&code=' . urlencode($vcode) . '&&md=true';

$sub = 'Verify Email Address';
$fullName = $_POST['bName'];
$vMsg = $sub . '<br><p> ' . $fullName . '</p><p>Thank you for signing up. There is one more step. 
    Click below link to verify your email address in order to activate your account.</p>
    <p><a href="' . $vUrl . '">Click here</a></p>
    <p>Thank You.</p>
    <p>SLTB Ududumbara</p>';

$result = $sup->userReg($_POST['bName'], $_POST['add'], $_POST['mobileNum'], $uname, $_POST['userPwd'], $vcode);
echo ($result);
$res = $sup->sendMail($vMsg, $uname);
echo ($res);
?>
