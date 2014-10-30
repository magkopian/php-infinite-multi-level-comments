<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

// Step 1: Include composer autoload file
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

// Step 2: Create a new CommentSection Object 
// (You need also to supply an ID for the comment section)
$comment_section = new CommentSection(1);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Infinite level comments</title>
		
		<!-- Step 3: Include comments.css, jQuery and comments.js -->
		<link rel="stylesheet" type="text/css" href="/css/comments.css">
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="/js/comments.js"></script>
	</head>
	<body>
		<div id="container">
			<img src="http://farm8.staticflickr.com/7302/12837838873_7db7f47eca_n.jpg" title="Painting" alt="Image from: http://www.flickr.com/photos/penlr/">
		</div>
		<?php // Step 4: Call doComments() method at the place you want to put the comment section
			$comment_section->doComments();
		?>
	</body>
</html>
	