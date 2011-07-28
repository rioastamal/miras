<?php

/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan caching SQL query
 *
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk mengaktifkan query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return void
 */
function query_cache_enable() {
	global $_B21;
	
	$_B21['enable_query_cache'] = TRUE;
}

/**
 * Fungsi untuk menon-aktifkan query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return void
 */
function query_cache_disable() {
	global $_B21;
	
	$_B21['enable_query_cache'] = FALSE;
}

/**
 * Fungsi untuk mendapatkan status aktif atau tidaknya query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return boolean aktif atau tidaknya query cache
 */
function query_cache_status() {
	global $_B21;
	
	return $_B21['enable_query_cache'];
}

/**
 * Fungsi untuk menulis cache hasil query
 * 
 * @param string $query SQL query yang dicache
 * @param string $data data yang akan ditulis ke cache
 * @return void
 */
function query_cache_write($query, $data) {
	// Ubah query menjadi MD5 hash, simpan hasil cache pada file hash ini
	$file_hash = BASE_PATH . '/cache/query/' . md5($query) . '.php';
	
	// Ubah data ke dalam bentuk serialized string
	$data_cache = serialize($data);
	
	// tulis data yang telah di-serialize ke file
	file_put_contents($file_hash, $data_cache);
}

/**
 * Fungsi untuk mendapatkan cache query
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @param string $query SQL query yang akan dicache
 * @return mixed|boolean hasil dari cache query
 */
function query_cache_data($query) {
	// Ubah query menjadi MD5 hash
	$file_hash = BASE_PATH . '/cache/query/' . md5($query) . '.php';
	
	// jika file sudah ada berarti telah ada cache sebelumnya, oleh
	// karena itu ambil data dari cache lalu berhenti
	if (file_exists($file_hash)) {
		// cache disimpan dalam bentuk serialized string jadi harus 
		// diconvert dulu ke dalam bentuk PHP agar dapat digunakan
		$cached = file_get_contents($file_hash);
		$cached = unserialize($cached);
		return $cached;
	}
	
	return FALSE;	// tidak ada cache yang dikembalikan
}
