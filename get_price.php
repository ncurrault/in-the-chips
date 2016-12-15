<?php
require_once "cache.php";

// TODO: actual S/D curves

$role = $_GET["role"];
$uname = $_GET["uname"];

$round = cache_fetch("rounds")[0];


$numberSellers = $round["numberSellers"];
$eqlbPrice = $round["eqlbPrice"];
$sellerVary = $round["sellerVary"];
$buyerVary = $round["buyerVary"];
$supplyElas = $round["supplyElas"];
$demandElas = $round["demandElas"];
$supplyShift = $round["supplyShift"];
$demandShift = $round["demandShift"];

if ($role == "seller") {
	$totalArea = 2 * $sellerVary * $sellerVary * $demandElas; // MATH!
	$finalRange = 2 * $sellerVary;
	$randomSeed = rand(0, $totalArea) * $finalRange * 1.0 / $totalArea;

	$price = $eqlbPrice - $sellerVary + $randomSeed;
	$price += $supplyShift;
} else {
	$totalArea = 2 * $buyerVary * $buyerVary * $demandElas; // MATH!
	$finalRange = 2 * $buyerVary;
	$randomSeed = rand(0, $totalArea) * $finalRange * 1.0 / $totalArea;

	$price = $eqlbPrice + $buyerVary - $randomSeed;
	$price += $demandShift;
}

$price = round($price, 2);
echo $price;


$users = cache_fetch("users");
if (!$users) {
	$users = array();
}
$users[$uname]["currentCost"] = $price;
cache_store("users", $users);
?>
