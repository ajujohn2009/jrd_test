<?php

class Config {
	public static function get ($path = null) {
		if($path) {
			$paths = explode('/', $path);
			$config = $GLOBALS['config'];
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