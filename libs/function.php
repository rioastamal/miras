<?php

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
	// load model dari base path
	// hasilnya adalah /path/to/berita21/models/nama_model.php
	$path_file = BASE_PATH . '/models/' . $model_name . '_model.php';
	
	// jika file tidak ada maka model tidak bisa diload
	if (!file_exists($path_file)) {
		// keluar dari sistem
		exit ("Model '{$model_name}' tidak ada pada path system.");
	}
	
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
	
	$_B21['flash_class'] = $message;
}
