<?php 
session_start();

include "db.php";

// This variable will tell you about your login status
$login_key = false;

class LoginStatus extends Database {
	public function userLogin($id,$email,$password){
		// Check User Credentials
		$email = mysqli_real_escape_string($this->conn,$email);
		$sql = "SELECT id FROM user_info WHERE id = '$id' AND u_email = '$email' AND password = '$password' LIMIT 1";
		$result = mysqli_query($this->conn,$sql);
		$num_row = mysqli_num_rows($result);
		if ($num_row == 1){
			//this will tell us about last login of user
			$login_date = date("Y-m-d H:i:s");
			$update_login_date = "UPDATE user_info SET last_login = '$login_date' WHERE id = '$id' AND u_email = '$email'";
			$result = mysqli_query($this->conn,$update_login_date) or die(mysqli_error($this->conn));
			return true;
		}
		return false;
	}
} // LoginStatus Class End Here

//make object of the class
$login = new LoginStatus();

if (isset($_SESSION["id"]) AND isset($_SESSION["name"]) AND isset($_SESSION["email"]) AND isset($_SESSION["password"])){
	$id = preg_replace("#[^0-9]#", "", $_SESSION["id"]);
	$email = $_SESSION["email"];
	$password = $_SESSION["password"];

	$login_key = $login->userLogin($id,$email,$password);

} else {
	if (isset($_COOKIE["id"]) AND isset($_COOKIE["name"]) AND isset($_COOKIE["email"]) AND isset($_COOKIE["p"])){
		$_SESSION["id"] = preg_replace("#[^0-9]#", "", $_COOKIE["id"]);
		$_SESSION["name"] = $_COOKIE["name"];
		$_SESSION["email"] = $_COOKIE["email"];
		$_SESSION["password"] = $_COOKIE["p"];

		$login_key = $login->userLogin($_SESSION["id"],$_SESSION["email"],$_SESSION["password"]);
	}
}




?>