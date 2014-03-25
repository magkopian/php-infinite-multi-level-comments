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
	// Connect to database
	try {
		require 'dbconnect.php';
	}
	catch (PDOException $e) {
		return false;
	}
	
	require 'classes/TreeNode.php';
	
	// Get root nodes
	try {
		$res = $handler->query('
			SELECT `cid`, `message`, `parent`, `children`, `time`, `author_name`  AS `author`
			FROM `comment`
			WHERE `parent` IS NULL
			ORDER BY `time` DESC
		');
		
		if ($res->rowCount() === 0) { // If table is empty
			return -1;
		}
		
		// Each root node will make a query to ask for its children
		$res->setFetchMode(PDO::FETCH_CLASS, 'TreeNode');
		
		// Add root nodes to the tree
		$tree = array();
		while ( $result = $res->fetch() ) {
			$tree[$result->getCid()] = $result;
		}
	}
	catch (PDOException $e) {
		return false;
	}
	catch (Exception $e) { // Database returned no children while children field in database is 1
		return false;
	}
	
	return $tree;
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