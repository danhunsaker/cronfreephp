<?php

class Resque
{
	public function __construct()
	{
		$composer_autoload = FCPATH . '../vendor/autoload.php';
		if (file_exists($composer_autoload)) {
			require_once $composer_autoload;
		}

		if ( ! class_exists('Composer\Autoload\ClassLoader', false) OR ! class_exists('Resque')) {
			throw new Exception(
				'You need to set up the project dependencies using the following commands:' . PHP_EOL .
				'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
				'php composer.phar install' . PHP_EOL
			);
		}
	}
	
	public function __call($method, $args)
	{
		if (is_callable("Resque::{$method}"))
		{
			return call_user_func_array("Resque::{$method}", $args);
		}
		return;
	}
	
}