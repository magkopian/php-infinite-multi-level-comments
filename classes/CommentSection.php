<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

if (!defined('INCLUDED')){
	define('INCLUDED',true);
	require 'HttpErrorGenerator.php';
	new HttpError(403);
	die();
}

class CommentSection {
	private $tree = null;
	private $status = true;
	private $display = '';

	public function __construct() {
		try {
			require 'TreeNode.php';
			
			$this->tree = new TreeNode(true); // We create a peudo-node that will fetch all node with null parent
		}
		catch (Exception $e) {
			$this->status = false;
		}
		
		$this->createDisplay();
	}
	
	public function doComments() {
		echo $this->display;
	}
	
	private function createDisplay () {
		$this->display .= '<div class="comment-section">';

		if ( $this->status === false ) {
			$this->display .= 
				'An error has been occurred'; // If database error
		}
		else if ( $this->tree->hasChildren() === false ) { // If no comment exist yet
			$this->display .= 
				'<ul class="message-body" id="">
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
				<ul>';
		}
		else {
			$this->display .= 
				'<ul class="message-body" id="">
					<li class="reply-button">Click to add a comment...</li>
					<li style="display: none;" class="msg-text">
						<input type="text" name="author-name" placeholder="Name" class="txtfield">
						<input type="text" name="author-surname" placeholder="Surname" class="txtfield">
						<input type="text" name="author-email" placeholder="Email" class="txtfield">
						<textarea placeholder="Message"></textarea>
					</li>
					<li style="display: none;" class="hide-reply-box">Click to hide</li>
				</ul>';
			
			// Generate comment markup and return
			$this->display .= $this->traverseTree($this->tree->getChildren()); // We don't want to display the pseudo-node so we pass its children
			
			$this->display .= '</div>';
		}
		
		$this->display .= 
			'<div class="error message">
				<h3>Error:</h3>
				<p></p>
			</div>
			<div class="warning message">
				<h3>Warning:</h3>
				<p></p>
			</div>';
	}
	
	private function traverseTree($tree) {
		$display = '<ul>';
		
		foreach($tree as $twig) {
			$display .= '<li>
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
				$display .= $this->traverseTree($twig->getChildren());
			}

			$display .= '</li>';	
		}
		
		return $display . '</ul>';
	}
	
}
?>