//POST AND COMMENT CRUD AJAX
$(document).ready(function() {
	//CREATE NEW POST
	$(".addPost").click(function() {
		var post_text = $("textarea").val();
		
		if ($.trim($("textarea").val()) == '')
		{
			return alert("Please add some text to create new post!");
		}
		
		$("textarea").val('') //Clear textarea
		
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
		
		$.post("ajax_actions.php", {
			action_area: "user",
			dataType: 'html',
			action: "new_post",
			post: post_text,
			nextindex: nextindex
		}, function(data) {
			console.log(data);
			($(".listPost").prepend(data.data))
		}, "json");
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
	
});