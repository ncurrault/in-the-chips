<!DOCTYPE html>

<?php // print_r($_POST); ?>
<html>
	<head>
		<?php require_once 'jquery_bs.php'; ?>

		<title>"In the Chips" | Game Setup</title>
	</head>

	<body class="container">
<?php
if (isset($_POST["action"])) {
	$newround = array(
		"number" => $_POST["roundno"],
		"numberSellers" => $_POST["numPlayers"] * $_POST["pctSellers"] / 100.0,
		"eqlbPrice" => $_POST["eqlPrice"],
		"sellerVary" => $_POST["sellerVar"],
		"buyerVary" => $_POST["buyerVar"],
		"numOffers" => $_POST["offerVis"]
	);
	$rounds = apc_fetch("rounds");
	if (!$rounds) {
		$rounds = array();
	}
	if ($_POST["replaceRound"]) {
		$rounds[0] = $newround;
	} else {
		array_push($rounds, $newround);
	}
	apc_store("rounds", $rounds);
}

if(md5($_POST['pswd']) == "adea7fe25ef9ca47ebe3787a141d00f2") :
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

<input type="hidden" name="pswd" value="<?php echo $_POST["pswd"]?>">
<input type="hidden" name="action" value="1">

Number
<input name="roundno" value="1" type="number">
<br><br>
Number of players
<input name="numPlayers" type="number">
<br><br>
% sellers
<input name="pctSellers" value="50" type="number">
<br><br><br>
equilibrium price
<input name="eqlPrice" value="5" type="number" step="0.1">
<br><br>
Seller price variance
<input name="sellerVar" value="1.5" type="number" step="0.1">
<br><br>
Buyer price variance
<input name="buyerVar" value="1.5" type="number" step="0.1">
<br><br>
Offer visibility
<input name="offerVis" value="3" type="number" step="1">
<br><br>
Replace current round?
<input name="replaceRound" type="checkbox">

<!-- offer visibility?? -->

<br>
<input type="submit" class="btn btn-info">
</form>
<br><br><br><br>
<a href="reset.php" class="btn btn-danger">RESET BUTTON</a>

<?php else :?>

	<form method="POST">
		<h3>Enter admin password:</h3>
		<input type="password" name="pswd"></input>
		<input type="submit" class="btn btn-info">
	</form>
<?php endif;?>

	</body>
</html>
