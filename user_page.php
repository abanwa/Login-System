<?php 


include "login_status.php";

if (!$login_key){
	header("location:login.php");
}


	echo "This Page is for {$_SESSION["name"]} only";
	echo "<br/>";
	echo "<a href='logout.php'>Logout</a>";


?>