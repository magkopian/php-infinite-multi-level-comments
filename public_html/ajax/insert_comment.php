<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

require __DIR__ . '/../../vendor/autoload.php';

if ( isset($_POST['msg'], $_POST['parent'], $_POST['author-name'], $_POST['author-email'], $_POST['author-surname'], $_POST['sid']) ) {

	$sid = (int) $_POST['sid'];
	$msg = trim($_POST['msg']);
	
	if ( empty($_POST['parent']) ) {
		$parent = null;
	}
	else {
		$parent = (int) $_POST['parent'];
	}
	
	$author_name = trim($_POST['author-name']);
	$author_email = trim($_POST['author-email']);
	
	$status_msg = array();
	
	// Author surname must be empty, is supposed to be filled only by bots
	if ( (!empty($msg) || $msg === '0') && !empty($author_name) && !empty($author_email) && empty($_POST['author-surname']) ) {
		
		// Validate comment length
		if ( Validation::len($msg, 255, 1) !== true ) {
			$status_msg[] = 'Your comment cannot exceed 255 characters';
		}
	
		// Validate parent sid
		if ( Validation::sid($sid) !== true ) {
			$status_msg[] = 'Invalid section ID';
		}
		
		// Validate parent id
		if ( Validation::parent($parent) !== true ) {
			$status_msg[] = 'Invalid parent ID';
		}
		
		// Validate author name
		if ( Validation::username($author_name) !== true ) {
			$status_msg[] = 'Invalid name';
		}
		
		// Validate email address
		if ( Validation::email($author_email) !== true ) {
			$status_msg[] = 'Invalid email address';
		}
		
		// If all user provided data is valid and trimmed
		if ( $status_msg === array() ) {
		
			$comment_handler = new CommentHandler();
			
			// Insert the comment
			if ( ( $msg_id = $comment_handler->insert_comment($sid, $msg, $parent, $author_name, $author_email) ) !== false ) {
				$response = array (
					'status_code' => 0,
					'message_id' => $msg_id,
					'author' => $author_name
				);
			}
			else {
				$response = array ( // Database error
					'status_code' => 4,
					'status_msg' => array('An error has been occurred')
				);
			}
			
		}
		else {
			$response = array ( // User provided invalid data
				'status_code' => 3,
				'status_msg' => $status_msg
			);
		}
			
	}
	else {
		$response = array ( // One or more fileds are empty (or author-surname is not empty only possible if bot)
			'status_code' => 2,
			'status_msg' => array('You must fill all fields')
		);
	}
}
else {
	$response = array ( // One or more fileds are not set or author-surname is set (possible only when script is direct accessed)
		'status_code' => 1,
		'status_msg' => array('An error has been occurred')
	);
}

header('Content-type: application/json');
echo json_encode($response);