<?php

session_start();

if (isset($_SESSION["id"]) AND isset($_SESSION["name"]) AND isset($_SESSION["email"]) AND isset($_SESSION["password"])){
	// for session
	session_destroy();
}
// for cookie
if (isset($_COOKIE["id"]) AND isset($_COOKIE["name"]) AND isset($_COOKIE["email"]) AND isset($_COOKIE["p"])){
		setcookie("id",$_COOKIE["id"],strtotime("-1 day"),"/","","",TRUE);
		setcookie("name",$_COOKIE["name"],strtotime("-1 day"),"/","","",TRUE);
		setcookie("email",$_COOKIE["email"],strtotime("-1 day"),"/","","",TRUE);
		setcookie("p",$_COOKIE["p"],strtotime("-1 day"),"/","","",TRUE);
		unset($_COOKIE["id"]);
		unset($_COOKIE["name"]);
		unset($_COOKIE["email"]);
		unset($_COOKIE["p"]);
	}

	header("location:login.php");
?>