<!DOCTYPE html>
<?php
	$uname = $_GET["uname"];

	$round = apc_fetch("rounds")[0];

	$users = apc_fetch("users");
	if (!$users) {
		$users = array();
	}

	$currentNumSellers = apc_fetch("sellersSoFar");
	if (!$currentNumSellers) {
		$currentNumSellers = 0;
	}
	if ($currentNumSellers < $round["numberSellers"]) {
		$role = "seller";
		apc_store("sellersSoFar", $currentNumSellers + 1);
	}
	else {
		$role = "buyer";
	}

	$users[$uname] = array("role" => $role, "profit" => 0);
	apc_store("users", $users);
?>

<html>
	<head>
		<?php require_once 'jquery_bs.php'; ?>

		<title>"In the Chips" | Play Game</title>
		<script>
			var UNAME = "<?php echo addslashes($uname);?>";
			var ROLE = "<?php echo $role; ?>";
			// var ROUND_STARTS = new Date(<?php // echo date("Y, n, j, G, i, s, v", $currentRound["startTime"]) ?>);
			// var ROUND_DURATION = <?php // echo $currentRound["duration"] ?>;

			// var preTimerIntervalID;
			// function preRoundTimer() {
			// 	("#timer-label").html("Round starting in");
			// 	var d = new Date();
			// 	if (d.getTime() >= ROUND_STARTS.getTime()) {
			// 		startRound();
			// 		clearInterval(preTimerIntervalID);
			// 	} else {
			// 		$("#timer").html(1000*(ROUND_STARTS.getTime() - d.getTime())+" seconds");
			// 	}
			// }
			// var roundTimerIntervalID;
			// function inRoundUpdates() {
			// 	("#timer-label").html("Round starting in");
			// 	var d = new Date();
			// 	if (d.getTime() >= (ROUND_STARTS.getTime() + 1000*ROUND_DURATION)) {
			// 		endRound();
			// 		clearInterval(roundTimerIntervalID);
			// 	} else {
			// 		$("#timer").html(1000*((ROUND_STARTS.getTime() + 1000*ROUND_DURATION) - d.getTime())+" seconds");
			// 	}
			// }
			// preTimerIntervalID = setInterval(preRoundTimer, 1000);

			var inputPrice;
			var profit;
			var numTransactions;

			function getPrice() {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "get_price.php?role=<?php echo $role; ?>", true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						inputPrice = xhr.response;
						$("#price").html(inputPrice);
					} else {
						alert("Error: connection issues");
					}
				}
				xhr.send();
			}
			function makeOffer() {
				var amt = $("#offerBox").val();
				var xhr = new XMLHttpRequest();
				xhr.open('get', "make_offer.php?role=<?php echo $role . "&uname=" . $uname; ?>&amt=" + amt, true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						$("#offerBox").val("");
					} else {
						alert("Error: connection issues");
					}
				}
				xhr.send();
			}

			$(getPrice);

			function getOffers() {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "get_offers.php?role=<?php echo $role; ?>", true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						alert(xhr.response);
						$("#offers").html(xhr.response);
					} else {
						alert("Error: connection issues");
					}
				}
				xhr.send();
			}

			function acceptOffer(name) {

			}
		</script>
	</head>

	<body class="container">
		<div class="jumbotron">
			<a href="/"><h1>"In the Chips"</h1></a>
			<h2>Round <?php echo $round["number"] ?>
		</div>
		<h3>
		Role: <b id="role"><?php echo $role ?></b>
		<br>
		Username:<b id="uname"><?php echo $uname ?></b>
		<br>
		<span id="price-label"><?php echo $role == "seller" ? "Cost to make this bag of chips:" : "You value this bag of chips at:"; ?></span>
		<b>$<span id="price"></span></b>

	</h3>
		<!--
		<div id="timer-label">Time until round begins:</div>
		<div id="timer"></div>
	-->

		<input type="text" id="offerBox">
		<button onclick="return makeOffer();">Submit Offer</button>
		<div class="offer-status"></div>
		<button>Refresh offer status</button>

<table class="table table-responsive">
	<tr>
		<th>Offer Amount</th>
		<th>From</th>
		<th>Accept</th>
	</tr>
	<span id="offers"></span>
</table>
<button onclick="return getOffers();">Refresh offers</button>
	</body>
</html>
