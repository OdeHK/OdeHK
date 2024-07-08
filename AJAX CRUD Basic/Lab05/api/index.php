<?php
	require_once('../db/connect-db.php');
	
	
	$page = (isset($_GET["page"])) ? $_GET["page"] : 1;
	
	$start_from = ($page-1)*$display_rows;
	
	
	
	//get all rows for selected page
	$sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT $start_from, $display_rows";
	
	$result = $connection->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$json[] = $row;
	}
	
	$data['data'] = $json;
	
	//get total count of books
	$sql = "SELECT COUNT(*) AS  total FROM $table_name";
	
	$result = $connection->query($sql);
	
	$values = mysqli_fetch_assoc($result);
	
	$data['total'] = $values['total'];
	
	
	//return books
	echo json_encode($data);
?>