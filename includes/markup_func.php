<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

if (!defined('INCLUDED')){
	header('HTTP/1.1 403 Forbidden');
	do_html_403();
	die();
}


function do_html_403() { ?>
<!DOCTYPE html">
<html>
	<head>
		<title>403 Forbidden</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>403 Forbidden</h1>
		<p>You don&#39;t have permission to access <strong><?=$_SERVER['SCRIPT_NAME']?></strong> on this server.</p>
	</body>
</html>
<?php
}

function do_comments() {
	require 'comments_func.php';
	
	// Get comments
	if ( ( $comments = get_comments() ) === false ) {
		echo 'An error has been occurred'; // If database error
	}
	else if ( $comments == -1 ) { // If no comment exist yet
		?>
		<ul class="message-body" id="">
			<li class="reply-button">Click to add a comment...</li>
			<li style="display: none;" class="msg-text">
				<input type="text" name="author-name" placeholder="Name" class="txtfield">
				<input type="text" name="author-surname" placeholder="Surname" class="txtfield">
				<input type="text" name="author-email" placeholder="Email" class="txtfield">
				<textarea placeholder="Message"></textarea>
			</li>
			<li style="display: none;" class="hide-reply-box">Click to hide</li>
		</ul>
		<ul>
			<li>
				<ul class="message-body">
				</ul>
			</li>
		<ul>
		<?php
	}
	else {
		?>
		<ul class="message-body" id="">
			<li class="reply-button">Click to add a comment...</li>
			<li style="display: none;" class="msg-text">
				<input type="text" name="author-name" placeholder="Name" class="txtfield">
				<input type="text" name="author-surname" placeholder="Surname" class="txtfield">
				<input type="text" name="author-email" placeholder="Email" class="txtfield">
				<textarea placeholder="Message"></textarea>
			</li>
			<li style="display: none;" class="hide-reply-box">Click to hide</li>
		</ul>
		<?php
		
		// Generate comment markup and return
		echo do_comment_tree_disp($comments);
	}
	?>
	<div class="error message">
		<h3>Error:</h3>
		<p></p>
	</div>
	<div class="warning message">
		<h3>Warning:</h3>
		<p></p>
	</div>
<?php
}

function do_comment_tree_disp($tree) {
	$markup = '<ul>';
	
	foreach($tree as $twig) {
		$markup .= '<li>
						<ul class="message-body" id="'. $twig->getCid() . '">
							<li class="author">' . htmlentities($twig->getAuthor(), ENT_QUOTES, 'UTF-8') . ':</li>
							<li class="comment-msg">' . htmlentities($twig->getMessage(), ENT_QUOTES, 'UTF-8') . '</li>
							<li class="reply-button">Click to reply...</li>
							<li class="msg-text">
								<input type="text" name="author-name" placeholder="Name" class="txtfield">
								<input type="text" name="author-surname" placeholder="Surname" class="txtfield">
								<input type="text" name="author-email" placeholder="Email" class="txtfield">
								<textarea placeholder="Message"></textarea>
							</li>
							<li class="hide-reply-box">Click to hide</li>
						</ul>';
		
		// If the node has children inject them in a <ul> tag under parent node
		if ($twig->hasChildren()) {
			$markup .= do_comment_tree_disp($twig->getChildren());
		}

		$markup .= '</li>';	
	}
	
	return $markup . '</ul>';
}
?>