<?php

$mc = null;

if (isset($_ENV['MEMCACHEDCLOUD_SERVERS'])) {
	$mc = new Memcached();
	$mc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
	$mc->addServers(array_map(function($server) { return explode(':', $server, 2); }, explode(',', $_ENV['MEMCACHEDCLOUD_SERVERS'])));
	$mc->setSaslAuthData($_ENV['MEMCACHEDCLOUD_USERNAME'], $_ENV['MEMCACHEDCLOUD_PASSWORD']);
}

function cache_fetch($x) {
	global $mc;
	if ($mc !== null) {
		return $mc->get($x);
	} else {
		return apc_fetch($x);
	}
}
function cache_store($x, $val) {
	global $mc;
	if ($mc !== null) {
		return $mc->set($x, $val);
	} else {
		return apc_store($x, $val);
	}
}
function cache_delete($x) {
	global $mc;
	if ($mc !== null) {
		return $mc->delete($x);
	} else {
		return apc_delete($x);
	}
}
?>
