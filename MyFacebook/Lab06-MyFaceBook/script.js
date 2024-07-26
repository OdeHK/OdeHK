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
			
		}
}