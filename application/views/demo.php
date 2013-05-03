<!doctype html>
<html>
	<head>
		<title>Demo - 2013 OpenWest Conference: Removing Cron From The PHP Workflow</title>
		<style type="text/css">
			label {
				display: table;
				margin: 1ex .5ex -2.5ex;
				padding-bottom: 0;
				font-size: 0.9em;
				font-family: sans-serif;
			}
			input[type="text"], textarea {
				width: 300px;
				background-color: rgba(255, 255, 255, 1);
				border: 1px solid gray;
				font-family: sans-serif;
			}
			input[value=""], input:not([value]), textarea {
				background-color: rgba(255, 255, 255, .5);
			}
			textarea {
				vertical-align: top;
				height: 6em;
			}
			input[type="submit"] {
				display: block;
			}
		</style>
		<script type="text/javascript">
			function transCheck(elm) {
				elm.style.backgroundColor = "rgba(255, 255, 255, " + (elm.value == "" ? ".5" : "1") + ")";
			}
		</script>
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
					<input type="text" name="email" id="checkin_email" onkeyup="transCheck(this);" />
					<label for="checkin_location">Location</label>
					<input type="text" name="location" id="checkin_location" onkeyup="transCheck(this);" />
					<label for="checkin_note">Note(s)</label>
					<textarea name="note" id="checkin_note" onkeyup="transCheck(this);"></textarea>
					<input type="submit" name="submit" value="Check In" />
				</form>
			</li>
			<li>Reminder:
				<form action="/cronfree/demo/reminder" method="POST">
					<label for="reminder_email">Email</label>
					<input type="text" name="email" id="reminder_email" onkeyup="transCheck(this);" />
					<label for="reminder_delay">Delay (seconds)</label>
					<input type="text" name="delay" id="reminder_delay" value="15" onkeyup="transCheck(this);" />
					<label for="reminder_note">Note(s)</label>
					<textarea name="note" id="reminder_note" onkeyup="transCheck(this);"></textarea>
					<input type="submit" name="submit" value="Set Reminder" />
				</form>
			</li>
		</ul>
	</body>
</html>