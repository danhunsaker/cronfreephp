<?php

class CheckIn extends SuperJob
{
	public function perform()
	{
		if (is_a($this->instance, 'CI_Controller'))
		{
			$this->instance->load->database();
			$this->success = $this->instance->db->set($this->args)->insert('checkins');
			if ($this->success)
			{
				$this->status = 'Successfully checked in!';
			}
			else
			{
				$this->status = "Couldn't check in - {$this->db->_error_message()}";
			}
		}
		else
		{
			$this->success = FALSE;
			$this->status = "Couldn't check in - CodeIgniter not found.";
		}
	}
}