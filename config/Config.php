<?php

class Config {

	private static $db_config = array(
			'mysql' => array(
				'username' => 'aju',		// username for the Database 
				'password' => 'ajujohn',	// password for the Database
				'database' => 'jrd_test',	// name of the Database
				'host' => 'localhost'		//hostname
			)
		);


	public static function get ($path = null) {
		if($path) {
			$paths = explode('/', $path);
			$config = self::$db_config;
			foreach ($paths as $key => $value) {
				if(isset($config[$value])) {
					$config = $config[$value];
				}
			}
			return $config;
		} 
	}
	public static $pageSize = 10;
}