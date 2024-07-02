<?php
	//check if value was posted
	if ($_POST)
	{
		//include database and object
		include_once "config/database.php";
		include_once "objects/product.php";
		
		//get db connection
		$database = new Database();
		$db = $database->getConnection();
		
		//prepare product object
		$product = new Product($db);
		
		// set product id to be deleted
		$product->id = $_POST['object_id'];
		
		// delete the Product
		if ($product->delete())
		{
			// If delete product success, saving action into history
			$product->savingAction($_POST['object_id'], "Delete");
			echo "Object was deleted";
		}
		else
		{
			echo "Unable to delete object";
		}
	}
?>