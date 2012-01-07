<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi rutin code untuk memanggil semua library, models, helpers
 * yang dibutuhkan untuk inisialiasi.
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

include_once(BASE_PATH . '/mr/' . 'version_info.php');

// include compatibility routine
include_once(BASE_PATH . '/mr/' . 'compat.php');

// global variabel
$_MR = array();

// variabel yang menyimpan user yang aktif saat ini
$_MR['user'] = NULL;

// time start
$_MR['time_start'] = microtime(TRUE);

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');

// cek configurasi base_url apabila kosong atau auto, maka coba isi
// secara otomatis.
if ($_MR['base_url'] === 'auto' || $_MR['base_url'] === '') {
	// kita belum bisa menggunakan helper apapun untuk membantu karena masih
	// dalam tahap bootstraping paling awal
	// Step-by-step
	// 1. Identifikasi Protokol
	// 2. Identifikasi Hostname
	// 3. Identifikasi Path
	
	// jika port 80 maka http
	$protocol = 'http://';
	
	// jika nilai $_SERVER['HTTPS'] ada dan tidak berisi 'off' (untuk IIS server)
	// maka protokol yang digunakan adalah https://
	if (isset($_SERVER['HTTPS'])) {
		if ($_SERVER['HTTPS'] !== 'off') {
			$protocol = 'https://';
		}
	}
	
	// set nama host
	$host = $_SERVER['HTTP_HOST'];
	
	// dapatkan path, kita ambil nilai dari variabel SCRIPT_NAME
	// lalu hanya ambil direktorinya
	$path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
	
	// $path akan otomatis hanya berisi '/' jika aplikasi ada di document_root
	// web server, jadi tidak perlu diberi trailing '/'
	if ($path !== '/') {
		// aplikasi bukan ada di document_root jadi pasti ada path tambahan
		// jadi tambahkan trailing slash
		$path = $path . '/';
	}
	
	$_MR['base_url'] = $protocol . $host . $path;
}

include_once(BASE_PATH . '/mr/' . 'db_config.php');
include_once(BASE_PATH . '/mr/' . 'functions.php');

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

// load models
load_model('users');
load_model('options');

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
run_hooks('boot_post_libraries_load');

// letakkan hooks sebelum proses koneksi ke database
run_hooks('boot_pre_db_conn');

// konek ke database
$_MR['db'] = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Untuk menjaga kompatibilitas dengan PHP versi < 5.2.9 maka pengecekan error
// dilakukan secara prosedural
if (mysqli_connect_error()) {
	exit('DB_ERROR(' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

// hooks setelah koneksi db
run_hooks('boot_post_db_conn');

// set all options from database to global variabel
set_all_options();
run_hooks('boot_post_options_load');

run_hooks('boot_pre_session_init');
// init session
mr_session_construct();
run_hooks('boot_post_session_init');

// load plugins
load_plugins();
run_hooks('boot_post_plugins_load');

// init user role
run_hooks('boot_pre_user_role');
init_user_role();
run_hooks('boot_post_user_role');
site_debug(print_r($_MR['user'], TRUE), 'CURRENT USER');
