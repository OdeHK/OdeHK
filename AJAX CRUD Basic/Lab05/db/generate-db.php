<?php
	include_once("env.php");
	
	//create connection
	
	$connection = new mysqli($server, $user, $pass);
	
	//check connection
	if ($connection->connect_error)
	{
		die("ERROR: Could not connect".$connection->connect_error);
	}
	
	//create new database
	$sql = "CREATE DATABASE `$db_name`";
	
	if ($connection->query($sql) === TRUE)
	{
		echo "Database created successfully";
	}
	else
	{
		echo "ERROR: Unable to execute $sql.".$connection->error;
	}
	
	//close connection
	$connection->close();
	
?>