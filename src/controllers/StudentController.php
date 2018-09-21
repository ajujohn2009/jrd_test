<?php
require_once 'core/Controller.php';
require_once 'src/models/Student.php';

/**
	Student controller
	To manage the Student Reocords
	Relation with Class controller
**/

class StudentController extends Controller {

	public function indexAction($param = 1) {
		$this->view->students = [];
		$this->view->render('src/views/index/index.phtml');
	}

	/**
		@public method
		To list the Student based on the offset and limit
		@Returns: JSON object of success/error obj
	**/
	public function getStudentDataAction ($offset=0, $limit=20, $whereClause = "") {
		$model = new Student;
		$data = $model->getStudents($_GET['offset'], $_GET['limit'], $_GET['search_query']);
		$result = array();
		foreach($data['result'] as $k => $obj) {
			$result[$k] = $this->prepareStudentObjectForDataTable($obj);
		}
		echo json_encode(array('data' => $result, 'offset' => $data['count'], 'limit' => 10));
	}

	/**
		@public method
		Endpoint to delete the student record
		@Returns: JSON object of success/error obj
	**/
	public function deleteStudentDataAction () {
		$data = false;
		if(isset($_POST['student_id'])) {
			$model = new Student;
			$data = $model->deleteStudent($_POST['student_id']);
		}
		echo json_encode(array('success' => $data));
	}

	/**
		@public method
		Endpoint to add the student record
		@Returns: JSON object of success/error obj
	**/
	public function addStudentAction () {
		$data = false;
		if(isset($_POST['student'])) {
			$model = new Student;
			$data = $model->addStudent($_POST['student']);
		}
		echo json_encode($data);
	}

	/**
		@public method
		Endpoint to update the student record
		@Param
		@Returns: JSON object of success/error obj
	**/
	public function updateStudentAction ($id) {
		$data = false;
		if(isset($_POST['student'])) {
			$model = new Student;
			$data = $model->updateStudent($id, $_POST['student']);
		}
		echo json_encode($data);
	}

	/**
		@private method
		To Prepare data for DataTable in UI
		@Param: it will take the student object
		@Returns: DataTable record
	**/
	private function prepareStudentObjectForDataTable ($data) {
		$i = 0;
		$result = array();

		$result[$i++] = $data['id'];
		$result[$i++] = $data['first_name'];
		$result[$i++] = $data['last_name'];
		$result[$i++] = date("M j, Y", strtotime($data['dob']));
		$result[$i++] = $data['email'];
		$result[$i++] = $data['class_name'];
		$result[$i++] = $data['guardian_name'];
		$result[$i++] = $data['phone'];
		$result[$i++] = date("M j, Y, g:i A", strtotime($data['date_added']));
		$result[$i++] = date("M j, Y, g:i A", strtotime($data['date_updated']));
		$result[$i++] = $data['year_joined'];
		$result['id'] = $data['id'];
		$result['first_name'] = $data['first_name'];
		$result['last_name'] = $data['last_name'];
		$result['dob'] = $data['dob'];
		$result['email'] = $data['email'];
		$result['class_name'] = $data['class_name'];
		$result['jrd_class_id'] = $data['jrd_class_id'];
		$result['guardian_name'] = $data['guardian_name'];
		$result['phone'] = $data['phone'];
		$result['date_added'] = $data['date_added'];
		$result['date_updated'] = $data['date_updated'];
		$result['year_joined'] = $data['year_joined'];
		return $result;
	}
}
?>
