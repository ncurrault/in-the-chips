<?php
$rounds = apc_fetch("rounds");
unset($rounds[0]);
apc_store("rounds", $rounds);
apc_delete("sellersSoFar");
apc_delete("offers");
?>
