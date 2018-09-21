<?php

class Bootstrap {

	/**
		Get the url from Request URI and decide the controller to load
	**/
	public function __construct () {
		//Router
		error_reporting(E_ALL);
		
		$parts = explode('?', rtrim($_SERVER['REQUEST_URI'], '?'));
		$tokens = explode('/', rtrim($parts[0], '/'));
		if(!isset($tokens[1])) { //If no extra url
			require_once('src/controllers/StudentController.php');
			$controller = new StudentController;
			$controller->indexAction();
			die();
		}

		$controllerName = ucfirst($tokens[1]) . "Controller";;
		if(file_exists('src/controllers/'.$controllerName.'.php')) { //If controller file exists
			require_once('src/controllers/'.$controllerName.'.php');
			$controller = new $controllerName;
			if(isset($tokens[2])) { //If action name recieved
				$actionName = $tokens[2] . 'Action';
				if(method_exists ($controller, $actionName)) {
					if(isset($tokens[3])) {
						$controller->{$actionName} ($tokens[3]);
					} else {
						$controller->{$actionName} ();
					}
				} else {
					$this->invalidRequest();
				}
			} else {
				$controller->indexAction();
			}
			
			
		} else {
			$this->invalidRequest();
		}
	}
	/**
		if invalid request the calling error controller
	*/
	private function invalidRequest () {
		require_once('src/controllers/ErrorController.php');
		$controllerName = 'ErrorController';
		$controller = new $controllerName;
		$controller->indexAction();
	}
}


