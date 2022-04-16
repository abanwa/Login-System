<?php 

include "db.php";
$db = new Database();

?>

<h3>Request for a new Password</h3>
<hr>
<p>Enter your Email Address</p>
<form action="" method="POST">
	<input type="email" name="recovery_email" placeholder="Enter your Email" required><br/><br/>
	<input type="submit" name="lost_password" value="Request new password">
</form>

<?php 

if (isset($_POST["lost_password"])){
	$email = mysqli_real_escape_string($db->conn,$_POST["recovery_email"]);
	$sql = "SELECT id,note FROM user_info WHERE u_email = '$email' AND activated = '0' LIMIT 1"; //activated is suppposed to be 1 but since we can't send the email. we just left it as 0. just to be able to work with it
	$result = mysqli_query($db->conn,$sql) or die(mysqli_error($db->conn));
	if (mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		$uid = $row["id"];
		$note =$row["note"];

		// if the note is empty, it means you have already changed your password from your email or else you haven't checked your email. that means i have update/sent something in the note else continue, check the code down how we sent something to note

		if ($note != ""){
			echo "Please check your email address to see your reset password link";
			exit();
		} else {
			// to know whether the email belongs to the user or not, we will send him a mail to confirm
			//and generate a random number
			$random_note = time().rand(50000,1000000);
			$random_note = str_shuffle($random_note);
			$update_note = "UPDATE user_info SET note = '$random_note' WHERE id = '$uid' AND u_email = '$email'";
			if (mysqli_query($db->conn,$update_note)){
				$to = $email;
				$subject = "Reset Password";
				$message = "Please click on the given link or url to reset your password <br/>";
				$message .= "http://www.yourDomainName.com/password_reset.php?note=".$random_note."&uid=".$uid."&email=".$email;
				$header = "From : abanwa@gmail.com";
				if(!mail($to,$subject,$message,$header)){ // note: the email didn't go
					echo "Please confirm your email to reset your password<br/>";
					echo "Email temporary display here".$message;
					exit();
			}

			}
			
		}

		 

		// $to = $email; //recipient
		// $subject = "Reset Password"; //subject
		// $message = "The text for the mail..."; //mail body
		// $header = "From: abanwa005@gmail.com"; //optional headerfields

		// if(mail($to, $subject, $message, $header)){
			//echo "Please confirm your email to reset your password";
	// } else {
	// 	echo "Your email address does not exist";
	// }
} else {
			echo "Your email address doesn't exists";
		}

}








?>



