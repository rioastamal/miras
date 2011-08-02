<?php

/**
 * Fungsi untuk menampilkan debugging info jika diaktifkan dalam konfigurasi
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $message pesan yang akan ditampilkan di debugging
 * @param string $title judul dari info debugging
 * @param string $separator string pemisah antara judul dan pesan
 * @return void
 */
function site_debug($message, $title='DEBUG: ', $separator='==>') {
	global $_B21;
	
	// jika debug mode diaktifkan maka jalankan proses debugging
	if ($_B21['debug_mode']) {
		$debug = '<strong>' . $title . '</strong> ' . $separator . ' ';
		$debug .= $message . "\n";
		
		$_B21['debug_message'] .= $debug;
	}
}

/**
 * Fungsi untuk mencetak pesan debugging
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function show_debug() {
	global $_B21;
	
	if ($_B21['debug_mode']) {
		echo ("\n<hr/>\n");
		echo ('<pre><h2>DEBUGGING MESSAGE</h2>' . "\n");
		echo ($_B21['debug_message']);
		echo ('</pre>');
	}
}
 
/**
 * Fungsi untuk meload model database.
 *
 * <code>
 * // jika akan meload model dengan nama 'kategori_model.php' maka cara penulisannya adalah
 * load_model('kategori');
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $model_name nama dari model yang akan diload
 * @return void
 */
function load_model($model_name) {
	global $_B21;
	
	// cek apakah model sudah pernah diload atau belum
	if (in_array($model_name, $_B21['loaded_models'])) {
		// model sudah diload, jadi tidak perlu dilanjutkan
		// save CPU and memory ;)
		return;
	}
	
	// load model dari base path
	// hasilnya adalah /path/to/berita21/models/nama_model.php
	$path_file = BASE_PATH . '/models/' . $model_name . '_model.php';
	
	// jika file tidak ada maka model tidak bisa diload
	if (!file_exists($path_file)) {
		// keluar dari sistem
		exit ("Model '{$model_name}' tidak ada pada path system.");
	}
	
	// masukkan $model_name ke daftar model yang sudah diload
	$_B21['loaded_models'][] = $model_name;
	
	include_once ($path_file);
}

/**
 * Fungsi untuk meload sebuah library.
 *
 * <code>
 * // jika akan meload library dengan nama 'kategori_lib.php' maka cara penulisannya adalah
 * load_library('kategori');
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $lib_name nama dari library yang akan diload
 * @return void
 */
function load_library($lib_name) {
	global $_B21;
	
	// cek apakah library sudah pernah diload atau belum
	if (in_array($lib_name, $_B21['loaded_libraries'])) {
		// library sudah diload, jadi tidak perlu dilanjutkan
		// save CPU and memory ;)
		return;
	}
	
	// load library dari base path
	// hasilnya adalah /path/to/berita21/libraries/nama_lib.php
	$path_file = BASE_PATH . '/libraries/' . $lib_name . '_lib.php';
	
	// jika file tidak ada maka library tidak bisa diload
	if (!file_exists($path_file)) {
		// keluar dari sistem
		exit ("Library '{$lib_name}' tidak ada pada path system.");
	}
	
	// masukkan $lib_name ke daftar library yang sudah diload
	$_B21['loaded_libraries'][] = $lib_name;
	
	include_once ($path_file);
}

/**
 * Fungsi untuk meload view HTML.
 *
 * <code>
 * // jika akan meload view dengan nama 'kategori_view.php' maka cara penulisannya adalah
 * load_view('kategori');
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $view_name nama dari view yang akan diload
 * @param array $data data yang akan di passing ke views
 * @return void
 */
function load_view($view_name, &$data=NULL) {
	global $_B21;
	
	$theme = $_B21['theme'];
	
	// load view dari base path
	// hasilnya adalah /path/to/berita21/views/nama_theme/nama_model.php
	$path_file = BASE_PATH . '/views/' . $theme . '/' . $view_name . '_view.php';
	
	// jika file tidak ada maka view tidak bisa diload
	if (!file_exists($path_file)) {
		// keluar dari sistem
		exit ("View '{$view_name}' tidak ada pada path system.");
	}
	
	include_once ($path_file);
}

/**
 * Fungsi untuk mengembalikan nilai dari konfigurasi base_url, views dapat
 * menggunaman fungsi ini untuk meload URL lengkap css dan javascript
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string base url dari aplikasi
 */
function get_base_url() {
	global $_B21;
	
	return $_B21['base_url'];
}

/**
 * Fungsi untuk mengembalikan nilai dari konfigurasi base_url + index_page, views dapat
 * menggunaman fungsi ini untuk meload URL lengkap css dan javascript
 *
 * Contoh jika konfigurasi index_page adalah index.php maka output dari fungsi
 * ini adalah:
 * http://example.com/index.php
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string base url + index_page dari aplikasi
 */
function get_site_url() {
	global $_B21;
	
	return $_B21['base_url'] . $_B21['index_page'];
}

/**
 * Fungsi untuk mengembalikan nilai dari konfigurasi base_url + nama theme + '/' 
 * yang saat ini digunakan. Views dapat menggunaman fungsi ini untuk meload URL 
 * lengkap css dan javascript.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string base url dari aplikasi + nama theme + slash
 */
function get_theme_url() {
	global $_B21;
	
	return $_B21['base_url'] . 'views/' . $_B21['theme'] . '/';
}

/**
 * Fungsi untuk mengembalikan nilai dari konfigurasi judul halaman, dapat 
 * digunakan didalam views.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string judul dari halaman
 */
function get_page_title() {
	global $_B21;
	
	return $_B21['title'];
}

/**
 * Fungsi untuk men-set nilai dari konfigurasi judul halaman, biasanya  
 * digunakan didalam controller sebelum meload views.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $title judul dari halaman
 * @return void
 */
function set_page_title($title='') {
	global $_B21;
	
	$_B21['title'] = $title;
}

/**
 * Fungsi untuk men-set nilai dari variabel flash message
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $message pesan flash message yang akan diberikan
 * @return void
 */
function set_flash_message($message='') {
	global $_B21;
	
	$_B21['flash_message'] = $message;
}

/**
 * Fungsi untuk mengambil nilai dari flash message
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string flash message
 */
function get_flash_message() {
	global $_B21;
	
	if (!$_B21['flash_message']) {
		// jika tidak ada sesuatu di flash message, kembalikan saja kosongan
		return '';
	}
	
	$mesg = '<div class="flash ' . $_B21['flash_class'] . '">' . $_B21['flash_message'] . '</div>' . "\n";
	return $mesg;
}

/**
 * Fungsi untuk men-set nilai dari variabel flash class
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $clas CSS class dari div flash message
 * @return void
 */
function set_flash_class($class='') {
	global $_B21;
	
	$_B21['flash_class'] = $class;
}

/**
 * Fungsi untuk melakukan routing dari URL ke sebuah file controller
 *
 * <code>
 * // jika ada sebuah URL seperti berikut:
 * //  http://localhost/berita21/index.php/foo-bar
 * $controller = map_controller();
 *
 * // maka nila dari controller (asumsi lokasi root direktori webserver adalah /opt/lampp/htdocs)
 * // adalah /opt/lampp/htdocs/controllers/foo_bar_ctl.php
 * // sehingga file contrroler dapat di include dengan peritnah
 * include_once( $controller );
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string lokasi dari file controller
 * @throws Exception
 */
function map_controller() {
	global $_B21;
	
	$file = '';
	$index = $_B21['index_page'];
	$controller = $_B21['default_controller'];
	$uri = $_SERVER['REQUEST_URI'];
	
	// fix slash ganda // dengan single / jika memang terjadi
	$uri = preg_replace('@//+@', '/', $uri);
	
	// split $index dari the uri 
	$split = explode($index, $uri);		
	site_debug( print_r($split, TRUE), 'URI INDEX' );
	
	// get the controller
	if (@$split[1]) {
		// cek apakah potongan URI setelah index.php cocok dengan REGEX
		// seperti dibawah ini
		if (preg_match('@/([a-zA-Z0-9\-_]+)/?([a-zA-Z0-9\-_]+)?(.*)@', $split[1], $matches)) {
			site_debug( print_r($matches, TRUE), 'CONTROLLER MATCHING' );
			$controller = $matches[1];
			
			// split $matches[3] dari /
			$arguments = preg_split('@/@', $matches[3], -1, PREG_SPLIT_NO_EMPTY);
			$_B21['controller_arguments'] = $arguments;
			site_debug( print_r($arguments, TRUE), 'CONTROLLER ARGUMENT' );
		}
	}
	
	// semua controller harus diconvert ke underscore karena konvensi nama file
	// controller diharuskan seperti itu (sesuai dengan coding guide awal)
	$controller = str_replace('-', '_', $controller);
	
	// cek apakah controller merupakan direktori atau tidak
	if (is_dir(BASE_PATH . '/controllers/' . $controller)) {
		// controller merupakan direktori jadi tambahkan dengan variabel
		// $matches yang ber-index 2
		site_debug($controller, 'CONTROLLER DIRECTORY');

		// ubah hypen(-) ke underscore jika memang terdapat simbol tersebut
		$real_controller = str_replace('-', '_', $matches[2]);
		$controller = $controller . '/' . $real_controller;
	}
	
	// map controller ke file yang bersangkutan
	$file = BASE_PATH . '/controllers/' . $controller . '_ctl.php';
	site_debug($file, 'FULL CONTROLLER PATH');
	
	// file exists?
	if (file_exists($file)) {
		return $file;
	}
	
	// jika sampai disini maka controller tidak ditemukan jadi thrown exception
	throw new Exception ("Controller {$controller} tidak ditemukan.");
}

/**
 * Funcgis untuk mendapatkan argument yang dipassing ke halaman controller
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param integer $index => index array argument yang dicari
 * @return mixed|boolean
 */
function get_argument($index=0) {
	global $_B21;
	
	// cek apakah index tersebut ada pada array controller argument atau tidak
	if (array_key_exists($index, $_B21['controller_arguments'])) {
		// index ada berarti diasumsikan juga ada nilainya
		// maka kembalikan array dengan index yang diminta
		return $_B21['controller_arguments'][$index];
	}
	
	// jika sampai disini berarti index array tidak ada
	return FALSE;
}

/**
 * Fungsi untuk menambah jumlah query yang telah dieksekusi. Setiap fungsi model
 * SEHARUSNYA mengeksekusi fungsi ini setiap kali selesai melakukan query
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function increase_query_number() {
	global $_B21;
	
	// tambah dengan satu
	$_B21['query_number'] += 1;
}

/**
 * Fungsi untuk mendapatkan jumlah query yang telah dilakukan oleh model
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return int jumlah query yang telah dilakukan
 */
function get_query_number() {
	global $_B21;
	
	return $_B21['query_number'];
}

/**
 * Fungsi untuk menyimpan query terakhir yang dilakukan oleh suatu model. Setiap
 * fungsi model SEHARUSNYA mengeksekusi fungsi ini setiap kali selesai melakukan
 * query
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $query query yang dijalankan
 * @return void
 */
function set_last_query($query) {
	global $_B21;
	
	$_B21['last_query'] = $query;
}

/**
 * Fungsi untuk mendapatkan query terakhir yang dilakukan oleh suatu model.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string query terakhir yang dijalankan
 */
function get_last_query() {
	global $_B21;
	
	return $_B21['last_query'];
}
