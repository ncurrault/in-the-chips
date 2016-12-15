<!DOCTYPE html>

<html>
<head>
	<title>Player Leaderboard</title>
	<?php require_once "jquery_bs.php"; ?>

</head>
<body class="container">
	<div class="jumbotron">
		<h1>Leaderboard</h1>
	</div>
<table class="table">
	<tr>
		<th id="uname_header">Username</th>
		<th id="profit_header">Total Profit</td>
		<!-- <th>Number of Transactions</th> -->
	</tr>
<?php
require_once "cache.php";
$userData = cache_fetch("users");

foreach ($userData as $uname => $data) {
    $userData[$uname] = $data["profit"];
}

array_multisort($userData, SORT_DESC);

foreach ($userData as $name => $profit){
	echo "<tr><td>".$name."</td><td>$".$profit."</td></tr>";
}
?>
</table>
