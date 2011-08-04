<?php

/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 */

include_once(BASE_PATH . '/mr/' . 'db_config.php');
include_once(BASE_PATH . '/mr/' . 'function.php');

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');

// load library yang sifatnya auto-load
foreach ($_MR['autoload_libraries'] as $lib) {
	load_library($lib);
}

// load menu
include_once(BASE_PATH . '/mr/' . 'menu.php');

// load plugins
load_plugins();
