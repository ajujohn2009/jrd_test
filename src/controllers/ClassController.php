<?php
require_once 'core/Controller.php';
require_once 'src/models/JRDClass.php';

/**
	Class controller to manage the classes
	Reference is being used in Student Table
**/
class ClassController extends Controller {
	/**
		@public method
		Endpoint to get all classes record
		@Returns: JSON object of success/error obj
	**/
	public function getAllClassesAction () {
		$classes = new JRDClass;
		$result = $classes->getAllClasses();
		echo json_encode($result);
	}
}
?>
