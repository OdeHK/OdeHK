<?php
	include_once("env.php");
	
	//create connection
	$connection = new mysqli($server, $user, $pass, $db_name);
	
	//check connection
	if ($connection->connect_error)
	{
		die("ERROR: Could not connect ".$connection->connect_error);
	}
	
?>