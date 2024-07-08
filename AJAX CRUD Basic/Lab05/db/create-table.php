<?php
	include_once("connect-db.php");
	
	//create new table
	$sql = "CREATE TABLE `$table_name` (
		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		
		title VARCHAR(191) NOT NULL,
		
		author VARCHAR(191) NOT NULL,
		
		published_date DATE,
		
		last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		
		status ENUM('active', 'pending', 'delete')
	)";
	
	if ($connection->query($sql) === TRUE)
	{
		echo "Table '".$table_name."' created successfully";
	}
	else
	{
		echo "Error creating table: ".$connection->error;
	}
	
	//close connection
	$connection->close();
	
?>		