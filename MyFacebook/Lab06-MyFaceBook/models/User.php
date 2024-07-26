<?php
class User extends Database 
{
	private $table_name = "users";
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function createUser($username, $password, $fullname, $role=0)
	{
		//Create SQL query to create a new User
		try {
			// SQL
			$sql = "INSERT INTO $this->table_name SET username=?, password=PASSWORD(?), fullname=?, role=0, status=1";
			
			// Execute SQL
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sss", $username, $password, $fullname); 
				// bind_param takes variables(username, password, fullname) into "?" in sql
				// "sss" defines the variables as string
			$stmt->execute();
			
			// Get back the newest id
			$id = $stmt->insert_id;
			
			return $this->getUserInfoById($id);
		}
		catch(Exception $e)
		{
			//Do sth
		}
		
		return true;
	}
	
	public function authenticate($username, $password)
	{
		try 
		{
			$sql = "SELECT id, username, fullname, role 
					FROM $this->table_name 
					WHERE username=? AND password=PASSWORD(?) AND status=1 LIMIT 1;";
				
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ss", $username, $password);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($user = $result->fetch_assoc())
			{
				return (object) $user;
			}
		}
		catch(Exception $e)
		{
			//do sth
		}
			
		return false;
	}
	
	public function getUserInfoById($id)
	{
		try {
			$sql = "SELECT id, username, fullname, role, status
					FROM $this->table_name
					WHERE id = ?";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("s", $id);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if ($user = $result->fetch_assoc())
			{
				return (object) $user;
			}
		}catch(Exception $e)
		{
			//do sth
		}
		
		return false;
	}
}