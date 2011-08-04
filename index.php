<?php

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke berita21
define('BASE_PATH', dirname(__FILE__));

// loading boot-strap file
include_once (BASE_PATH . '/mr/boot_strap.php');

try {
	run_hooks('pre_routing');
	$controller = map_controller();
	run_hooks('post_routing', $controller);
	include_once ($controller);
	run_hooks('post_controller', $controller);
} catch (Exception $e) {
	echo ($e->getMessage());
}

// print debugging info
show_debug();
