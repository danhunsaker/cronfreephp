<?php

abstract class SuperJob
{
	public $job;
	public $args;
	public $queue;
	protected $instance;
	protected $success;
	protected $status;
	
	final public function setUp()
	{
		$job_type = get_class($this);
		echo "Starting {$job_type} job...\n";
		
		if (function_exists('get_instance'))
		{
			$this->instance = get_instance();
		}
		else
		{
			$this->instance = FALSE;
		}
	}
	
	abstract public function perform();
	
	final public function tearDown()
	{
		$job_type = get_class($this);
		echo "Finishing {$job_type} job...\n\n";
		
		if ( ! $this->success)
		{
			$this->job->fail(new Resque_Job_DirtyExitException($this->status));
		}
	}
}