<?php
	//this is to keep the user online until he logs out
// session_start();
// if (isset($_SESSION["id"])){
// 	header("location: profile.php");
// }

include "login_status.php";

if ($login_key){
	header("location:profile.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register & Login</title>
	<script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body>
	<div class="log">
		<a href="index.php">Register</a> || <a href="login.php">Login</a>
	</div>
	<div class="form">
		<h2>Register</h2>
		<hr>
		<p id="msg"></p>

		<!--  Form Starts Here -->
		<form onsubmit="return false" method="POST" id="register_form">
			<label>Name</label>
			<div class="input">
				<div>
					<input type="text" name="name" id="name" placeholder="Name">
				</div>
				<div class="error u_error"></div>
			</div>
			<label>Email</label>
			<div class="input">
				<div>
					<input type="text" name="u_email" id="u_email" placeholder="Email">
				</div>
				<div class="error e_error"></div>
			</div>
			<label>Gender</label>
			<div class="input">
				<div style="margin-top: 10px;">
					<input type="radio" name="gender" value="m">Male
					<input type="radio" name="gender" value="f">Female
				</div>
				<div class="error g_error"></div>
			</div>
			<label>Choose Country</label>
			<div class="input">
				<div>
					<select class="input-opt" name="u_country">
						<option value="">Choose Country</option>
						<option value="India">India</option>
						<option value="Pakistan">Pakistan</option>
						<option value="UEA">UEA</option>
						<option value="China">China</option>
						<option value="Afghanistan">Afghanistan</option>
					</select>
				</div>
				<div class="error"></div>
			</div>
			<label>Language Known</label>
			<div class="input">
				<div style="margin-top: 10px;">
					<input type="checkbox" name="lang[]" value="English">English
					<input type="checkbox" name="lang[]" value="Hindi">Hindi
					<input type="checkbox" name="lang[]" value="Urdu">Urdu
				</div>
				<div class="error"></div>
			</div>
			<label>Choose Password</label>
			<div class="input">
				<div>
					<input type="password" name="password" id="password" placeholder="Password">
				</div>
				<div class="error u_error"></div>
			</div>
			<label>Re-enter Password</label>
			<div class="input">
				<div>
					<input type="password" name="repassword" id="u_name" placeholder="Password">
				</div>
				<div class="error u_error"></div>
			</div>
			<div class="input">
				<div>
					<input type="submit" name="register" id="register" value="Register">
				</div>
			</div>
			
		</form>
	</div>
	
</body>
</html>










