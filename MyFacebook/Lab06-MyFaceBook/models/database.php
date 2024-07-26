<?php
class Database {
	private $server = "localhost:3308";
	private $user = "root";
	private $pass = "";
	private $db_name = "lab06-myfacebook";
	
	function __construct()
	{
		try {
			$this->conn = new mysqli($this->server, $this->user, $this->pass, $this->db_name);
		} 
		catch(Exception $e)
		{
			echo "Caught Excpetion ".$e->getMessage();
		}
	}
	
	function __destruct()
	{
		try {
			$this->conn->close();
		}
		catch (Exception $e)
		{
			echo "Caught Exception ".$e->getMessage();
		}
	}
}
?>