<?php


// subject
$sub = "abanwa005@gmail";
// the message
$msg = "Hi this is abanwa. checking sendmail on xampp";
// recipient email here
$rec = "abanwachinaza@gmail.com";
//send mail
if(mail($rec,$sub,$msg)){
	echo "Sent";
} else {
	echo "Failed";
}







?>