<?php
require_once('includes_all.php');

$response = array();

if (!SessionManager::isUserLoggedIn())
{
	$response['status'] = false;
	$response['data'] = "Unauthentication";
	
	echo json_encode($response);
	exit();
}

if (!isset($_POST['action']))
{
	$response['status'] = false;
	$response['data'] = "Invalid Method";
	
	echo json_encode($response);
	exit();
}

// Admin action
$action = $_POST['action'];

if($_POST['action_area'] == "admin")
{
	if (!SessionManager::isAdmin())
	{
		$response['status'] = false;
		$response['data'] = "You are not admin";
		
		echo json_encode($response);
		exit();
	}
}

// User action

if ($_POST['action_area'] == "user")
{
	// %1$s - for postIndex
	// %2$s - for postText
	// %3$s - for username/ post_title
	// These value will use for $html in saving data 
	// and use sprintf to add the attribute of the post into $html
	
	
	if($action == "new_post")
	{
		$postText = $_POST['post'];
		$post_image = isset($_FILES['post_image']) ? $_FILES['post_image'] : null;
		
		$post_model = new Post();
		
		$imagePath = '';
		if ($post_image && $post_image['error'] === UPLOAD_ERR_OK)
		{
			$imageName = time().'-'.basename($post_image['name']);
			$uploadDir = 'img/post/';
			
			$imagePath = $uploadDir . $imageName;
			// To have a good separation, we can create directory such as img/post/year/month/day
			// then we must create a new directory by 'mkdir'
			/*
			$yearDir = date("Y", time());
			$baseDir = 'img/post/';
			$uploadDir = $baseDir.yearDir.'/';
			
			// Check that the directory exited before upload
			if (!file_exists($uploadDir))
			{
				mkdir($uploadDir, 0777, true);
			}
			*/
			
			
			if (!move_uploaded_file($post_image['tmp_name'], $imagePath))
			{
				$response['status'] = false;
				$response['data'] = "Error uploading the file";
				
			}
			
		}
		
		
		$postInfo = $post_model->createPost($postText, $imagePath); // add image
		
		if ($postInfo)
		{
			$response['status'] = true;
			$html = 
					'<div class="f-card" id="div_%1$s">
						<div class="header">
							<div class="options">
								<i class="fa fa-chevron-down"></i>
							</div>
							
							<img class="co-logo" src="https://placehold.it/40x40" />
							<div class="co-name">
								<a href="#">%3$s</a>
								<input id="editable_%1$s" class="editable" type="submit" value="Edit" />
								<input id="remove_%1$s" class="remove" type="submit" value="Delete" />
							</div>
							<div class="time">
								<a href="#">2hrs</a>
								<i class="fa fa-globe"></i>
							</div>
						</div>
						
						<div class="content">
							<p id="edit_%1$s" class="Ediv">%2$s</p>
							%4$s
						</div>
						
						<div class="social">
							<div class="social-buttons">
								<span><i class="fa fa-comment"></i>Comment</span>
								<span><i class="icon"></i>0</span>
							</div>
						</div>
						
						<div class="comment_list" id="comment_list_%1$s"></div>
						
						<div class="Wcomment">
							<div class="comment_author_profile_picture">
								<img src="https://placehold.it/40x40" />
							</div>
							
							<div class="Wcomment_text">
								<textarea id="txtcomment_%1$s" class="txtcomment" placeholder="Write a comment..."></textarea>
							</div>
						</div>
					</div>';
			
			// If has image, adding <img> tag into html
			$imageHTML = $imagePath ? '<img src="'.htmlentities($imagePath).'" alt="Post Image">' : '';
			
			$response['data'] = sprintf($html, htmlentities($postInfo->id), htmlentities($postInfo->message), htmlentities($postInfo->owner->fullname), $imageHTML);
			
		}
		else 
		{
			$response['status'] = false;
			$response['data'] = "Error while posting";
		}
	}
	else if($action == "edit_post")
	{
		$post_id = $_POST['post_id'];
		$post = $_POST['post'];
		
		$post_model = new Post();
		
		$status = $post_model->editPost($post_id, $post);
		if ($status)
		{
			$response['status'] = true;
			$response['data'] = "OK";
		}
		else
		{
			$response['status'] = false;
			$response['data'] = "Error while editing post";
		}
	}
	else if ($action == "delete_post")
	{
		$post_id = $_POST['post_id'];
		$post_model = new Post();
		
		$status = $post_model->deletePost($post_id);
		
		if ($status)
		{
			$response['status'] = true;
			$response['data'] = "OK";
		}
		else
		{
			$response['status'] = false;
			$response['data'] = "Error while deleting post";
		}
	}
	// ACTIONS FOR COMMENTS
	else if ($action == "new_comment")
	{
		$commentModel = new Comment();
		$comment_text = $_POST['comment_text'];
		$postId = $_POST['post_id'];
		
		$commentInfo = $commentModel->createComment($postId, $comment_text);
		
		$comment_html = 
						'<div class="comment" id="comment_%s">
							<div class="comment_author_profile_picture">
								<img class="co-logo" src="http://placehold.it/40x40" />
							</div>
							<div class="comment_details">
								<div class="comment_author">
									<span>%s</span>
								</div>
								<div class="comment_text">
									<p>%s</p>
								</div>
							</div>
						</div>';
		
		$response['data'] = sprintf($comment_html, htmlentities($commentInfo->id), htmlentities($commentInfo->owner->fullname), htmlentities($commentInfo->comment));
	}
}

echo json_encode($response);
exit();
?>