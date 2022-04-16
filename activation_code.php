<?php 

include "db.php";
$db = new Database();

if (isset($_REQUEST["ACTIVATION_CODE"]) AND isset($_REQUEST["uid"]) AND isset($_REQUEST["ue"])){
	$uid = $_REQUEST["uid"];
	$ue = $_REQUEST["ue"];
	$act_code = $_REQUEST["ACTIVATION_CODE"];

	// Here we will check if the user is already activated
	$sql = "SELECT u_name,activated FROM user_info WHERE (id='$uid' AND u_email='$ue' AND act_code='$act_code') LIMIT 1";
	$result = mysqli_query($this->conn,$sql) or die(mysqli_error($db->conn));
	$row = mysqli_fetch_array($result);
	$name = $row["u_name"];
	$status = $row["activated"];

	// Here we will check whether database column activated is 0. if it's 0, it means it's not activated
	if ($status == '0'){
		$sql = "UPDATE user_info SET activated = '1' WHERE u_email='$ue' AND id='$uid'";
		$result = mysqli_query($db->conn,$sql) or die(mysqli_error($db->conn));
		if ($result){
			echo $name." your Accounted has been Activated Successfully..!";
			exit();
		}
	} else if ($status == '1'){
			echo $name." your Account is Already Activated";
	}
}
























?>