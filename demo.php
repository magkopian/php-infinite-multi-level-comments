<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

define('INCLUDED',true); // Step 1. Add this define
require 'classes/CommentSection.php'; // Step 2. Add this require

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Infinite level comments</title>
		
		<link rel="stylesheet" type="text/css" href="css/comments.css"> <!-- Step 3. Include comments.css -->
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> <!-- Step 3. Include jQuery -->
		<script type="text/javascript" src="js/comments.js"></script> <!-- Step 5. Include comments.js -->
	</head>
	<body>
		<div id="container">
			<img src="http://farm8.staticflickr.com/7302/12837838873_7db7f47eca_n.jpg" title="Painting" alt="Image from: http://www.flickr.com/photos/penlr/">
		</div>
		<?php
			$comment_section = new CommentSection(); // Step 6. Create a new CommentSection Object
			$comment_section->doComments(); // Step 7. Call doComments Method
		?>
	</body>
</html>
	