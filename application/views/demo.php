<!doctype html>
<html>
	<head>
		<title>Demo - 2013 OpenWest Conference: Removing Cron From The PHP Workflow</title>
	</head>
	<body>
		<h1>Cron-Free PHP Demo</h1>
		<h2>Current Queue Status</h2>
		<?php if (count($queues) > 0): ?>
		<ul>
			<?php foreach ($queues as $qname => $qsize): ?>
			<li><?php echo $qname ?>: <?php echo $qsize ?> jobs queued</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<h2>Queue A Job</h2>
		<ul>
			<li>Check In:
				<form action="/cronfree/demo/checkin" method="POST">
					<label for="checkin_email">Email</label>
					<input type="text" name="email" id="checkin_email" />
					<label for="checkin_location">Location</label>
					<input type="text" name="location" id="checkin_location" />
					<label for="checkin_note">Note(s)</label>
					<textarea name="note" id="checkin_note"></textarea>
					<input type="submit" name="submit" value="Check In" />
				</form>
			</li>
			<li>Reminder:
				<form action="/cronfree/demo/reminder" method="POST">
					<label for="reminder_email">Email</label>
					<input type="text" name="email" id="reminder_email" />
					<label for="reminder_delay">Delay (seconds)</label>
					<input type="text" name="delay" id="reminder_delay" value="15" />
					<label for="reminder_note">Note(s)</label>
					<textarea name="note" id="reminder_note"></textarea>
					<input type="submit" name="submit" value="Set Reminder" />
				</form>
			</li>
		</ul>
	</body>
</html>