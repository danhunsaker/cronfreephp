<!doctype html>
<html>
	<head>
		<title>Home - 2013 OpenWest Conference: Removing Cron From The PHP Workflow</title>
	</head>
	<body>
		<h1>Cron-Free PHP Homepage</h1>
		<p>For the 2013 OpenWest Conference presentation <q>Removing Cron From The PHP Workflow</q>.</p>
		<p>By Dan Hunsaker</p>
		<p>
			Several practices from the early days of the web persist in modern PHP development. Among these 
			is the use of cron for handling background tasks. By utilizing PHP's CLI SAPI, and the process 
			backgrounding methodologies of the target operating system, cron can be replaced in most of 
			these scenarios with a long-running PHP script, sometimes called a worker.
		</p>
		<p>
			This project was built to accompany a presentation which covers some of the methods for creating 
			and using workers.  The presentation, to be delivered at the 2013 OpenWest Conference, includes 
			a demonstration using a real-world implementation, on which this project is based.  The purpose 
			of this project is to provide a solid foundation on which the presentation attendees (and other 
			interested parties) can build their own real-wold projects, without having to spend time 
			developing and/or integrating the underlying functionality.
		</p>
		<h2>Requirements</h2>
		<ul>
			<li>Unix-Based OS (forking support)</li>
			<li>Web Server (apache, lighttp, nginx...)</li>
			<li>PHP 5.3 or higher (CLI <em>and</em> web SAPIs) with pcntl, posix, and json extensions</li>
			<li>Redis server</li>
			<li>Composer</li>
			<li>git</li>
		</ul>
		<h2>Recommended</h2>
		<ul>
			<li>SQL-compatible RDBMS</li>
			<li>phpredis and proctitle extensions</li>
		</ul>
		<p>
			Further documentation is forthcoming.  In the meantime, feel free to look through the code, as 
			well as the documentation for the supporting projects:
			<ul>
				<li><a href="https://github.com/chrisboulton/php-resque">PHP Resque</a> - Provides queue management and basic worker support.</li>
				<li><a href="https://github.com/chrisboulton/php-resque-scheduler">PHP Resque Scheduler</a> - As its name implies, handles scheduling for Resque.</li>
				<li><a href="http://codeigniter.com/">CodeIgniter</a> - Optional; used for demo, but you can use whatever framework you like (even none at all).</li>
			</ul>
			If you want to dig deeper, have a look at the dependencies:
			<ul>
				<li><a href="https://github.com/colinmollenhour/credis">Credis</a> - PHP library for communicating with Redis.  Uses phpredis if available.</li>
				<li><a href="https://redis.io/">Redis</a> - A super-fast atomic key-value store.</li>
				<li><a href="https://github.com/nicolasff/phpredis">phpredis</a> - A PHP extension that handles the actual communication with Redis.  This isn't <em>strictly</em> a dependency, but can make things more stable.</li>
			</ul>
		</p>
	</body>
</html>