<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

	define('INCLUDED',true);
	require 'markup_func.php';
	header('HTTP/1.1 403 Forbidden');
	do_html_403();
	die();
?>