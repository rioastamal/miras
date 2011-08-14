<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 *
 * @package mr
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

// global variabel
$_MR = array();

// time start
$_MR['time_start'] = microtime(TRUE);

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');
include_once(BASE_PATH . '/mr/' . 'db_config.php');
include_once(BASE_PATH . '/mr/' . 'function.php');

// load library yang sifatnya auto-load
foreach ($_MR['autoload_libraries'] as $lib) {
	load_library($lib);
}

// load menu
include_once(BASE_PATH . '/mr/' . 'menu.php');

// load plugins
load_plugins();

run_hooks('mr_init');

// konek ke database
$_MR['db'] = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Untuk menjaga kompatibilitas dengan PHP versi < 5.2.9 maka pengecekan error
// dilakukan secara prosedural
if (mysqli_connect_error()) {
	site_debug('DB_ERROR(' . mysqli_connect_errno() . '): ' . mysqli_connect_error(), 'DATABASE_ERROR');
	throw new Exception("Error: Gagal melakukan koneksi ke database.");
}
