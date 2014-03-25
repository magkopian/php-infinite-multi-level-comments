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

if (!defined('DATABASE')) {
	define('DATABASE', 'inf_comments'); // The same as the database name you created
}
if (!defined('HOST')) {
	define('HOST', '127.0.0.1'); // Most of the times
}
if (!defined('USER')) {
	define('USER', 'root'); // Probably root on your localhost
}
if (!defined('PASSWORD')) {
	define('PASSWORD', ''); // Probably empty on your localhost
}

$handler = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
$handler->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>