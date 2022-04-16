<?php 

$conn = new mysqli("localhost","root","","login_system");
if (!$conn){
	echo "Error in connecting".mysqli_error();
} else {
	echo "connected";
}


// Create Table if it doesn't exist

$sql = "CREATE TABLE IF NOT EXISTS  user_info(
	id INT(11) NOT NULL AUTO_INCREMENT,
	u_name VARCHAR(255) NOT NULL,
	u_email VARCHAR(255) NOT NULL,
	gender ENUM('m','f') NOT NULL,
	languages VARCHAR(100) NOT NULL,
	country VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	signup_date DATETIME NOT NULL,
	last_login DATETIME NOT NULL,
	act_code VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY (u_email)
)";

$result = mysqli_query($conn,$sql);
if ($result){
	echo "Table Created";
}

// we forgot to add something after we had already created the table, so we have to add it.
$sql = "ALTER TABLE user_info ADD activated ENUM('0','1') DEFAULT '0' AFTER act_code";
if (mysqli_query($conn, $sql)){
	echo "Alteration Successful";
}



?>