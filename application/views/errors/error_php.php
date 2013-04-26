<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2013, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (php_sapi_name() === 'cli' OR defined('STDIN'))
{
	fwrite(STDERR, "A PHP Error was encountered\n");
	fwrite(STDERR, "\n");
	fwrite(STDERR, "Severity: {$severity}\n");
	fwrite(STDERR, "Message:  {$message}\n");
	fwrite(STDERR, "Filename: {$filepath}\n");
	fwrite(STDERR, "Line Number: {$line}\n");
	fwrite(STDERR, "\n");

	if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
	{
		fwrite(STDERR, "Backtrace:\n");
		foreach(debug_backtrace() as $error)
		{
			if(isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
			{
				fwrite(STDERR, "\tFile: {$error['file']}\n");
				fwrite(STDERR, "\tLine: {$error['line']}\n");
				fwrite(STDERR, "\tFunction: {$error['function']}\n");
				fwrite(STDERR, "\t\n");
			}
		}
	}
	return;
}
//	else:
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace: </p>
	<?php foreach(debug_backtrace() as $error): ?>

		<?php if(isset($error['file']) &&
		         strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?></p>

<?php endif ?>

</div>