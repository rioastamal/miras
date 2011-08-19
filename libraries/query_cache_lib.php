<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan untuk melakukan query caching.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi untuk mengaktifkan query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function query_cache_enable() {
	global $_MR;
	
	$_MR['enable_query_cache'] = TRUE;
}

/**
 * Fungsi untuk menon-aktifkan query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */
function query_cache_disable() {
	global $_MR;
	
	$_MR['enable_query_cache'] = FALSE;
}

/**
 * Fungsi untuk mendapatkan status aktif atau tidaknya query cache
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return boolean aktif atau tidaknya query cache
 */
function query_cache_status() {
	global $_MR;
	
	return $_MR['enable_query_cache'];
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
 * @since Version 1.0
 *
 * @param string $query SQL query yang akan dicache
 * @param int $expire Cache expire dalam detik
 * @return mixed|boolean hasil dari cache query
 */
function query_cache_data($query, $expire=60) {
	// Ubah query menjadi MD5 hash
	$file_hash = BASE_PATH . '/cache/query/' . md5($query) . '.php';
	
	// jika file sudah ada berarti telah ada cache sebelumnya, oleh
	// karena itu ambil data dari cache lalu berhenti
	if (file_exists($file_hash)) {
		// cek apakah file cache sudah expire atau belum
		$sekarang = time();
		
		// cek kapan terakhir kali file diubah/dibuat
		$file_modif = filemtime($file_hash);
		
		// kalkulasi perbedaan waktu jika selisih lebih besar dari waktu expire
		// yang telah ditentukan, berarti cache sudah tidak valid (EXPIRE)
		$selisih = $sekarang - $file_modif;
		if ($selisih > $expire) {
			// hapus file yang expired
			unlink($file_hash);
			return FALSE;	// cache sudah expired, cukup berhenti disini
		}
		
		
		// cache disimpan dalam bentuk serialized string jadi harus 
		// diconvert dulu ke dalam bentuk PHP agar dapat digunakan
		$cached = file_get_contents($file_hash);
		$cached = unserialize($cached);
		return $cached;
	}
	
	return FALSE;	// tidak ada cache yang dikembalikan
}
