<?php

class View {
	public function __construct() {

	}
	public function render ($viewScript) {
		$this->main_contents = $viewScript;
		require('src/layout/layout.phtml');
	}

	public function renderPartial ($viewScript, $data = array()) {
		$this->viewData = $data;
		// $this->main_contents = $viewScript;
		require($viewScript);
	}
}