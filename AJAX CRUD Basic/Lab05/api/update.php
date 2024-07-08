<?php
	require_once('../db/connect-db.php');
	
	//update record 
	$sql = "UPDATE `$table_name` SET `title` = '".$_POST['title']."', `author` = '".$_POST['author']."',
									`published_date` = '".$_POST['published_date']."', `picture` = '".$_POST['picture']."' WHERE `id` = ".$_POST['id']." ";
	
	$result = $connection->query($sql);
	
	//return value 
	$sql = "SELECT * FROM $table_name WHERE `id` = ' ".$_POST['id']." ' ";
	$result = $connection->query($sql);
	
	$data = $result->fetch_assoc();
	echo json_encode($data);
	
?>