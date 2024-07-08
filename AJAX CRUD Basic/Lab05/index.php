<?php require_once('db/env.php'); ?>
<html lang="en">
	<style>
		tr {
			cursor: pointer;
		}
		img {
			object-fit: contain;
			width: 400px;
			heìght: auto;
		}
	</style>
    <head>
        <!-- Meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js" integrity="sha512-frFP3ZxLshB4CErXkPVEXnd5ingvYYtYhE5qllGdZmcOlRKNEPbufyupfdSTNmoF5ICaQNO6SenXzOZvoGkiIA==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
	    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
		<!-- Custom JS -->
		<script type = "text/javascript">
			var url = "<?php echo $url; ?>";
			var display_rows = "<?php echo $display_rows; ?>";
			
			$(function()
			{
				$("#published_date").datepicker({dateFormat: 'yy-mm-dd'});
				$("#published_date_edit").datepicker({dateFormat: 'yy-mm-dd'});
			});
		</script>
		<!-- API JS files -->
		<script src="js/index.js"></script>
		<title>Trial Project for Worker Bee TV - Submitted by Jay Acab chiefofstack.com </title>
		<!-- Style -->
    </head>
	
    <body>
		<div class="container ml-4">
			<!-- Add new book section -->
			<div class="row mt-4">
				<div class="col-lg-10">
					<div class="float-left">
						<h2>Books</h2>
					</div>
					
					<div class="float-right">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-book">
							Add New Book
						</button>
					</div>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-sm-10">
					<!-- table of content -->
					<table class="table table-bordered table-striped text muted text-center mt-3" id="table_content">
						<thead>
							<tr>
								<th>Date Published</th>
								<th>Author name</th>
								<th>Book Title</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					
					<ul id="pagination" class="pagination-sm"></ul>
					</div>
					<div class="col-sm-2 mt-4">
						<div class="picture_container">
							<img src="img/default.jpg">
						</div>
					</div>
			</div>
		</div>
		
		<!-- View book modal -->
		<div id="view-book" class="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<!-- header -->
					<div class="modal-header">
						<div>
							<h4 class="modal-title float-left" id="modalLabel">Book Information</h4>
						</div>
						
						<div>
							<button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">x</span>
							</button>
						</div>
					</div>
					<!-- body -->
					<div class="modal-body">
						<form id="view-book-form" data-toggle="validator" action="api/create.php" method="POST">
							<div class="form-group">
								<label class="control-label" for="title">Title:</label>
								<p id="title_view" name="title" class="font-weight-bold"></p>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="published_date">Date Published:</label>
								<p id="published_date_view" name="published_date" class="font-weight-bold"></p>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="id">ID:</label>
								<p id="id_view" name="id" class="font-weight-bold"></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Create book modal -->
		<div id="create-book" class="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<!-- header -->
					<div class="modal-header">
						<div>
							<h4 class="modal-title float-left" id="modalLabel">Add a book</h4>
						</div>
						
						<div>
							<button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">x</span>
							</button>
						</div>
					</div>
					<!-- body -->
					<div class="modal-body">
						<form id="create-book-form" data-toggle="validator" action="api/create.php" method="POST">
							<div class="form-group">
								<label class="control-label" for="title">Title:</label>
								<input type="text" id="title" name="title" class="form-control" data-error="Please enter book title." required >
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="author">Author:</label>
								<input type="text" id="author" name="author" class="form-control" data-error="Please enter the name of the author." required>
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="published_date">Date Published:</label>
								<input type="text" id="published_date" name="published_date" class="form-control" data-error="Please enter the date when the book was published." required autocomplete="off">
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="picture">Picture:</label>
								<input type="file" id="picture" name="picture"  class="form-control"/>
							</div>
							
							<div class="form-group mt-4">
								<button type="submit" class="btn submit-book btn-success">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Edit Book Modal -->
		<div id="edit-book" class="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<!-- header -->
					<div class="modal-header">
						<div>
							<h4 class="modal-title float-left" id="modalLabel">Edit Book</h4>
						</div>
						
						<div>
							<button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">x</span>
							</button>
						</div>
					</div>
					
					<!-- body -->
					<div class="modal-body">
						<form id="edit-book-form" data-toggle="validator" action="api/update.php" method="put">
							<input type="hidden" id="id" name="id" class="edit-id">
							<div class="form-group">
								<label class="control-label" for="title_edit">Title:</label>
								<input type="text" id="title_edit" name="title" class="form-control" data-error="Please enter book title." required >
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="author_edit">Author:</label>
								<input type="text" id="author_edit" name="author" class="form-control" data-error="Please enter the name of the author." required>
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label  class="control-label" for="published_date_edit">Date Published:</label>
								<input type="text" id="published_date_edit" name="published_date" class="form-control" data-error="PLease enter the date when the bool was published." required autocomplete="off">
								<div class="help-block with-errors text-danger"></div>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="picture_edit">Picture:</label>
								<input type="text" id="picture_name_edit" class="form-control" disabled hidden/>
								<input type="file" id="picture_edit" name="picture" class="form-control"/>
							</div>
							
							<div class="form-group mt-4">
								<button type="submit" class="btn submit-book-edit btn-success">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>