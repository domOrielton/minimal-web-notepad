<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.center {
		position: absolute;
		top: 50%;
		left: 50%;
		width: 300px;
		height: 200px;
		margin: -100px 0 0 -100px;
		font-family: sans-serif;
		font-size: large;
	}
	</style>
	<title><?php if (isset($_GET['note'])) print $_GET['note']; ?></title>
</head>
<body onload="document.forms[0].password.focus();">
<div class="center">
<form method="POST">
  <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ?>
	Invalid password
  <?php
} ?>
	Password to access:</br>
	<input type="password" name="password" autofocus>
	<button type="submit">Go</button>
	<p style="font-size: small">This note has a password<br><a href="<?php echo dirname($_SERVER['PHP_SELF']);?>">Create a new note</a></p>
	<?php if ($allowReadOnlyView == "1") { ?>
		<p style="font-size: small"><a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?view"; ?>">View as Read Only</a></p>
	<?php } ?>
</form>
</div>
</body>
</html>
