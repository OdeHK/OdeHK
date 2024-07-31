//POST AND COMMENT CRUD AJAX
$(document).ready(function() {
	//CREATE NEW POST
	$(".addPost").click(function() {
		var post_text = $("textarea").val();
		
		// image file
		var post_image = $("#image")[0].files[0];
		
		if ($.trim($("textarea").val()) == '' && !post_image) // add condition for image
		{
			return alert("Please add some text or add an image to create new post!");
		}
		
		$("textarea").val('') //Clear textarea
		$("#image").val('');
		// clear browse file
		
		if($("div").hasClass("f-card"))
		{
			// Get total number of elements added
			var total_element = $(".f-card").length;
			// The list of posts will show the newest element at the top
			// so just need to get first element and get its id
			var lastId = $(".f-card:first").attr("id");
			
			// the value of "id" of the ".f-card" is "div_($post->id)"
			// then split_id = ["div", $post->id]
			var split_id = lastId.split("_");
			
			var nexindex = Number(split_id[1]) + 1;
		}
		else
		{
			var nextindex = 1;
		}
		
		var formData = new FormData();
		formData.append('action_area', 'user');
		formData.append('dataType', 'html');
		formData.append('action', "new_post");
		formData.append('post', post_text);
		if (post_image)
		{
			formData.append('post_image', post_image);
		}
		
		formData.append('nextindex', nextindex);
		/*
		$.post("ajax_actions.php", {
			action_area: "user",
			dataType: 'html',
			action: "new_post",
			post: post_text,
			post_image: post_image.name,
			nextindex: nextindex
		}, function(data) {
			console.log(data);
			($(".listPost").prepend(data.data))
		}, "json");
		*/
		$.ajax({
			url: 'ajax_actions.php',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function(data) {
				//console.log(data);
				$(".listPost").prepend(data.data);
			}
		});
	});
	
	// Make Post  edittable
	$(".listPost").on("click", ".editable", function() {
		var edit_id = this.id;
		console.log(edit_id);
		
		var split_id_edit = edit_id.split("_");
		var editedIndex = split_id_edit[1];
		console.log(editedIndex);
		
		$("#" + edit_id).val('Update');
		$("#" + edit_id).addClass("update");
		//content in <p>
		$("#edit_" + editedIndex).attr('contenteditable', 'true');
		$("#edit_" + editedIndex).focus();
		console.log($("#edit_" + editedIndex));
	});
		
	// Update the new edited POST
	$(".listPost").on("click", ".update", function() {
		var updated_id = this.id;
		var split_id_update = updated_id.split("_");
		var updatedIndex = split_id_update[1];
		
		$("#" + updated_id).val('Edit');
		$("#edit_" + updatedIndex).attr('contenteditable', 'false');
		$("#edit_" + updatedIndex).blur();
		// Remove class update once textarea is updated
		$("#" + updated_id).removeClass("update");
		
		var edited_post = $("#edit_" + updatedIndex).text();
		console.log(edited_post);
		
		$.post("ajax_actions.php", {
			action_area: "user",
			dataType: 'html',
			action: "edit_post",
			post_id: updatedIndex,
			post: edited_post,
		}, function(data) {
			console.log(data);
		}, "json");
	});
	
	// Delete POST
	$(".listPost").on("click", ".remove", function() {
		var id = this.id;
		var split_id = id.split("_");
		var deleteIndex = split_id[1];
		
		$.post("ajax_actions.php", {
			action_area: "user",
			action: "delete_post",
			post_id: deleteIndex
		}, function(data) {
			$("#div_" + deleteIndex).remove();
		}, "json");
	});
	
	// Add a new COMMENT
	$(".listpost").on("keypress", ".txtcomment", function(e) {
		// e is for the value of keypress
		
		//Handle First time COMMENT
		if (!($(this).hasClass("comment")))
		{
			var total_element = 0;
			var lastId = 'comment_0';
			var split_id = 0;
			var nextCommentIndex = 1;
		}
		else // Not the first comment
		{
			var total_element = $(".comment").length;
			var lastId = $(".comment:first").attr("id");
			var split_id = lastId.split("_");
			var nextCommentIndex = Number(split_id[1]) + 1;
		}
		
		// Handle Enter after new comment added
		if (e.keyCode == 13)
		{
			var id = this.id;
			var comment_listId = id.split("_")[1];
			
			var comment_text = $("#" + id).val();
			
			if ($.trim($(id).val()) == '')
			{
				// return alert("Please add some text to comment");
			}
			
			$("#" + id).val(''); // Clear the text box after add new
			
			console.log(comment_listId);
			
			$.post("ajax_actions.php", {
				action_area: "user",
				action: "new_comment",
				comment_text: comment_text,
				post_id: comment_listId
			}, function(data) {
				($("#comment_list_" + comment_listId).prepend(data.data))
			}, "json");
		}
	});
		
});