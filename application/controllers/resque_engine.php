<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resque_engine extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('UTC');
		if ( ! $this->input->is_cli_request())
		{
			show_error('You cannot start the Resque engine from the web!  Use the command line!', 409, 'Must Use The Command Line');
		}
	}
	
	public function index()
	{
		global $argv;
		$command_line = implode(' ', $argv);
		
		fwrite(STDOUT, "USAGE: {$command_line} ( scheduler | workers )\n");
		fwrite(STDOUT, "\n");
		fwrite(STDOUT, "\tscheduler: Start the Resque Scheduler process.\n");
		fwrite(STDOUT, "\tworkers:   Start the Resque Worker process(es).\n");
		fwrite(STDOUT, "\n");
		fwrite(STDOUT, "The configuration options for each of the engine types above are set in the ");
		fwrite(STDOUT, "resque_engine controller, but can be overridden by specifying them at the ");
		fwrite(STDOUT, "beginning of the command line.\n");
		fwrite(STDOUT, "\n");
	}
	
	public function scheduler()
	{
		require_once FCPATH . '..' . DIRECTORY_SEPARATOR . 'resque-scheduler.php';
	}

	public function workers()
	{
		if (getenv('COUNT') === FALSE)
		{
			putenv('COUNT=5');
		}
		
		if (getenv('QUEUE') === FALSE)
		{
			putenv('QUEUE=default');
		}
		
		require_once FCPATH . '..' . DIRECTORY_SEPARATOR . 'resque-workers.php';
	}
}

/* End of file resque_engine.php */
/* Location: ./application/controllers/resque_engine.php */