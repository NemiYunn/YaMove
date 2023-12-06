<?php

include_once('../../functions/user_function.php');
// include_once('../../functions/mail.php');

//lets create an object from the Emp class 
 $user = new User();
// $mailer = new MyClass();

    $uname = $_POST['userName'];
    $vcode =sha1($uname.time());
    $vUrl='http://localhost/yamove/lib/views/user.php?username='.$uname.'&&code='.$vcode.'&&md=true';


    $sub = 'Verify Email Address';
    $fullName = $_POST['title'].$_POST['fName']." ".$_POST['lName'];
    $vMsg = $sub.'<br><p>Dear '.$fullName. '</p><p>Thank you for signing up. There is one more step. Click below link to
    verify your email address in order to activate your account.</p><p><a href="' . $vUrl . '">Click here</a></p> <p>Thank You.</p>
    <p>SLTB Ududumbara</p>';

$result = $user ->userReg($_POST['title'],$_POST['fName'],$_POST['lName'],$_POST['nic'],$_POST['mobileNum'],$uname,$_POST['userPwd'],$_POST['userComPwd'],$vcode);
echo($result);
$res = $user -> sendMail($vMsg,$uname);
echo($res);

?>