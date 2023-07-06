<?php

ini_set("display_errors", 1);

require_once("mail.php");

$from = "support.mts-ibm@nic.in"; // example: testemail@domain.com

$to = "support.mts-ibm@nic.in"; // example: testemail@domain.com

$subject = " Text from PHP code through HostName";

$msg = " Sample Message Body  ";

$res = send_mail($from, $to, $subject, $msg);

if($res){
echo " send mail result is ".$res;
}
else
{
echo "Something went wrong. please try again.";
}

?>