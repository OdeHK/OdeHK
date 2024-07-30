<?php
class Post extends Database
{
	private $table_name = "posts";
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function createPost($post)
	{
		if (!SessionManager::isUserLoggedIn())
		{
			return false;
		}
		$userId = SessionManager::getUserId();
		
		try
		{
			// SQL to create a new post
			$sql = "INSERT INTO $this->table_name SET userId=?, message=?";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("is", $userId, $post);
			// UserId is integer and post is string
			$stmt->execute();
			
			// get the id of the newest post
			$id = $stmt->insert_id;
			
			return $this->getPostInfo($id);
		}
		catch(Exception $e)
		{
			//echo $e->getMessage();
		}
		
		// Return ID of the post
		return false;
	}
	
	public function getPostInfo($id, $withComment=true)
	{
		$postInfo = false;
		
		try
		{
			$sql = "SELECT *
					FROM $this->table_name
					WHERE id=? LIMIT 1;";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("s", $id);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if ($post = $result->fetch_assoc())
			{
				$user = new User();
				
				$postInfo = (object) $post;
				
				$postInfo->owner = $user->getUserInfoById($postInfo->userId);
				$postInfo->comments = [];
				
				if ($withComment)
				{
					$cmt = new Comment();
					$postInfo->comments = $cmt->loadComments($postInfo->id);
				}
			}
		}
		catch(Exception $e)
		{
			//do sth
		}
		
		return $postInfo;
	}
	
	public function getAllPosts($limits=10)
	{
		$posts = array();
		
		try
		{
			$sql = "SELECT id 
					FROM $this->table_name
					ORDER BY ID DESC LIMIT ?";
					
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("s", $limits);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			$user = new User();
			
			while($post = $result->fetch_assoc())
			{
				$posts[] = $this->getPostInfo($post['id']);
				
			}
		}
		catch(Exception $e)
		{
			//do sth
		}
		
		return $posts;
	}
	
	public function checkIfOwner($postId)
	{
		$postInfo = $this->getPostInfo($postId);
		
		if (!$postInfo)
		{
			//not found the post
			return false;
		}
		
		if ($postInfo->userId != SessionManager::getUserId())
		{
			// not the owner
			return false;
		}
		
		return true;
	}
	
	public function editPost($postId, $newpost)
	{
		if (!$this->checkIfOwner($postId))
		{
			return false;
		}
		
		try
		{
			$sql = "UPDATE $this->table_name
					SET message=?
					WHERE id=?";
			
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("si", $newpost, $postId);
			$stmt->execute();
			
			return true;
			
		} catch(Exception $e)
		{
			//do sth
		}
		return true;
	}
	
	public function deletePost($id)
	{
		if (!$this->checkIfOwner($id))
		{
			return false;
		}
		
		try
		{
			$sql = "DELETE FROM $this->table_name WHERE id=?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			
			return true;
		}
		catch(Exception $e)
		{
			// do sth
		}
		
		return true;
	}
}