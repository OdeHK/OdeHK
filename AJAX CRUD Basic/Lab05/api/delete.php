<?php
	require_once('../db/connect-db.php');
	
	$id = $_POST["id"];
	
	//delete record 
	
	$sql = "DELETE FROM $table_name WHERE id = ' ".$id." '";
	
	if ($connection->query($sql) === TRUE)
	{
		echo json_encode([$id]);
	}
	else
	{
		echo "Error deleting record ". $connection->error;
	}
	
	//close connection
	$connection->close();
?>