<?php
error_log($_GET);

$toAdd = array("saleAmt" => $_GET["amt"], "sellerRecord" => false, "buyerRecord" => false);
if ($_GET["role"] == "seller") {
	$toAdd["sellerName"] = $_GET["uname"];
	$toAdd["buyerName"] = null;
} else {
	$toAdd["buyerName"] = $_GET["uname"];
	$toAdd["sellerName"] = null;
}

$offers = apc_fetch("offers");
if (!$offers) {
	$offers = array();
}
foreach ($offers as $o) {
	if (!$o["sellerRecord"] && !$o["buyerRecord"]) {
		if ($o["sellerName"] == $_GET["uname"]) {
			if ($o["buyerName"]) {
				echo "ERROR: OLD OFFER ACCEPTED, REFRESH";
				exit;
			} else {
				unset($o);
			}
			break;
		} else if ($o["buyerName"] == $_GET["uname"]) {
			if ($o["sellerName"]) {
				if ($o["buyerName"]) {
					echo "ERROR: OLD OFFER ACCEPTED, REFRESH";
					exit;
				} else {
					unset($o);
				}
			}
			break;
		}
	}
}
array_push($offers, $toAdd);
apc_store("offers", $offers);
?>
