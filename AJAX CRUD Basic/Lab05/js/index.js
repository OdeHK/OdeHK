$(document).ready(function() {
	/*Initialize the index*/
	var page = 1;
	var current_page = 1;
	var total_page = 0;
	var display = "list";
	
	/* Display Initial List of Books */
	if (display == "list")
		displayBookList();
	
	/* View Books */
	$("body").on("click", ".view-book", function() {
		var id = $(this).parent("td").data('id');
		var title = $(this).parent("td").prev("td").text();
		var author = $(this).parent("td").prev("td").prev("td").text();
		var published_date = $(this).parent("td").prev("td").prev("td").prev("td").text();
		display = "details";
		
		$("#id_view").text(id);
		$("#title_view").text(title);
		$("#author_view").text(author);
		$("#published_date_view").text(published_date);
	});
	
	/* Create new book */
	$('#create-book-form').on('submit', function(e)
	{
		e.preventDefault();
		var form_action = $("#create-book-form").attr("action");
		var title = $("#title").val();
		var author = $("#author").val();
		var published_date = $("#published_date").val();
		var picture_path = $("#picture").val();
		var picture_name = picture_path != '' ? picture_path.split('\\').pop().split('/').pop() : "default.jpg";
		display = "create";
		
		if (title != '' && author != '' && published_date != '')
		{
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: url + form_action,
				data: {
					title: title,
					author: author,
					published_date: published_date,
					picture: picture_name
				}
			}).done(function(data){
				// Reset form
				$("#title").val('');
				$("#author").val('');
				$("#published_date").val('');
				$("#picture").val('');
				
				// display new item on List
				displayPageEntries();
				
				// hide modal
				$("#create-book").modal('hide');
				toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
			});
		}
		else
		{
			alert('All fields are required. Please make sure you fill out all fields correctly.')
		}
	});
	
	/* Edit book */
	$("body").on("click", ".edit-book", function()
	{
		var id = $(this).parent("td").data('id');
		var title = $(this).parent("td").prev("td").text();
		var author = $(this).parent("td").prev("td").prev("td").text();
		var published_date = $(this).parent("td").prev("td").prev("td").prev("td").text();
		var picture_name = $(this).parent("td").parent("tr").data('image');
		display = "edit";
		
		$("#title_edit").val(title);
		$("#author_edit").val(author);
		$("#published_date_edit").val(published_date);
		$("#picture_name_edit").val(picture_name);
		$("#edit-book-form").find(".edit-id").val(id);
	});
	
	/* Update book */
	$('#edit-book-form').on('submit', function(e)
	{
		e.preventDefault();
		
		var form_action = $("#edit-book-form").attr("action");
		var title = $("#title_edit").val();
		var author = $("#author_edit").val();
		var published_date = $("#published_date_edit").val();
		var picture_path = $("#picture_edit").val();
		var picture_name = picture_path != '' ? picture_path.split('\\').pop().split('/').pop() : $("#picture_name_edit").val();
		var id = $("#edit-book-form").find(".edit-id").val();
		
		if (title != '' && author != '' && published_date != '')
		{
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: url + form_action,
				data: {
					id: id,
					title: title,
					author: author,
					published_date: published_date,
					picture: picture_name
				}
			}).done(function(data){
				// reset Form
				$("#title_edit").val('');
				$("#author_edit").val('');
				$("#published_date_edit").val('');
				$("#picture_name_edit").val('');
				$("#picture_edit").val('');
				// display new item on the List
				displayPageEntries();
				
				//hide modal
				$("#edit-book").modal('hide');
				toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
			});
		}
		else
		{
			alert('All fields are required. Please make sure you fill out all fields correctly.')
		}
	});
	
	/* Delete book */
	$("body").on("click", ".delete-book", function()
	{
		var id = $(this).parent("td").data('id');
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: url + 'api/delete.php',
			data: {id:id}
		}).done(function(data){
			displayPageEntries();
			toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
		});
	});
	
	/* Display initial list of all books with pagination */
	function displayBookList()
	{
		$.ajax({
			dataType: 'json',
			url: url+'api/index.php',
			data: {page:page}
		}).done(function(data) {
			total_page = Math.ceil(data.total/display_rows);
			current_page = page;
			refreshList(data.data);
			
			$('#pagination').twbsPagination({
				totalPages: total_page,
				visiblePages: current_page,
				onPageClick: function(event, pageL) {
					page = pageL;
					displayPageEntries();
				}
			});
		});
	}
	
	/* Display books for current page */
	function displayPageEntries()
	{
		$.ajax({
			dataType: 'json',
			url: url+'api/index.php',
			data: {page:page}
		}).done(function(data) {
			refreshList(data.data);
		});
	}
	
	/* Refresh table list */
	function refreshList(data)
	{
		var rows = '';
		$.each(data, function(key, value) {
			rows = rows + '<tr data-image="' + value.picture +'">';
			rows = rows + '<td>'+value.published_date+'</td>';
			rows = rows + '<td>'+value.author+'</td>';
			rows = rows + '<td>'+value.title+'</td>';
			rows = rows + '<td data-id="'+value.id+'">';
			rows = rows + '<button data-toggle="modal" data-target="#view-book" class="btn btn-primary btn-sm view-book mr-2">View Details</button>';
			rows = rows + '<button data-toggle="modal" data-target="#edit-book" class="btn btn-warning btn-sm edit-book mr-2">Edit Book</button>';
			rows = rows + '<button class="btn btn-danger btn-sm delete-book mr-2">Delete</button>';
			rows = rows + '</td>';
			rows = rows + '</tr>';
		});
		$("tbody").html(rows);
		$('.picture_container').html('<img src="img/default.jpg">');
	}
	
	/* Display picture of books */
	$('#table_content tbody').on('click', 'tr', function() {
		
		var picture_name = $(this).attr('data-image');
		var picture_path = 'img/' + picture_name;
		$('.picture_container').html('<img src="'+picture_path+'">');
	});
	
});