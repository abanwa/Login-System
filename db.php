<?php 

// DataBase Constants
define("HOST","localhost");
define("USER","root");
define("PASSWORD","");
define("DB","login_system");

class Database {

	public $conn;
	function __construct(){
		$this->conn = new mysqli(HOST,USER,PASSWORD,DB);
		if (!$this->conn){
			echo "Connecting Error ".mysqli_error();
		} 
	}


}


//$obj = new Database();




?>