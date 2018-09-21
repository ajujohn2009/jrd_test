<?php

require_once 'core/Model.php';

/**
	Model for jrd_classs table
**/
class JRDClass extends model {

	private $table_name = "jrd_class";
	
	/**
		TO fetch all classes form DB
		@returns all classes reocrd
	**/
	public function getAllClasses () {
		$qry = "SELECT * from $this->table_name";
		$dbh = $this->db->prepare($qry);
		$dbh->execute();
		if($dbh->rowCount()) {
			return $dbh->fetchAll();
		} else {
			return array();
		}
	}
}