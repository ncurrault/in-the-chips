<!DOCTYPE html>

<html>
	<head>
		<?php require_once 'jquery_bs.php'; ?>
		<title>"In the Chips"</title>
	</head>

	<body class="container">
		<div class="jumbotron">
			<h1>"In the Chips"</h1>
			<h2>With Settings and Analytics</h2>
			<p>description</p>
		</div>
		<form method="GET" action="play.php" class="row">
			<input type="text" placeholder="Username">
			<input type="submit" class="btn btn-success" value="Play!">
		</form>
		<br><br><br>
		<a style="font-size:small;" href="admin.php">Access admin console...</a>
	</body>
</html>
