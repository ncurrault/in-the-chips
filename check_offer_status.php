<?php
$uname = $_GET["uname"];

$offers = apc_fetch("offers");
if (!$offers) {
	$offers = array();
}
$users = apc_fetch("users");

// query for user data
$role = $users[$uname]["role"];
$otherRole = $role == "seller" ? "buyer" : "seller";

$otherPerson = null;

foreach($offers as $key => $o) {
	// disregard confounding unconfirmed transactions
	if ($o[$role . "Name"] == $uname && !$o[$role . "Record"]) {
		if (isset($o[$otherRole . "Name"]) && $o[$otherRole . "Name"]) {
			$otherPerson = $o[$otherRole . "Name"];
			unset($offers[$key]);
		}
		break;
	}
}
$offers = apc_store("offers", $offers);

if ($otherPerson !== null) {
	echo "Offer accepted!\n";
	echo $otherPerson;
	echo "\n";
	echo $users[$uname]["profit"];
}

// remove from main category
// return who accepted it
?>
