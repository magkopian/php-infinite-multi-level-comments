<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

	define('INCLUDED',true); // Step 1. Add this define
	require 'includes/markup_func.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Infinite level comments</title>
		
		<link rel="stylesheet" type="text/css" href="css/comments.css"> <!-- Step 2. Include comments.css -->
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> <!-- Step 3. Include jQuery -->
		<script type="text/javascript" src="js/comments.js"></script> <!-- Step 4. Include comments.js -->
	</head>
	<body>
		<div id="container">
			<img src="http://farm8.staticflickr.com/7302/12837838873_7db7f47eca_n.jpg" title="Painting" alt="Image from: http://www.flickr.com/photos/penlr/">
		</div>
		<div class="comment-section"> <!-- Step 5. Create a div with class "comment-section" -->
			<?php do_comments();?> <!-- Step 6. Inside tha div call do_comments() function -->
		</div>
	</body>
</html>
	