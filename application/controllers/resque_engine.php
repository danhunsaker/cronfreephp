<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resque_engine extends CI_Controller {

	public function index()
	{
		if ($this->input->is_cli_request())
		{
			require_once FCPATH . 'resque-scheduler.php';
		}
		else
		{
			show_error('You cannot start the Resque scheduler from the web!  Use the command line!', 409, 'Must Use The Command Line');
		}
	}

}

/* End of file resque_engine.php */
/* Location: ./application/controllers/resque_engine.php */