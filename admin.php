<!DOCTYPE html>

<?php require_once "cache.php"; ?>
<html>
	<head>
		<?php require_once 'jquery_bs.php'; ?>

		<title>"In the Chips" | Game Setup</title>
	</head>
	<body class="container">
<?php

if (isset($_POST["roundno"])) {
	$newround = array(
		"number" => $_POST["roundno"],
		"numberSellers" => $_POST["numPlayers"] * $_POST["pctSellers"] / 100.0,
		"eqlbPrice" => $_POST["eqlPrice"],
		"sellerVary" => $_POST["sellerVar"],
		"buyerVary" => $_POST["buyerVar"],
		"supplyElas" => $_POST["supplyElas"],
		"demandElas" => $_POST["demandElas"],
		"supplyShift" => $_POST["supplyShift"],
		"demandShift" => $_POST["demandShift"],
		"numOffers" => $_POST["offerVis"]
	);
	$rounds = cache_fetch("rounds");
	if (!$rounds) {
		$rounds = array();
	}
	if ($_POST["replaceRound"]) {
		$rounds[0] = $newround;
	} else {
		array_push($rounds, $newround);
	}
	cache_store("rounds", $rounds);
}

// if(md5($_POST['pswd']) == "adea7fe25ef9ca47ebe3787a141d00f2") :
?>
<!-- content -->

<div class="jumbotron">
	<a href="/"><h1>"In the Chips"</h1></a>
	<h2>Admin Console</h2>
</div>

<h1>Create Round</h1>

<form method="POST">
<!-- Start time
<input type="datetime-local" value="">
<br><br>
Duration (seconds):
<input type="number">
<br><br>
-->

Number
<input name="roundno" value="1" type="number">
<br><br>
Number of players
<input name="numPlayers" type="number">
<br><br>
% sellers
<input name="pctSellers" value="50" type="number">
<br><br><br>
original equilibrium price
$<input name="eqlPrice" value="5" type="number" step="0.1">
<br><br>
Seller price variance
$<input name="sellerVar" value="1.5" type="number" step="0.1">
<br><br>
Buyer price variance
$<input name="buyerVar" value="1.5" type="number" step="0.1">
<br><br>
Supply elasticity
<input name="supplyElas" value="100" type="number">%
<br><br>
Demand elasticity
<input name="demandElas" value="100" type="number">%
<br><br>
Supply curve shift
$<input name="supplyShift" value="0" step="0.1" type="number">
<br><br>
Demand curve shift
$<input name="demandShift" value="0" step="0.1" type="number">

<br><br><br>
Offer visibility
<input name="offerVis" value="3" type="number" step="1">
<br><br>
Replace current round?
<input name="replaceRound" type="checkbox">

<br>
<input type="submit" class="btn btn-info">
</form>
<br><br><br><br>
<a href="reset.php" class="btn btn-danger">RESET BUTTON</a>


<!-- <?php //else :?>

	<form method="POST">
		<h3>Enter admin password:</h3>
		<input type="password" name="pswd"></input>
		<input type="submit" class="btn btn-info">
	</form>
<?php //endif;?> -->

	</body>
</html>
