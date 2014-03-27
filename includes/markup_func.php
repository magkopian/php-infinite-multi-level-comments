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
?>