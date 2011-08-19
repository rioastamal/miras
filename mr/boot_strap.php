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

// manual load library plugin karena fungsi run_hooks diperlukan oleh banyak
// proses awal
include_once(BASE_PATH . '/libraries/' . 'plugin_lib.php');
$_MR['loaded_libraries'][] = 'plugin';

// check keberadaan direktori install, jika masih ada langsung lempar 
// ke exception
if (file_exists(BASE_PATH . '/install')) {
	// jika debugging mode maka tidak perlu di throw
	if ($_MR['debug_mode'] === FALSE) {
		throw new Exception ('Mohon untuk menghapus direktori <strong>install</strong> terlebih dahulu.');
	}
}

site_debug(FRAMEWORK_FULL_NAME, 'FRAMEWORK NAME');

load_helper('url');
load_helper('string');
$_mr_auto_libs = array(
					'query_cache',
					'sql_query',
					'controller', 
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
load_model('options');

// konek ke database
$_MR['db'] = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Untuk menjaga kompatibilitas dengan PHP versi < 5.2.9 maka pengecekan error
// dilakukan secara prosedural
if (mysqli_connect_error()) {
	exit('DB_ERROR(' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

// load menu
include_once(BASE_PATH . '/mr/' . 'menu.php');

run_hooks('mr_init');

// init session
mr_session_construct();

// set all options from database to global variabel
set_all_options();

// load plugins
load_plugins();

// init user role
init_user_role();
site_debug(print_r($_MR['user'], TRUE), 'CURRENT USER');
