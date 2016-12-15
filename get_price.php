<?php
// TODO: actual S/D curves

$role = $_GET["role"];
$uname = $_GET["uname"];

$round = apc_fetch("rounds")[0];

$equilibrium = $round["eqlbPrice"];
if ($role == "seller") {
	$min = $equilibrium - $round["sellerVary"];
	$max = $equilibrium + $round["sellerVary"];
} else {
	$min = $equilibrium - $round["buyerVary"];
	$max = $equilibrium + $round["buyerVary"];
}

$randval = rand(10*$min, 10*$max);
$price = $randval / 10;

echo $price;


$users = apc_fetch("users");
if (!$users) {
	$users = array();
}
$users[$uname]["currentCost"] = $price;
apc_store("users", $users);
?>
