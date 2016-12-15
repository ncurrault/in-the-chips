<?php
require_once "cache.php";

$rounds = cache_fetch("rounds");
unset($rounds[0]);
$rounds = array_values($rounds);

cache_store("rounds", $rounds);
cache_delete("sellersSoFar");
cache_delete("offers");
?>
