<?php
	class Database 
	{
		private $host = "localhost";
		private $db_name = "lab04";
		private $username = "root";
		private $password = "";
		public $conn;
		
		public function getConnection() 
		{
			$this->conn = null;
			
			try
			{
				$this->conn = new PDO("mysql:host=".$this->host.";port=3308;dbname=".$this->db_name,$this->username,$this->password);
			} catch (PDOException $exception)
			{
				echo "Connection error.".$exception->getMessage();
			}
			return $this->conn;
		}
	}	
?>