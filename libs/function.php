<?php

/**
 * Fungsi untuk meload model database
 */
function load_model($model_name) {
	// load model dari base path
	// hasilnya adalah /path/to/berita21/models/nama_model.php
	$path_file = BASE_PATH . '/models/' . $model_name;
	
	// jika file tidak ada maka model tidak bisa diload
	if (!file_exists($path)) {
		// keluar dari sistem
		exit ("Model '{$model_name}' tidak ada pada path system.");
	}
	
	include_once ($path_file);
}
