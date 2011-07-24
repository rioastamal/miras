<?php

/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 */

include_once(BASE_PATH . '/b21/' . 'db_config.php');
include_once(BASE_PATH . '/b21/' . 'function.php');

// site config
include_once(BASE_PATH . '/b21/' . 'site_config.php');

// load library yang sifatnya auto-load
foreach ($_B21['autoload_libraries'] as $lib) {
	load_library($lib);
}

// load plugins
load_plugins();
