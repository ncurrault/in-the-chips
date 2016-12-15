<?php
$rounds = apc_fetch("rounds");
unset($rounds[0]);
$rounds = array_values($rounds);

apc_store("rounds", $rounds);
apc_delete("sellersSoFar");
apc_delete("offers");
?>
