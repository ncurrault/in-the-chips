<?php
$rounds = apc_fetch("rounds");

$equilibrium = $rounds[0]["eqlbPrice"];
if ($_GET["role"] == "seller") {
	$min = $equilibrium - $rounds[0]["sellerVary"];
	$max = $equilibrium + $rounds[0]["sellerVary"];
} else {
	$min = $equilibrium - $rounds[0]["buyerVary"];
	$max = $equilibrium + $rounds[0]["buyerVary"];
}

$randval = rand(10*$min, 10*$max);
echo $randval / 10;
?>
