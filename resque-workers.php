<?php

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
}

if (!class_exists('Composer\Autoload\ClassLoader', false)) {
	die(
		'You need to set up the project dependencies using the following commands:' . PHP_EOL .
		'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
		'php composer.phar install' . PHP_EOL
	);
}

$QUEUE = getenv('QUEUE');
if(empty($QUEUE)) {
	die("Set QUEUE env var containing the list of queues to work.\n");
}

$REDIS_BACKEND = getenv('REDIS_BACKEND');
$REDIS_BACKEND_DB = getenv('REDIS_BACKEND_DB');
if(!empty($REDIS_BACKEND)) {
	if (empty($REDIS_BACKEND_DB)) 
		Resque::setBackend($REDIS_BACKEND);
	else
		Resque::setBackend($REDIS_BACKEND, $REDIS_BACKEND_DB);
}

$logLevel = 0;
$LOGGING = getenv('LOGGING');
$VERBOSE = getenv('VERBOSE');
$VVERBOSE = getenv('VVERBOSE');
if(!empty($LOGGING) || !empty($VERBOSE)) {
	$logLevel = Resque_Worker::LOG_NORMAL;
}
else if(!empty($VVERBOSE)) {
	$logLevel = Resque_Worker::LOG_VERBOSE;
}

$APP_INCLUDE = getenv('APP_INCLUDE');
if($APP_INCLUDE) {
	if(!file_exists($APP_INCLUDE)) {
		die('APP_INCLUDE ('.$APP_INCLUDE.") does not exist.\n");
	}

	require_once $APP_INCLUDE;
}

$interval = 5;
$INTERVAL = getenv('INTERVAL');
if(!empty($INTERVAL)) {
	$interval = $INTERVAL;
}

$count = 1;
$COUNT = getenv('COUNT');
if(!empty($COUNT) && $COUNT > 1) {
	$count = $COUNT;
}

function cleanup_children($signal){
	$GLOBALS['send_signal'] = $signal;
}

if($count > 1) {
	$children = array();
	$GLOBALS['send_signal'] = FALSE;
	
	$die_signals = array(SIGTERM, SIGINT, SIGQUIT);
	$all_signals = array_merge($die_signals, array(SIGUSR1, SIGUSR2, SIGCONT, SIGPIPE));
	
	for($i = 0; $i < $count; ++$i) {
		$pid = Resque::fork();
		if($pid == -1) {
			die("Could not fork worker ".$i."\n");
		}
		// Child, start the worker
		elseif(!$pid) {
			$queues = explode(',', $QUEUE);
			$worker = new Resque_Worker($queues);
			$worker->logLevel = $logLevel;
			$worker->hasParent = TRUE;
			fwrite(STDOUT, "\033[00;32m*** Starting worker {$worker}\033[00m\n");
			$worker->work($interval);
			fwrite(STDOUT, "\033[01;34m*** Stopping worker {$worker}\033[00m\n");
			break;
		}
		else {
			$children[$pid] = 1;
			while (count($children) == $count){
				if (!isset($registered)) {
					declare(ticks = 1);
					foreach ($all_signals as $signal) {
						pcntl_signal($signal,  "cleanup_children");
					}
					
					$PIDFILE = getenv('PIDFILE');
					if ($PIDFILE) {
						file_put_contents($PIDFILE, getmypid()) or
							die('Could not write PID information to ' . $PIDFILE);
					}
					
					$registered = TRUE;
				}
				
				if(function_exists('setproctitle')) {
					setproctitle('resque-' . Resque::VERSION . ": Monitoring {$count} children: [".implode(',', array_keys($children))."]");
				}
				
				$childPID = pcntl_waitpid(-1, $childStatus, WNOHANG);
				if ($childPID != 0) {
					fwrite(STDOUT, "\033[00;31m*** A child worker died: {$childPID}\n");
					unset($children[$childPID]);
					$i--;					
				}
				usleep(250000);
				if ($GLOBALS['send_signal'] !== FALSE){
					foreach ($children as $k => $v){
						posix_kill($k, $GLOBALS['send_signal']);
						if (in_array($GLOBALS['send_signal'], $die_signals)) {
							pcntl_waitpid($k, $childStatus);
						}
					}
					if (in_array($GLOBALS['send_signal'], $die_signals)) {
						exit;
					}
					$GLOBALS['send_signal'] = FALSE;
				}
			}
		}
	}
}
// Start a single worker
else {
	$queues = explode(',', $QUEUE);
	$worker = new Resque_Worker($queues);
	$worker->logLevel = $logLevel;
	$worker->hasParent = FALSE;

	$PIDFILE = getenv('PIDFILE');
	if ($PIDFILE) {
		file_put_contents($PIDFILE, getmypid()) or
			die('Could not write PID information to ' . $PIDFILE);
	}

	fwrite(STDOUT, "\033[00;32m*** Starting worker {$worker}\033[00m\n");
	$worker->work($interval);
	fwrite(STDOUT, "\033[01;34m*** Stopping worker {$worker}\033[00m\n");
}

/* End of file resque-workers.php */
/* Location: ./resque-workers.php */