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
	
	$_B21['query_cache_enable'] = TRUE;
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
	
	$_B21['query_cache_enable'] = FALSE;
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
	
	return $_B21['query_cache_enable'];
}

/**
 * Fungsi untuk melakukan caching query, step-by-step yang dilakukan adalah:
 * 1. Convert query ke MD5 hash
 * 2. Cek di direktori BASE_PATH/cache/query/md5-hash.php apakah ada file yang 
 *    dimaksud.
 * 3. Jika tidak ada, maka buat file baru tersebut dengan isi dari hasil query 
 *    yang telah di-'serialize'
 * 4. Jika file tersebut ada maka, ambil isi dari file tersebut lalu lakukan
 *    'unserialize' untuk mengubah string ke PHP code awal.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @param string $query SQL query yang akan dicache
 * @param int $expire berapa lama cache akan disimpan, dalam detik. (0 = langsung expire atau > 0 untuk penentuan sendiri)
 * @return mixed hasil dari cache query
 */
function query_cache_result($query, $expire=60) {
	
}
