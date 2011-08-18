<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 *
 * @package mr
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

include_once(BASE_PATH . '/mr/' . 'version_info.php');

// global variabel
$_MR = array();

// variabel yang menyimpan user yang aktif saat ini
$_MR['user'] = NULL;

// time start
$_MR['time_start'] = microtime(TRUE);

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');
include_once(BASE_PATH . '/mr/' . 'db_config.php');
include_once(BASE_PATH . '/mr/' . 'function.php');

site_debug(FRAMEWORK_FULL_NAME, 'FRAMEWORK NAME');

load_helper('url');
load_helper('string');
$_mr_auto_libs = array(
					'query_cache',
					'sql_query',
					'controller', 
					'plugin', 
					'session',
					'template'
				);
					
// load library yang sifatnya auto-load
$_MR['autoload_libraries'] = $_mr_auto_libs + $_MR['autoload_libraries'];
foreach ($_MR['autoload_libraries'] as $lib) {
	load_library($lib);
}

// load models
load_model('users');

// load menu
include_once(BASE_PATH . '/mr/' . 'menu.php');

// load plugins
load_plugins();

run_hooks('mr_init');

// konek ke database
$_MR['db'] = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// init session
session_construct();

// init user role
init_user_role();
site_debug(print_r($_MR['user'], TRUE), 'CURRENT USER');

// Untuk menjaga kompatibilitas dengan PHP versi < 5.2.9 maka pengecekan error
// dilakukan secara prosedural
if (mysqli_connect_error()) {
	site_debug('DB_ERROR(' . mysqli_connect_errno() . '): ' . mysqli_connect_error(), 'DATABASE_ERROR');
	throw new Exception("Error: Gagal melakukan koneksi ke database.");
}
