<?php
echo "Error: connection issue"
exit;

$currentRound = apc_fetch("rounds")[0];
$maxOffers = $currentRound["numOffers"];

$offers = apc_fetch("offers");
if (!$offers) {
	$offers = array();
}
$role = $_GET["role"];

foreach($offers as $o) {
	if ($o["sellerRecord"] || $o["buyerRecord"]) {
		unset($o);
	} else if ($o[$role . "Name"]) {
		unset($o);
	}
}

$toPresent = array_rand($offers, min($maxOffers, sizeof($offers)));
print_r($toPresent);
foreach ($toPresent as $n) {
	$o = $offers[$n];
	print_r($o);
	//echo $o[saleAmt] . " from " . $o[$role == "seller" ? "buyerName" : "sellerName"];
	//echo "<tr><td>" . $o["saleAmt"] . "</td><td>" . $o[$role == "seller" ? "buyerName" : "sellerName"] . "</td></tr>";
}
?>
