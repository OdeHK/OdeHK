<?php
	//include database and object file
	include_once 'config/database.php';
	include_once 'objects/product.php';
	include_once 'objects/category.php';
	
	//get database connection
	$database = new Database();
	$db = $database->getConnection();
	
	//pass connection to objects
	$product = new Product($db);
	$category = new Category($db);
	
	//set page header
	$page_title = "Create Product";
	include_once "layout_header.php";
	
	//CONTENT
	//	Read Products Button
	echo "<div class='m-3 text-end'>
			<a href='index.php' class='btn btn-outline-dark'>Read Products</a>
		</div>";	
?>


<!-- PHP post code will be here -->
<?php
	// if the form was submitted - PHP OOP CRUD tutorial
	if($_POST)
	{
		//product property values
		$product->name = $_POST['name'];
		$product->price = $_POST['price'];
		$product->description = $_POST['description'];
		$product->category_id = $_POST['category_id'];
		
		//create the product
		if ($product->create())
		{
			// If create product success, take the newest id (the just created product)
			// and saving into history
			$id = $db->lastInsertId();
			$product->savingAction($id, "Create");
			echo "<div class='alert alert-success'>Product was created.</div>";
		}
		else
		{
			echo "<div class='alert alert-danger'>Unable to create product.</div>";
		}
	}
?>
<!--	CREATE PRODUCT FORM  -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-bordered'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
  
        <tr>
            <td>Category</td>
            <td>
				<!-- DROP-DOWN LIST category -->
				<?php
				// read the product categories from the database
				$stmt = $category->read();
				  
				// put them in a select drop-down
				echo "<select class='form-control' name='category_id'>";
					echo "<option>Select category...</option>";
				  
					while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row_category);
						echo "<option value='{$id}'>{$name}</option>";
					}
				  
				echo "</select>";
				?>
            </td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>
</div>

<?php
	//footer
	include_once "layout_footer.php";
?>