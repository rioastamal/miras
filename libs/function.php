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
