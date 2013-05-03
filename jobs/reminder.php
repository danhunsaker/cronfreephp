<?php

class Reminder extends SuperJob
{
	public function perform()
	{
		$this->success = TRUE;
		$this->status = "{$this->args['email']}: This is a reminder!\n\n{$this->args['note']}\n\n";
	}
}