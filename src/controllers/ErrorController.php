<?php
require_once 'core/Controller.php';

/**
	Error controller to display error page
**/
class ErrorController extends Controller {
	public function indexAction() {
		$this->view->renderPartial('src/views/error/index.phtml');
	}
}
?>
