<?php 
session_start();

/* Process will contain
1 - Check validation and existence of email in our database
2 - Insertion of Record 
3 - Send Action Link to User email
4 - Selection of Record
*/

//Add db.php page
include 'db.php'; // note: This Class is already connected in the database

class Process extends Database {

	public function verify_email($table,$email){
		//verify email
		//abanwa.naza@gmail.com this is the email can be
		$regExp = "/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9]+)*(\.[a-z]{2,4})$/";
		if (!preg_match($regExp,$email)){
			return "invalid_email";
		}
		// Check whether email already exist or not
		$sql = "SELECT id FROM ".$table." WHERE u_email = '$email' LIMIT 1"; //limit 1 means output only 1 row or result
		$result = mysqli_query($this->conn,$sql);
		$num_row = mysqli_num_rows($result);
		if ($num_row == 1){
			return "already_exists";
		} else {
			return "ok";
		}
	}


	public function insert_record($table,$input){
		// for registration
		$sql = "";
		$sql .= "INSERT INTO ".$table." ";
		$sql .= "(".implode(",", array_keys($input)).") VALUES ";
		$sql .= "('".implode("','", array_values($input))."')";
		$result = mysqli_query($this->conn,$sql);
		$last_id = mysqli_insert_id($this->conn);
		if($result){
			return $last_id; // it will return the last id of the row inserted
		}
	}


	public function send_activation_code($email,$act_code,$uid){
		// ini_set('SMTP', "gmail.com");
		// ini_set('smtp_port', "25");
		// ini_set('abanwa@gmail.com', $email);

		// to Send the registration activation code to our email
		$to = $email;
		$subject = 'Activation Link from Webscript.info';
		$from = 'abanwa005@gmail.com'; // not a valid email though


		// To Send HTML mail, the Content-Type header must be set
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


		// Create Email headers
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();


		// Compose a simple HTML email Message
		$message = '<html><body>';
		$message .= '<h1 style="color:#f40;">Hi $email</h1>';
		$message .= '<p style="color:#333;font-size:14px;font-family:san-serif,Arial;">Please Click on given link to activate your account</p>';
		$message .= "<a href='http://www.webscript.info/register/activation_code.php?ACTIVATION_CODE=".$act_code."&uid=".$uid."&ue=".$email."'>Click here</a>";
		$message .= '</body></html>';


		// // Sending email
		// if (mail($to, $subject, $message, $headers)){
		// 	return true;
		// } else {
		// 	return false;
		// }
	}

	// for login
	public function select_record($table,$where_condition){
		$sql = "";
		$condition = "";
		$array = array();
		foreach ($where_condition as $key => $value){
			$condition .= $key . "= '".$value."' AND ";
		}
		$condition = substr($condition, 0, -5); //we extracted using substr() starting from 0 and ending at -5 counting frm behind excluding the one that completed it -5
		$sql .= "SELECT * FROM ".$table." WHERE ".$condition." LIMIT 1";
		$result = mysqli_query($this->conn,$sql);
		while ($row = mysqli_fetch_array($result)){
			$array = $row;
		}
		return $array;
	}


} // Process Class Ends Here


$obj = new Process();

	// data from main.js from verify_email . Data: check_email & email

if (isset($_POST["check_email"])){
	$email = $_POST["email"];
	echo $data = $obj->verify_email("user_info",$email);
	exit();
}



	// For Registration
if (isset($_POST["u_email"])){
	// validate everything on the form
	if (empty($_POST["gender"]) || empty($_POST["lang"])){
		echo "empty_fields";
		exit();
	}
	$name = preg_replace("#[^A-Za-z ]#i", "", $_POST["name"]);
	$data = $obj->verify_email("user_info",$_POST["u_email"]);
	if ($data == "already_exists"){
		echo "Email Already Exists";
		exit();
	} else{
		$email = $_POST["u_email"];
	}
	$gender = preg_replace("#[^a-z]#i", "", $_POST["gender"]);
	$country = preg_replace("#[^A-Za-z ]#i", "", $_POST["u_country"]);
	$lang = $_POST["lang"];
	$count = count($lang);
	$languages = "";
	for ($i = 0; $i < $count; $i++){
		$languages .= $lang[$i].",";
	}
	$languages = substr($languages, 0, -1); // meaning select starting from the first(0) and stop at the last(-1) excluding the last(-1)
	$languages = preg_replace("#[^A-Za-z,]#i", "", $languages);
	$password = $_POST["password"];
	$repassword = $_POST["repassword"];

	// start validation from here
	if (empty($name) || empty($password) || empty($languages) || empty($country)){
		echo "empty_fields";
		exit();
	}
	if (strlen($password) < 9){
		echo "password_short";
		exit();
	} else {
		// Hash password
		$options = ["COST"=> 12];
		$hash_password = password_hash($password, PASSWORD_DEFAULT,$options);
	}
	$signup_date = date("Y-m-d H:i:s");
	$act_code = time().md5($email).rand(50000,1000000); // just generate anything
	$act_code = str_shuffle($act_code);
	$user = array("u_name"=>$name,"u_email"=>$email,"gender"=>$gender,"languages"=>$languages,"country"=>$country,"password"=>$hash_password,"signup_date"=>$signup_date,"last_login"=>$signup_date,"act_code"=>$act_code,"activated"=>"0");
	$id = $obj->insert_record("user_info",$user);
	if($id){
		//i want ton store the users in a user folder using their email to do that
		//abanwa@gmail.com. it will break from @. i will then have abanwa and @gmail.com
		$username = explode("@", $email);
		$userdir = $username[0]; // this will select only the first part which is "abanwa" after the break up
		if (!file_exists("user/$userdir".$id)){
			//if the file doesn't exist, make dir for it
			mkdir("user/$userdir".$id,0755); // 0755 is the convention
		}
		if (!$obj->send_activation_code($email,$act_code,$id)){
			echo "email_send_success"; // the mail didn't go. i commented it. check the send_activation_code
			exit();
		}
	}



}


		// User Login Process

	if (isset($_POST["log_email"]) AND isset($_POST["log_password"])){
		//verify email
		$data = $obj->verify_email("user_info",$_POST["log_email"]);
		//if it gives us "ok" after going through verify_email, it means the email doesn't exist. (use logic to figure it out)
		if ($data == "ok"){
			echo "not_exists";
			exit();
		} else if ($data == "invalid_email"){
			echo "invalid_email";
			exit();
		} else if ($data == "already_exists"){
			//call the function
			$email = array("u_email"=>$_POST["log_email"]);
			$row = $obj->select_record("user_info",$email);
			$activated = $row["activated"];
			if ($activated == '0'){ // this ought to be 1 but since i haven't sent email to my email. i just let it be 0
				if (password_verify($_POST["log_password"],$row["password"])){
					//Session Variables
					$_SESSION["name"] = $row["u_name"];
					$_SESSION["id"] = $row["id"];
					$_SESSION["email"] = $row["u_email"];
					$_SESSION["password"] = $row["password"];

					// Cookies
					//setcookie("id",$row["id"],time() + (86400 * 30)) // this means  1 day * 30 days
					setcookie("id", $row["id"],strtotime("+1 day"),"/","","",TRUE);
					setcookie("name", $row["u_name"],strtotime("+1 day"),"/","","",TRUE);
					setcookie("email", $row["u_email"],strtotime("+1 day"),"/","","",TRUE);
					setcookie("p", $row["password"],strtotime("+1 day"),"/","","",TRUE);

					echo "login_success";
					exit();
				}
			} else if ($activated == '1'){//this ought to be 0 but since i haven't sent email to my email. i just let it be 1
				echo "Please Verify your Email Address";
				exit();
			}
		}
	}






?>