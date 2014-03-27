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

function validate_len ($str, $max_len, $min_len = 1) {
	if ($max_len !== 'inf') {
		if (mb_strlen($str, 'UTF-8') > $max_len || mb_strlen($str, 'UTF-8') < $min_len) {
			return false;
		}
	}
	else {
		if (mb_strlen($str, 'UTF-8') < $min_len) {
			return false;
		}
	}
	return true;
}

function validate_parent($parent) {
	if ($parent === null) { // If parent is null
		return true;
	}
	else if ($parent < 1) { // If parent not positive
		return false;
	}
	else {
		// Check if parent id exists
		
		// Connect to database
		try {
			require_once '../classes/Database.php';
			$handler = new Database();
			
			// Query database to see if parent id exists
			$res = $handler->prepare('SELECT `cid` FROM `comment` WHERE `cid` = :parent');
			$res->execute( array(
				':parent' => $parent
			));
		}
		catch (PDOException $e) {
			return false;
		}
		catch (Exception $e) {
			return false;
		}
		
		if ($res->rowCount() === 1) {
			return true;
		}
		
		return false;
	}
}

function validate_username ($uname) {
	$regex = '/^([\p{Greek}a-zA-Z0-9]*[\p{Greek}a-zA-Z][\p{Greek}a-zA-Z0-9]*)$/'; //allow usernames that use letters (Latin or Greek) and or digits but have at least one letter inside
	if (validate_len($uname, 40, 3) === false || preg_match($regex, $uname) === 0) {
		return false;
	}
	return true;
}

function validate_email($email) {
	if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
		return false;
	}
	else {  
		$domain = explode('@',$email);
		$domain = array_pop($domain);
		
		if ( !(checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) ) {
			return false;
		}
		
	}
	
	return true;
}
?>