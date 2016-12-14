<?php
echo "users<br>";
print_r( apc_fetch("users"));
echo "<br><br>";
echo "saleRecord<br>";
print_r( apc_fetch("saleRecord"));
echo "<br><br>";
echo "rounds<br>";
print_r( apc_fetch("rounds"));
echo "<br><br>";
echo "offers<br>";
print_r( apc_fetch("offers"));
echo "<br><br>";
echo "sellersSoFar<br>";
print_r( apc_fetch("sellersSoFar"));
?>
