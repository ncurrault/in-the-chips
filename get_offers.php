<?php
require_once "cache.php";

$currentRound = cache_fetch("rounds")[0];
$maxOffers = $currentRound["numOffers"];

$offers = cache_fetch("offers");
if (!$offers) {
	$offers = array();
}
$role = $_GET["role"];

foreach($offers as $key => $o) {
	if ($o["sellerRecord"] || $o["buyerRecord"]) {
		unset($offers[$key]);
	} else if ($o[$role . "Name"]) {
		unset($offers[$key]);
	}
}
$offers = array_values($offers);

$toPresent = array();
for ($i=0; $i<min($maxOffers, sizeof($offers)); $i++) {
	$e = $offers[rand(0, sizeof($offers)-1)];
	array_push($toPresent, $e);
	unset($offers[$i]);
	$offers = array_values($offers);
}
$offers = array_values($offers);

//array_rand not working TODO fix???


foreach ($toPresent as $o) {
	//echo $o[saleAmt] . " from " . $o[$role == "seller" ? "buyerName" : "sellerName"];
	$otherPerson = $o[$role == "seller" ? "buyerName" : "sellerName"];
	$amt = $o["saleAmt"];

	echo "<tr class='offer'><td>$". $amt . "</td><td>" . $otherPerson .
	"</td><td><button class=\"btn btn-success\" onclick='return acceptOffer(\"". $otherPerson . "\", " . $amt . ");'>Accept Offer</button></td></tr>";
	//echo $o[saleAmt] . "\n" . $o[$role == "seller" ? "buyerName" : "sellerName"];
}
?>
