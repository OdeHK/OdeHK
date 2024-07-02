<?php
	// page given in URL parameter, default page is one
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	
	// set number of records per page
	$records_per_page = 5;
	
	//calculate for the query LIMIT clause
	$from_record_num = ($records_per_page * $page) - $records_per_page;
	
	// include database and object files
	include_once 'config/database.php';
	include_once 'objects/product.php';
	include_once 'objects/category.php';
	
	// instantiate database and objects
	$database = new Database();
	$db = $database->getConnection();
	$product = new Product($db);
	$category = new Category($db);
	
	//query products
	$stmt = $product->readAll($from_record_num, $records_per_page);
	$num = $stmt->rowCount();
	
	// set page header
	$page_title = "Read Products";
	include_once "layout_header.php";
	  
	//	CREATE PRODUCT Button
	echo "<div class='m-3 text-end'>
			<a href='create_product.php' class='btn btn-outline-dark'>Create Product</a>
		</div>";
	
	//display products 
	if ($num>0)
	{
		echo "<table class='table table-bordered'>";
		echo "<tr>";
			echo "<th>Product</th>";
			echo "<th>Price</th>";
			echo "<th>Description</th>";
			echo "<th>Category</th>";
			echo "<th>Actions</th>";
		echo "</tr>";
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			
			echo "<tr>";
				echo "<td>{$name}</td>";
				echo "<td>{$price}</td>";
				echo "<td>{$description}</td>";
				echo "<td>";
					$category->id = $category_id;
					$category->readName();
					echo $category->name;
				echo "</td>";
			
				echo "<td>";
					//read, edit and delete button
					echo "<a href='read_one.php?id={$id}' class='btn btn-outline-primary'>
							<i class='bi bi-list'></i> Read
						</a>
						
						<a href='update_product.php?id={$id}' class='btn btn-outline-info'>
							<i class='bi bi-pencil-square'></i> Edit
						</a>
						
						<a delete-id='{$id}' class='btn btn-outline-danger delete-object'>
							<i class='bi bi-x-square'></i> Delete
						</a>";
				echo "</td>";
			
			echo "</tr>";
		}
		echo "</table>";
		
		// the page where this paging is used
		$page_url = "index.php?";
		
		//count all products in the database to calculate total pages
		$total_rows = $product->countAll();
		
		//paging button
		include_once 'paging.php';
	}
	else
	{
		echo "<div class='alert alert-info'>No products found </div>";
	}
	
	// set page footer
	include_once "layout_footer.php";
?>

