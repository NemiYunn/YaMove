<?php

include_once('../../functions/userAuth.php');

$usrAuth = new UserAuthentication();
$result = $usrAuth->userLogin($_POST['username'], $_POST['userpwd']);
echo($result);

?>