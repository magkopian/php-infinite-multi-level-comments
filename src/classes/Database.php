<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

class Database extends PDO {
	const DATABASE = 'inf_comments';
	const HOST = '127.0.0.1';
	const USER = 'Manolis';
	const PASSWORD = 'qwe/789';

	public function __construct() {
		parent::__construct('mysql:host=' . $this::HOST . ';dbname=' . $this::DATABASE, $this::USER, $this::PASSWORD);
		$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}
