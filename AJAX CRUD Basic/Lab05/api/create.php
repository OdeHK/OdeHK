<?php
	require_once('../db/connect-db.php');
	
	//add new record
	$sql = "INSERT INTO `$table_name` (`title`, `author`, `published_date`, `picture`) 
					VALUES('".$_POST['title']."', '".$_POST['author']."','".$_POST['published_date']."' , '".$_POST['picture']."')";
	
	$result = $connection->query($sql);
	
	// return VALUES
	$sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1";
	
	$result = $connection->query($sql);
	
	$data = $result->fetch_assoc();
	
	echo json_encode($data);
?>