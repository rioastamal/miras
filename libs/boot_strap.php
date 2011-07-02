<?php

/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 */

// deklarasi BASE_PATH
// BASE_PATH adalah lokasi absolute path sampai ke berita21
define('BASE_PATH', dirname( dirname(__FILE__) . '../') );

include_once(BASE_PATH . '/libs/' . 'db_config.php');

// site config
include_once(BASE_PATH . '/libs/' . 'site_config.php');
