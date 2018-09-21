<?php

require_once 'Database.php';
class Model {
	protected $db;

	function __construct () {
		//DB Handler
		$this->db = Database::connect()->database;
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}