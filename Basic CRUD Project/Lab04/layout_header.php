<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $page_title; ?></title>
	<!--Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!--Bootstrap ICON -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<!--CSS -->
	<link rel="stylesheet" href="assets/css/custom.css" />
</head>

<body>
	<!--container header-->
	<div class="container">
		<?php
			echo "<div class='mb-4 pb-2 border-bottom'>
					<h1>{$page_title}</h1>
				</div>";
		?>
	