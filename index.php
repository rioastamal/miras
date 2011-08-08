<?php
// PHP error reporting
// set ke E_ALL untuk development
// set ke 0 untuk production
error_reporting(E_ALL);

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke berita21
define('BASE_PATH', dirname(__FILE__));

try {
	// loading boot-strap file
	include_once (BASE_PATH . '/mr/boot_strap.php');
	
	run_hooks('pre_routing');
	$controller = map_controller();
	run_hooks('post_routing', $controller);
	include_once ($controller);
	run_hooks('post_controller', $controller);
	
	mr_close_db();
	mr_script_time();
	mr_get_memory_usage();
} catch (Exception $e) {
	run_hooks('page_exception', $e);
	show_error($e->getMessage());
	
	mr_close_db();
	mr_script_time();
	mr_get_memory_usage();
}

// print debugging info
show_debug();
