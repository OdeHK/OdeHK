<?php
	// retrieve product
	$id = isset($_GET['id']) ? $_GET['id'] : die('Error: missing ID');
	
	// include database and object
	include_once "config/database.php";
	include_once "objects/product.php";
	include_once "objects/category.php";
	
	//get db connection
	$database = new Database();
	$db = $database->getConnection();
	
	//prepare object
	$product = new Product($db);
	$category = new Category($db);
	
	// set ID property of product to be edited
	$product->id = $id;
	// read the details of product to be edited
	$product->readOne();
	
	//set page header
	$page_title = "Update Product";
	include_once "layout_header.php";
	
	
	// content
	//		Read Product button
	echo "<div class='m-3 text-end'>
			<a href='index.php' class='btn btn-outline-dark'>Read Product</a>
		</div>";
	
	//set page footer
	include_once "layout_footer.php";
?>
<!-- post code -->
<?php
	//if the form was submitted
	if ($_POST)
	{
		// product property values
		$product->name = $_POST['name'];
		$product->price = $_POST['price'];
		$product->description = $_POST['description'];
		$product->category_id = $_POST['category_id'];
		
		//update the Product
		if ($product->update())
		{
			// If update product success, saving into history
			$product->savingAction($id, "Update");
			echo "<div class='alert alert-success alert-dismissable'>
					Product was updated
				</div>";
		}
		else
		{
			echo "<div class='alert alert-danger alert-dismissable'>
					Unable to update Product
				</div>";
		}
	}
?>

<!--- Update Product form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id={$id}");?>" method="post">
	<table class='table table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'><?php echo $product->description; ?></textarea></td>
        </tr>
  
        <tr>
            <td>Category</td>
            <td>
                <!-- categories select drop-down will be here -->
				<?php
					$stmt = $category->read();
					
					echo "<select class='form-control' name='category_id'>";
						echo "<option>Please select...</option>";
						while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$category_id = $row_category['id'];
							$category_name = $row_category['name'];
							
							//current category of the product must be selected
							if ($product->category_id == $category_id)
							{
								echo "<option value='$category_id' selected>";
							} 
							else
							{
								echo "<option value='$category_id'>";
							}
							echo "$category_name</option>";
						}
					echo "</select>";	
				?>
            </td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
    </table>
</form>
