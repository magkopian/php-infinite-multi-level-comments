<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

class HttpError {

	public function __construct ($errorCode) {
		if ($errorCode == 403) {
			$this->doError403();
		}
		else {
			throw new Exception('Error: Invalid error code');
		}
	}
	
	private function doError403() { 
		header('HTTP/1.1 403 Forbidden'); ?>
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
	
}
