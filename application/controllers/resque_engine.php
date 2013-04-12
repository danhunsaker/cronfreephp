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

	public function scheduler()
	{
		require_once FCPATH . 'resque-scheduler.php';
	}

	public function workers()
	{
		putenv('COUNT=5');
		putenv('QUEUE=default');
		require_once FCPATH . 'resque-workers.php';
	}
}

/* End of file resque_engine.php */
/* Location: ./application/controllers/resque_engine.php */