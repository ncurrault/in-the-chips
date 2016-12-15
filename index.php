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
			<h4>Nicholas Currault and Janae Lewis, Economics Final Project</h2>
		</div>
		<p>
			This is an online game similar to the game of the same name we played in class.
			Players will be divided into two groups &mdash; buyers and sellers.
			Each will buy/sell boxes of <strike>computer</strike> potato chips.
			The goal is to make the most profit.
			If you are a buyer, buy things for as low as possible.
			If you are a seller, sell things for as high a price as possible.
		</p>
		<p>
			The online version also seeks to quatify the number of players each trader interacts with.
			We will collect data on this game and present statistics about supply/demand, deadweight loss, and surplus later.
		</p>
		<form method="GET" action="play.php" class="row">
			<input type="text" name="uname" placeholder="Username">
			<input type="submit" class="btn btn-success" value="Play!">
		</form>
		<br><br><br>
		<a style="font-size:small;" href="admin.php">Access admin console...</a>
	</body>
</html>
