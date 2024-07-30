<?php
class Comment extends Database
{
	private $table_name = "comments";
	
	function __construct()
	{
		parent::__construct();
	}
	
	private function loadComment($id)
	{
		$commentInfo = false;
		
		try
		{
			$sql = "SELECT *
					FROM $this->table_name
					WHERE id=? LIMIT 1;";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("s", $id);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if ($comment = $result->fetch_assoc())
			{
				$user = new User();
				
				$commentInfo = (object) $comment;
				
				$commentInfo->owner = $user->getUserInfobyId($commentInfo->userId);
				
			}
		}
		catch(Exception $e)
		{
			//do sth
		}
		
		return $commentInfo;
	}
	
	public function loadComments($postId, $limits=100)
	{
		$comments = array();
		
		try 
		{
			$sql = "SELECT id 
					FROM $this->table_name
					WHERE postId=? ORDER BY ID ASC LIMIT ?";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("is", $postId, $limits);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			while($comment = $result->fetch_assoc())
			{
				$comments[] = $this->loadComment($comment['id']);
			}
		}
		catch(Exception $e)
		{
			//do sth
		}
		
		return $comments;
	}
}