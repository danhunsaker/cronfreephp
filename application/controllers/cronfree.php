<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cronfree extends CI_Controller
{
	protected $retval = array(
		'code' => 200,
		'data' => '',
	);
	
	public function index()
	{
		$this->load->view('home');
	}
	
	public function migrate($version = FALSE)
	{
		if ( ! $this->input->is_cli_request())
		{
			$this->show_error();
			return;
		}
		
		$this->load->database();
		$this->load->dbforge();
		$this->load->library('migration');
		
		if ($version === FALSE)
		{
			$this->migration->current();
		}
		else
		{
			$this->migration->version($version);
		}
	}
	
	public function demo()
	{
		switch ($this->input->method())
		{
			case 'get':
				$this->_demo_view();
				break;
			case 'post':
				call_user_func_array(array($this, '_demo_submit'), func_get_args());
				if ($this->retval['data'] === FALSE)
				{
					$this->retval['code'] = 503;
					$this->retval['data'] = 'Failed to enqueue requested job.';
				}
				else
				{
					$this->_demo_view();
				}
				break;
			default:
				$this->retval['code'] = 405;
				break;
		}
		
		$this->output->set_status_header($this->retval['code']);
		$this->output->set_output($this->retval['data']);
	}
	
	protected function _demo_view()
	{
		$this->load->library('resque');
		
		$queuelist = $this->resque->queues();
		$queuedata = array();
		foreach ($queuelist as $queuename)
		{
			$queuedata[$queuename] = $this->resque->size($queuename);
		}
		
		$this->retval['data'] = $this->load->view('demo', array('queues' => $queuedata), TRUE);
	}
	
	protected function _demo_submit($job_type)
	{
		$this->load->library('resque');
		$this->load->library('resquescheduler');
		$args = $this->input->post(NULL, TRUE);
		
		switch (strtolower($job_type))
		{
			case 'checkin':
				$this->retval['data'] = $this->resque->enqueue('standard', 'checkin', $args, TRUE);
				break;
			case 'reminder':
				$delay = $args['delay'];
				unset($args['delay']);
				$this->retval['data'] = $this->resquescheduler->enqueueIn($delay, 'high', 'reminder', $args);
				break;
			default:
				$this->retval['data'] = $this->resque->enqueue('illegal', $job_type, $args);
				break;
		}
	}
	
}

/* End of file cronfree.php */
/* Location: ./application/controllers/cronfree.php */ 