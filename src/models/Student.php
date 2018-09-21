<?php

require_once 'core/Model.php';
class Student extends Model {
	private $table_name = "jrd_student";

	/**
		function to fetch students from DB
		@PARAM $offset (default to 0)
		@PARAM $limit (default to 0)
		@PARAM $searchQuery (default to blank array)
		@RETURN array of student records
	**/
	public function getStudents($offset = 0, $limit = 20, $searchQuery = array()) {
		$dbh = $this->prepareSelectFunction($offset, $limit, $searchQuery);
		$dbh->execute();
		$data = array();
		if($count = $dbh->rowCount()) {
			$data['result'] = $dbh->fetchAll(PDO::FETCH_ASSOC);
			$dbh = $this->db->prepare('select FOUND_ROWS()');
			$dbh->execute();
			$totalCount = $dbh->fetch();
			$data['count'] = $totalCount;
			return $data;
		} else {
			return array('count' => 0, 'result' => array());
		}
	}

	/**
		function to delete student record from DB
		@PARAM $id student_id (default to 0)
		@RETURN boolean success/error
	**/
	public function deleteStudent ($id) {
		$qry = "DELETE from $this->table_name WHERE id=?";
		$dbh = $this->db->prepare($qry);
		$dbh->execute(array($id));
		if($dbh->rowCount()) {
			return true;
		} else {
			return false;
		}
	}

	/**
		function to add student in DB
		@PARAM $student object
		@RETURN boolean success/error
	**/
	public function addStudent ($student) {
		$qry = "INSERT INTO $this->table_name (first_name, last_name, dob, 	email, jrd_class_id, guardian_name, phone, year_joined) values (?,?,?,?,?,?,?,?)";
		try {
			$dbh = $this->db->prepare($qry);
			$dbh->execute(
				array(
					$student['first_name'], 
					$student['last_name'], 
					$student['dob'], 
					$student['email'], 
					$student['jrd_class_id'], 
					$student['guardian_name'], 
					$student['phone'], 
					$student['year_joined']
				)
			);
		} catch (PDOException $e) {
			$message = "";
			if( $e->errorInfo[1] === 1062) {
				$message = "Email Alraedy exists";
			}
			return array('status' => false, "message" => $message);
		}
		return array('status' => true);
	}

	/**
		function to update student in DB
		@PARAM $student object
		@RETURN boolean success/error
	**/
	public function updateStudent ($id, $student) {
		$qry = "UPDATE $this->table_name SET first_name=?, last_name=?, dob=?, 	email=?, jrd_class_id=?, guardian_name=?, phone=?, date_updated=now(), year_joined=? where id=?" ;
		try {
			$dbh = $this->db->prepare($qry);
			$params = array(
					$student['first_name'], 
					$student['last_name'], 
					$student['dob'], 
					$student['email'], 
					$student['jrd_class_id'], 
					$student['guardian_name'], 
					$student['phone'], 
					$student['year_joined'],
					$id
				);
			$dbh->execute($params);
		} catch (PDOException $e) {
			$message = "";
			if( $e->errorInfo[1] === 1062) {
				$message = "Email Alraedy exists";
			}
			print_r( $e);
			return array('status' => false, "message" => $message);
		}
		return array('status' => true);
	}

	/**
		@PRIVATE function
		to prepare the db handler with select query
		@RETURNS db handler
	**/
	private function prepareSelectFunction ($offset, $limit, $searchQuery) {
		$qry = "SELECT SQL_CALC_FOUND_ROWS  $this->table_name.*, jrd_class.class_name from $this->table_name left join jrd_class on jrd_class.id = jrd_class_id ";
		$whereClause = "";
		$searchValues = array();
		if(count($searchQuery) > 0){
			foreach ($searchQuery as $key => $value) {
				if($value == "" || is_null($value)) {
					continue;
				}
				switch ($key) {
					case "first_name" : $whereClause .= ($whereClause === "") ? " where $key LIKE :$key  " : " and $key LIKE :$key  ";
										$searchValues[$key] = $value;
										break;

					case "min_date" : 	$minDate = date('Y-m-d H:i:s', strtotime($value));
										$whereClause .= ($whereClause === "") ? " where date_added >= :$key  " : " and date_added >= :$key  ";
										$searchValues[$key] = $minDate;
										break;

					case "max_date" : 	$maxDate = $stop_date = date('Y-m-d H:i:s', strtotime($value . ' +1 day'));
										$whereClause .= ($whereClause === "") ? " where date_added <= :$key  " : " and date_added <= :$key  ";
										$searchValues[$key] = $maxDate;
										break;
				}
			}
		}
		$lmitAndOffset =" ORDER by date_added desc LIMIT :lmt OFFSET :offst"; 
		$finalQry =  $qry.$whereClause.$lmitAndOffset;
		$dbh = $this->db->prepare($finalQry);
		$dbh->bindValue(':offst', (int) $offset, PDO::PARAM_INT); 
		$dbh->bindValue(':lmt', (int) $limit, PDO::PARAM_INT); 
		foreach($searchValues as $k=>$v) {
			if($k === "first_name") {
				$dbh->bindValue(":$k", "%".$v."%");
			} else {
				$dbh->bindValue($k, $v);
			}
		}
		return $dbh;
	}
}