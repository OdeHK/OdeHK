<?php
require_once('includes_all.php');

SessionManager::debugSessionInfo();

if (!SessionManager::isUserLoggedIn())
{
	header("Refresh:0; url=login.php");
}

$username = $_SESSION['username'];

$postModel = new Post();
$posts = $postModel->getAllPosts();

if (isset($_POST['Logout']))
{
	header("Refresh:0; url=logout.php");
	die();
}
if (isset($_POST['Change_Password']))
{
	header("Refresh:0; url=changepassword.php");
	die();
}

?>
<html>
	<head>
		<link href="post.css" rel="stylesheet">
		<link href="fbpost.css" rel="stylesheet">
		<link href="chat/chat.css" rel="stylesheet">
		
		<script type="text/javascript" charset="utf8" src="js/jquery-3.5.0.min.js"></script>
		
		<!-- POST, COMMENT CRUD AJAX -->
		<script src="script.js"></script>
		
		<!-- CHAT AJAX -->
		<script src="js/socket.io.js"></script>
		<script src="js/chatscript.js"></script>
		
		<meta name="Description" content="Facebook Style Homepage"/>
	</head>
	
	<body>
		<div class="homepage-header">
			<span style="display:inline-block; margin:11px";>Welcome to MyFacebook</span>
			
			<?php 
				// Admin button for Admin view
				if(SessionManager::isAdmin()){ 
					echo "<a class='Logout' href='admin.php'>Admin</a>";
				} 
			?>
			<a class="Logout" href="changepassword.php">Change password</a>
			<a class="Logout" href="logout.php">Logout</a>
			
		</div>
		
		<section>
			<div class="text">
				<textarea minlength="1" placeholder="What's in your mind, <?php echo htmlentities(SessionManager::getFullname());?>?"></textarea>
				<input class="addPost" type="submit" value="Post"/>
			</div>
			<!-- Using AJAX in script.js to create a new post -->
		</section>
		
		<div class="listPost">
			<?php
				foreach($posts as $post)
				{
			?>
			<div class="f-card" id="div_<?php echo htmlentities($post->id);?>">
				<!-- HEADER OF THE POST -->
				<div class="header">
					<div class="options">
						<i class="fa fa-chevron-down"></i>
					</div>
					<img class="co-logo" src="https://placehold.it/40x40" />
					<div class="co-name">
						<a href="#"><?php echo htmlentities($post->owner->fullname); ?> </a>
						<?php
							if ($post->owner->id == SessionManager::getUserId())
							{
						?>
						<input id="editable_<?php echo htmlentities($post->id); ?>" class="editable" type="submit" value="Edit"/>
						<input id="remove_<?php echo htmlentities($post->id); ?>" class="remove" type="submit" value="Delete"/>
						<?php 
							} 
						?>
					</div>
					<div class="time">
						<a href="#">2hrs</a>
						<i class="fa fa-globe"></i>
					</div>
				</div>
				
				<!-- CONTENT OF THE POST -->
				<div class="content">
					<p id="edit_<?php echo htmlentities($post->id); ?>" class="Ediv">
						<?php
							echo htmlentities($post->message);
						?>
					</p>
				</div>
				
				<!-- SOCIAL BAR include LIKE BUTTON, NUMBER OF COMMENTs -->
				<div class="social">
					<div class="social-buttons">
						<span>
							<i class="fa fa-comment"></i>Comment
						</span>
						
						<span>
							<i class="icon"></i>
							<?php 
								echo htmlentities(count($post->comments)); 
							?>
						</span>
					</div>
				</div>
				
				<!-- COMMENTS LIST -->
				<div class="comment_list" id="comment_list_<?php echo htmlentities($post->id); ?>">
					<?php
						foreach($post->comments as $comment)
						{
					?>
					<div class="comment" id="comment_1">
						<div class="comment_author_profile_picture">
							<img class="co-logo" src="https://placehold.it/40x40" />
						</div>
						<div class="comment_details">
							<!-- Comment header -->
							<div class="comment_author">
								<span>
									<?php echo htmlentities($comment->owner->fullname); ?>
								</span>
							</div>
							
							<!-- Comment message -->
							<div class="comment_text">
								<p> <?php echo htmlentities($comment->comment); ?> </p>
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>
				
				<!-- Want to comment BAR -->
				<div class="Wcomment">
					<div class="comment_author_profile_picture">
						<img src="https://placehold.it/40x40" />
					</div>
					
					<div class="Wcomment_text">
						<textarea id="txtcomment_<?php echo $post->id; ?>" class="txtcomment" placeholder="Write a comment..."></textarea>
					</div>
				</div>
			</div>
			
			<?php 
				}
			?>
		</div>
		
		<div id="typing">
		
		</div>
		
		<div id="chat-sidebar">
		
		</div>
	</body>
</html>