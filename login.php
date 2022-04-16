<?php

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
	<title>Login</title>
	<script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body>
	<div class="log">
		<a href="index.php">Register</a> || <a href="login.php">Login</a>
	</div>
	<div class="form">
		<h2>Login</h2>
		<hr>
		<p id="msg"></p>

		<!--  Form Starts Here -->
		<form onsubmit="return false" method="POST" id="login_form">
			<label>Email</label>
			<div class="input">
				<div>
					<input type="text" name="log_email" id="log_email" placeholder="Email">
				</div>
				<div class="error e_error"></div>
			</div>
			<label>Password</label>
			<div class="input">
				<div>
					<input type="password" name="log_password" id="log_password" placeholder="Password">
				</div>
				<div class="error u_error"></div>
			</div>
			<div class="input">
				<div>
					<input type="submit" name="login" id="login" value="Login">
				</div>
			</div>
			
		</form>
		<br/>
		<div>
			<a href="forget_password.php">Forgotten Password</a>
		</div>
	</div>
	
</body>
</html>










