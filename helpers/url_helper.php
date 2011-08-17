<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini menyimpan kumpulan fungsi-fungsi yang berhubungan akses atau
 * manipulasi terkait URL
 *
 * @package helpers
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

/**
 * Fungsi untuk mendapatkan argumen berdasarkan $key.
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 * @return mixed|FALSE
 */
function get_argument_by($key) {
	global $_MR;
	
	// cek apakah $key ada dalam array
	// hasilnya akan boolean FALSE jika tidak ada
	$index_key = array_search($key, $_MR['controller_arguments']);
	if ($index_key === FALSE) {
		// key tidak ada 
		return FALSE;
	}
	
	// jika index_key ganjil berarti parameter yang diberikan
	// tidak tepat, kembalikan saja FALSE
	if ($index_key % 2 != 0) {
		return FALSE;
	}
	
	// jika sampai disini berarti nilai $key ada
	// namun apakah valuenya (index + 1) ada?
	$index_value = $index_key + 1;
	if (array_key_exists($index_value, $_MR['controller_arguments'])) {
		// ok, ada maka kembalikan hasilnya
		return $_MR['controller_arguments'][$index_value];
	}
	
	return FALSE; // array dengan index_key + 1 tidak ada
}

/**
 * Fungsi untuk meload url yang sedang diakses.
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 * @return void
 */
function get_current_url() {
	$request_uri = $_SERVER['REQUEST_URI'];
	$host = $_SERVER['HTTP_HOST'];
	
	// jika port 80 maka http selain itu 
	$protocol = 'http://';
	
	// jika nilai $_SERVER['HTTPS'] ada dan tidak berisi 'off' (untuk IIS server)
	// maka protokol yang digunakan adalah https://
	if (isset($_SERVER['HTTPS'])) {
		if ($_SERVER['HTTPS'] !== 'off') {
			$protocol = 'https://';
		}
	}
	
	$current_url = $protocol . $host . $request_uri;
	return $current_url;
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
	global $_MR;
	
	return $_MR['base_url'];
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
	global $_MR;
	
	return $_MR['base_url'] . $_MR['index_page'];
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
	global $_MR;
	
	return $_MR['base_url'] . 'views/' . $_MR['theme'] . '/';
}

