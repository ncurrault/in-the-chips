<?php
require_once "cache.php";

cache_delete("users");
cache_delete("saleRecord");
cache_delete("rounds");
cache_delete("offers");
cache_delete("sellersSoFar");
?>
