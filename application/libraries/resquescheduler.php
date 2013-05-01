<?php

class CI_ResqueScheduler
{
	public function __construct()
	{
		$composer_autoload = FCPATH . '../vendor/autoload.php';
		if (file_exists($composer_autoload)) {
			require_once $composer_autoload;
		}

		if ( ! class_exists('Composer\Autoload\ClassLoader', false) OR ! class_exists('ResqueScheduler')) {
			throw new Exception(
				'You need to set up the project dependencies using the following commands:' . PHP_EOL .
				'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
				'php composer.phar install' . PHP_EOL
			);
		}
	}
	
	public function __call($method, $args)
	{
		if (is_callable("ResqueScheduler::{$method}"))
		{
			return call_user_func_array("ResqueScheduler::{$method}", $args);
		}
		return;
	}
	
}