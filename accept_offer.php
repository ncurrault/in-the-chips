<?php
$uname = $_GET["me"];
$otherUname = $_GET["them"];
$amt = $_GET["price"];

$offers = apc_fetch("offers");
$users = apc_fetch("users");

// query for user data
$me = $users[$uname];
$them = $users[$otherUname];

$myRole = $me["role"];
$theirRole = $them["role"];

$roundno = apc_fetch("rounds")[0]["number"]; // pray this works and don't sanitize anything

$goodkey = null;

foreach($offers as $key => $o) {
	// disregard confounding unconfirmed transactions
	if (!($o["sellerRecord"] || $o["buyerRecord"])) {
		if ($o[$myRole . "Name"] == $uname) {
			if ($o[$theirRole . "Name"]) {
				// someone took your offer
				http_response_code(400);
				echo "Someone already took your offer! (Try refreshing that data.)";
				exit;
			} else {
				// remove the old offer
				unset($offers[$key]);
			}
		} else if ($o[$theirRole . "Name"] == $otherUname && $o["saleAmt"] == $amt) {
			if (! $o[$myRole . "Name"]) {
				// WE DID IT!

				$goodkey = $key;
			}
		}
	}
}

if ($goodkey === null) {
	// offer no longer available
	http_response_code(400);
	echo "Selected offer no longer available.";
	exit;
} else {
	// sign offer to mark it taken
	$offers[$key][$myRole . "Name"] = $uname;
	$offers[$key][$myRole . "Record"] = true;

	$offers = array_values($offers);
	apc_store("offers", $offers);

	// record sale
	$saleRecord = apc_fetch("saleRecord");
	if (!$saleRecord)
		$saleRecord = array();
	array_push($saleRecord, array(
		"round" => $roundno,
		"sellerPrice" => $myRole == "seller" ? $me["currentCost"] : $them["currentCost"],
		"buyerPrice" => $myRole == "buyer" ? $me["currentCost"] : $them["currentCost"],
		"amt" => $amt
	));
	apc_store("saleRecord", $saleRecord);

	// calculate profits
	if ($myRole == "buyer") {
		$myProfit = $me["currentCost"] - $amt;
		$theirProfit = $amt - $them["currentCost"];
	} else {
		$myProfit = $amt - $me["currentCost"];
		$theirProfit = $them["currentCost"] - $amt;
	}

	$users[$uname]["profit"] += $myProfit;
	$users[$otherUname]["profit"] += $theirProfit;
	apc_store("users", $users);

	echo $users[$uname]["profit"];
}

?>
