<!DOCTYPE html>

<html>
<head>
	<title>Results Viewer</title>
</head>
<body>
<h1>Data</h1>
<table cellpadding="5">
	<tr>
		<th>Round</th>
		<th>Sale Price</td>
		<th>Buyer's Price</th>
		<th>Seller's Price</th>
	</tr>
<?php
require_once "cache.php";
$saleRecord = cache_fetch("saleRecord");

foreach ($saleRecord as $sale){
	echo "<tr><td>".$sale["round"]."</td><td>".$sale["amt"]."</td><td>".$sale["buyerPrice"]."</td><td>".$sale["sellerPrice"]."</td></tr>";
}
?>
</table>
