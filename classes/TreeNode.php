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

Class TreeNode {
	private $cid = -1; // Comment id
	private $message = ''; // Message text
	private $author = ''; // Author name
	private $time = ''; // The time when comment has been posted
	private $parent = null; // Comment id of the parent comment
	private $children = false; // If the node has children 1 otherwise 0 (hasChildren() method returns true/false)
	private $childrenList = null; // Array with children objects
	
	public function __construct() {
		if ($this->hasChildren()) {
			// Connect to database
			require 'includes/dbconnect.php';
			
			// Get comments from database
			$res = $handler->query('
				SELECT `cid`, `message`, `parent`, `children`, `time`, `author_name` AS `author` 
				FROM `comment`
				WHERE `parent` = ' . $this->cid . '
				ORDER BY `time` DESC
			');
			
			if ($res->rowCount() === 0) { // If table is empty
				throw new Exception('Error: Database returned no results');
			}
			
			$res->setFetchMode(PDO::FETCH_CLASS, 'TreeNode');
			
			// Add children to node
			while ( $result = $res->fetch() ) {
				$this->addChild($result);
			}
		}
	}
	
	public function getCid() {
		return $this->cid;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function getParent() {
		return $this->parent;
	}
	
	public function hasChildren() {
		if ($this->children == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function getChildren() {
		return $this->childrenList;
	}
	
	private function addChild($child) {
		$this->childrenList[$child->getCid()] = $child;
	}
}
?>