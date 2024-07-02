<?php
	// get id of the product to be Read
	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
	
	// include database and object
	include_once "config/database.php";
	include_once "objects/product.php";
	include_once "objects/category.php";
	
	//get db connection
	$database = new Database();
	$db = $database->getConnection();
	
	// prepare object
	$product = new Product($db);
	$category = new Category($db);
	
	// set id property of product to be read
	$product->id = $id;
	// read details of product to be read
	$product->readOne();
	
	//set page header
	$page_title = "Read One Product";
	include_once "layout_header.php";
	
	//Saving into History
	$product->savingAction($id, "Read");
	
	//read product button
	echo "<div class='m-3 text-end'>
			<a href='index.php' class='btn btn-primary'>
				<i class='bi bi-list-task'></i> Read Product
			</a>
		</div>";
		
	// HTML table for displaying a product details
	echo 
	"<table class='table table-bordered'>
		<tr>
			<td>Name</td>
			<td>{$product->name}</td>
		</tr>
	  
		<tr>
			<td>Price</td>
			<td>{$product->price}</td>
		</tr>
	  
		<tr>
			<td>Description</td>
			<td>{$product->description}</td>
		</tr>
		
		<tr>
        <td>Category</td>
        <td>";
            // display category name
            $category->id=$product->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>
		</tr>
	</table>";

	//set footer
	include_once "layout_footer.php";
?>