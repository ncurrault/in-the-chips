<!DOCTYPE html>
<?php
require_once "cache.php";

	$uname = $_GET["uname"];
	if (isset($_GET["profit"])) {
		$profit = $_GET["profit"];
	} else {
		$profit = 0;
	}

	$round = cache_fetch("rounds")[0];

	$users = cache_fetch("users");
	if (!$users) {
		$users = array();
	}

	$currentNumSellers = cache_fetch("sellersSoFar");
	if (!$currentNumSellers) {
		$currentNumSellers = 0;
	}
	if ($currentNumSellers < $round["numberSellers"]) {
		$role = "seller";
		cache_store("sellersSoFar", $currentNumSellers + 1);
	}
	else {
		$role = "buyer";
	}

	// FOR TESTING ONLY
	if ($uname == "seller1")
		$role = "seller";
	else if ($uname == "buyer1")
		$role = "buyer";

	$users[$uname] = array("role" => $role, "profit" => $profit, "currentCost" => 0);
	cache_store("users", $users);
?>

<html>
	<head>
		<?php require_once 'jquery_bs.php'; ?>

		<title>"In the Chips" | Play Game</title>
		<script>
			var UNAME = "<?php echo addslashes($uname);?>";
			var ROLE = "<?php echo $role; ?>";
			var profit = "<?php echo $profit; ?>";
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

			function getPrice() {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "get_price.php?uname=<?php echo $uname; ?>&role=<?php echo $role; ?>", true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						$("#price").html(xhr.response);
						$("#offerBox").attr("placeholder", "");
					} else {
						alert("Error: connection/server issues (" + xhr.status + ")");
					}
				}
				xhr.send();
			}
			$(getPrice);
			function makeOffer() {
				var amt = $("#offerBox").val();
				var xhr = new XMLHttpRequest();
				xhr.open('get', "make_offer.php?role=<?php echo $role . "&uname=" . $uname; ?>&amt=" + amt, true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						$("#offerBox").attr("placeholder", $("#offerBox").val());
						$("#offerBox").val("");
					} else {
						alert("Error: connection/server issues (" + xhr.status + ")");
					}
				}
				xhr.send();
			}
			function getOffers() {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "get_offers.php?role=<?php echo $role; ?>", true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						$(".offer").remove();
						$("#offers").append(xhr.response);
					} else {
						alert("Error: connection/server issues (" + xhr.status + ")");
					}
				}
				xhr.send();
			}
			function getOfferStatus() {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "check_offer_status.php?uname=<?php echo $uname ?>", true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						if (xhr.response.search("Offer accepted") != -1) {
							var lines = xhr.response.split('\n');
							profit = lines[2];
							$("#profit").html(profit);
							alert(lines[1] + " accepted your offer!");
							getPrice();
						}
					} else {
						alert("Error: connection/server issues (" + xhr.status + ")")
					}
				}
				xhr.send();
			}

			function acceptOffer(name, price) {
				var xhr = new XMLHttpRequest();
				xhr.open('get', "accept_offer.php?me=<?php echo $uname ?>&them="+name+"&price="+price, true);
				xhr.onload = function() {
					if (xhr.status == 200) {
						getPrice();
						alert("Transaction successful!");
						profit = xhr.response;
						$("#profit").html(profit);
					} else if (xhr.status == 400){
						alert(xhr.response);
					} else {
						alert("Error: connection/server issues (" + xhr.status + ")")
					}
				}
				xhr.send();
			}

			function refreshData() {
				getOfferStatus();
				getOffers();
			}

			function nextRound() {
				window.location.href = "play.php?uname=<?php echo $uname; ?>&profit=" + profit;
			}
		</script>
	</head>

	<body class="container">
		<div class="jumbotron">
			<a href="/"><h1>"In the Chips"</h1></a>
			<h2>Round <?php echo $round["number"] ?>
		</div>
	<h3 style="line-height:1.5">
		Role: <b id="role"><?php echo $role ?></b>
		<br>
		Username:<b id="uname"><?php echo $uname ?></b>
		<br>
		<span id="price-label"><?php echo $role == "seller" ? "Cost to make this bag of chips:" : "You value this bag of chips at:"; ?></span>
		<b>$<span id="price"></span></b>
		<br>
		Profit so far: <b>$<span id="profit"><?php echo $profit ?></span></b>

	</h3>
	<!--
	<div id="timer-label">Time until round begins:</div>
	<div id="timer"></div>
	-->

	<input type="text" id="offerBox">

	<button class="btn btn-danger" onclick="return makeOffer();">Submit Offer</button>
	<div id="offer-status"></div>
	<br>

	<table class="table" id="offers">
		<tr>
			<th>Offer Amount</th>
			<th>From</th>
			<th>Accept Button</th>
		</tr>
		<tr class="offer" style="">
			<td colspan="3" style="text-align: center;"><i>no offers yet</i></td>
		</tr>
	</table>

<button class="btn btn-info" onclick="return refreshData();">Refresh Data</button>
<br><br><br>
<button class="btn btn-danger" onClick="return nextRound();">Next Round (Click only when instructed.)</button>
	</body>
</html>
