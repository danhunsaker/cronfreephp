<?php

class Reminder extends SuperJob
{
	public function perform()
	{
		$this->success = TRUE;
		$this->status = "{$args['email']}: This is a reminder!\n\n{$args['note']}\n\n";
	}
}