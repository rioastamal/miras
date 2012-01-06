<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi konfigurasi utama untuk aplikasi
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
// Alamat Base URL dari aplikasi, harus diakhiri dengan '/' SLASH
// Misal: http://example.com/ atau http://example.com/path/to/miras/
// ---
// Apabila diisi dengan 'auto' maka Miras akan mencoba untuk melakukan
// penyusunan secara otomatis base_url
// ---
// Tips: Sebaiknya isi nilainya untuk menghemat beberapa bytes memory karena
// terbuang untuk pengecekan base_url
$_MR['base_url'] = 'auto';

// tema yang digunakan
$_MR['theme'] = 'default';

// Nama file yang menghandle mapping ke file controller
$_MR['index_page'] = 'index.php';

// status debugging diaktifkan atau tidak
// TRUE => Aktif
// FALSE => Tidak Diaktifkan
$_MR['debug_mode'] = TRUE;

// berapa lama default session expired (dalam detik)
$_MR['session_expires'] = 1800;	// default 30 menit

// nama cookie untuk session
$_MR['session_name'] = 'miras_session';

// lama jeda waktu session activity untuk diupdate
$_MR['session_time_to_update'] = 180;	// default 3 menit

// apakah user agent dan IP address dicocokkan
$_MR['session_strict_check'] = TRUE;

// path untuk cookie 
$_MR['cookie_path'] = '/';

// Super-admin User ID
$_MR['super_admin_id'] = 1;

// Guest User ID
$_MR['guest_user_id'] = 2;

// nama direktori untuk control panel Miras (ada didalam direktori controllers)
// default adalah 'control_panel'
$_MR['backend_dir'] = 'control_panel';

// nama session pengenal untuk backend control panel
// (disimpan pada session database)
$_MR['cp_session_name'] = 'miras_cpanel';

// ------------------ AKHIR KONFIGURASI ----------------------------- //

/* TIDAK PERLU MENGGANTI KONFIGURASI DIBAWAH INI KECUALI ANDA TAHU APA YANG
   ANDA LAKUKAN */

// default nama title dari halaman, seharusnya nanti akan di-overwrite 
// oleh controller
$_MR['title'] = '';

// flash message merupakan variabel yang menyimpan pesan sementara untuk 
// ditampilkan kepada user, misal pesan proses telah selesai dan sebagainya
$_MR['flash_message'] = '';

// CSS class dari div pesan flash
$_MR['flash_class'] = 'flash-warning';

// nama default controller jika user datang tanpa menyebutkan nama controller
$_MR['default_controller'] = 'main';

// pesan debugging akan disimpan pada variabel ini
$_MR['debug_message'] = '';

// variabel yang menyimpan nama-nama model yang telah diload ke memory
$_MR['loaded_models'] = array();

// variabel yang menyimpan nama-nama library yang telah diload ke memory
$_MR['loaded_libraries'] = array();

// variabel yang menyimpan nama-nama helper yang telah diload ke memory
$_MR['loaded_helpers'] = array();

// variabel yang menyimpan nama-nama plugin yang diload
$_MR['loaded_plugins'] = array();

/**
 * variabel yang menyimpan nama-nama script javascript yang telah diload ke 
 * pada page head.
 *
 * <code>
 *  // contoh
 *  $_MR['loaded_javascript']['jsname-1.0'] = 'http://example.com/views/default/jsname-1.0.js';
 * </code>
 */
$_MR['loaded_javascripts'] = array();

// variabel yang menyimpan nama-nama plugin yang gagal diload
$_MR['error_plugins'] = array();

// variabel yang menyimpan nama-nama hooks
$_MR['hooks'] = array();

// variabel yang menyimpan banyaknya query yang telah dieksekusi
$_MR['query_number'] = 0;

// variabel yang menyimpan SQL query terakhir yang dijalankan
$_MR['last_query'] = '';

// librari yang diload secara otomatis saat bootstrap
$_MR['autoload_libraries'] = array();
							
// variabel yang menyimpan option dari aplikasi
$_MR['options'] = array();

// variabel yang menyimoan option yang akan diinsert, update, atau delete 
// ke tabel options
// proses-proses tersebut akan dieksekusi diakhir script untuk mengurangi
// query overhead
$_MR['options_insert_cache'] = array();
$_MR['options_update_cache'] = array();
$_MR['options_delete_cache'] = array();


// variabel yang menyimpan daftar menu
$_MR['menus'] = array();

// variabel yang menyimpan daftar menu yang aktif
$_MR['active_menu'] = array();

// menggunakan query cache atau tidak
$_MR['enable_query_cache'] = FALSE;

// variabel yang menyimpan controller arguments
$_MR['controller_arguments'] = array();

// variabel yang menyimpan isi session
$_MR['sessions'] = array(
	'data' => array(),
	// insert, delete atau update (digunakan pada saat script berakhir)
	'action' => NULL,
	'id' => NULL
);

// variabel/flag yang menyimpan status apakah suatu controller adalah
// merupakan control panel (backend) atau tidak
$_MR['is_backend_controller'] = FALSE;
