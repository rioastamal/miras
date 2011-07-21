<?php

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke berita21
define('BASE_PATH', dirname(__FILE__));

// loading boot-strap file
include_once (BASE_PATH . '/libs/boot_strap.php');

try {
	$controller = map_controller();
	include_once ($controller);
} catch (Exception $e) {
	echo ($e->getMessage());
}

// print debugging info
show_debug();
