<?php 

include "db.php";
$db = new Database();

if (isset($_REQUEST["note"]) AND isset($_REQUEST["uid"]) AND isset($_REQUEST["email"])){

	$note = preg_replace("#[^0-9]#", "", $_REQUEST["note"]);
	$uid = preg_replace("#[^0-9]#", "", $_REQUEST["uid"]);
	$email = mysqli_real_escape_string($db->conn, $_REQUEST["email"]);

	$sql = "SELECT id FROM user_info WHERE note = '$note' AND u_email = '$email' AND id = '$uid' LIMIT 1";
	$result = mysqli_query($db->conn,$sql) or die(mysqli_error($db->conn));
	if ($result){

			 ?>

	 <center>
	 <form method='post' action=''>
	 	<h2>Set your new Password</h2>
	 	<hr>
	 	<input type="hidden" name="id" value="<?php echo $uid; ?>">
	 	<input type="hidden" name="email" value="<?php echo $email; ?>">
	 	<input type="password" name="new_password" placeholder="New Password" required><br/><br/>
	 	<input type="password" name="confirm_password" placeholder="New Password" required><br/><br/>
	 	<input type="submit" name="change_password" value="Reset Password">
	 </form>
	 </center>

		<?php 
	} else {
		echo "Error : Please try again ...";
	}

}


if (isset($_POST["change_password"])){

	$new_password = $_POST["new_password"];
	$con_password = $_POST["confirm_password"];
	$id = $_POST["id"];
	$email = $_POST["email"];

	if (strlen($new_password) < 9){
		echo "Password length is short";
		exit();
	} else {
		if ($new_password == $con_password){
			$option = ["COST" => 12];
			$password_hash = password_hash($new_password,PASSWORD_DEFAULT,$option);
			$change_password_sql = "UPDATE user_info SET password = '$password_hash',note = '' WHERE id = '$id' AND u_email = '$email'";
			$result = mysqli_query($db->conn,$change_password_sql) or die(mysqli_error($db->conn));
			if ($result){
				echo "Your password has been changed. you can now login with your new password";
			}
		} else{
			echo "password not the same";
		}
	}
}









?>