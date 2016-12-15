<?php

if (isset($_ENV['MEMCACHEDCLOUD_SERVERS'])) {
	$USE_MEMCACHED = true;
}
else {
	$USE_MEMCACHED = false;
}
if ($USE_MEMCACHED) {
	$mc = new Memcached();
	$mc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
	$mc->addServers(array_map(function($server) { return explode(':', $server, 2); }, explode(',', $_ENV['MEMCACHEDCLOUD_SERVERS'])));
	$mc->setSaslAuthData($_ENV['MEMCACHEDCLOUD_USERNAME'], $_ENV['MEMCACHEDCLOUD_PASSWORD']);
}

function cache_fetch($x) {
	global $USE_MEMCACHED;
	if ($USE_MEMCACHED) {
		return $mc->get($x);
	} else {
		return apc_fetch($x);
	}
}
function cache_store($x, $val) {
	global $USE_MEMCACHED;
	if ($USE_MEMCACHED) {
		return $mc->set($x, $val);
	} else {
		return apc_store($x, $val);
	}
}

function cache_delete($x) {
	global $USE_MEMCACHED;
	if ($USE_MEMCACHED) {
		return $mc->delete($x);
	} else {
		return apc_delete($x);
	}
}
?>
