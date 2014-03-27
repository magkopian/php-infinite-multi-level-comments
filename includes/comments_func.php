<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

if (!defined('INCLUDED')){
	define('INCLUDED',true);
	require 'markup_func.php';
	header('HTTP/1.1 403 Forbidden');
	do_html_403();
	die();
}

function get_comments() {	
	require 'classes/TreeNode.php';
	
	try {
		$tree = new TreeNode(true); // We create a peudo-node that will fetch all node with null parent
	}
	catch (Exception $e) {
		return false;
	}
	
	return $tree->getChildren($tree); // We don't want the peudo-node so we just return its children
}

function insert_comment($msg, $parent, $author_name, $author_email) {
	// Connect to database
	try {
		require 'dbconnect.php';
		
		// Insert comment to database
		if ($parent !== 'NULL') {
			$handler->beginTransaction(); // If comment has a parent begin transaction
		}
		
		$res = $handler->prepare('INSERT INTO `comment`(`author_name`, `author_email`, `message`, `parent`) VALUES (:author_name, :author_email, :message, :parent)');
		$res->execute( array(
			':author_name' => $author_name,
			':author_email' => $author_email,
			':message' => $msg,
			':parent' => $parent
		));
		
		if ($res->rowCount() !== 1) {
			return false;
		}
		
		// Get cid of last comment
		$cid = $handler->lastInsertId();
		
		if ($parent !== 'NULL') {
			$res = $handler->prepare('UPDATE `comment` SET `children` = 1 WHERE `cid` = :parent');
			$res->execute( array(
				':parent' => $parent
			));
			$handler->commit(); // Commit only if both queries succeed
		}
	}
	catch (PDOException $e) {
		if ($parent !== 'NULL') {
			$handler->rollback();
		}
		return false;
	}
	
	return $cid;
}
?>