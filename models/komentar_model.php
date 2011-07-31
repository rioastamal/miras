<?php
/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel komentar
 *
 * @package models
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk mendapatkan seluruh komentar 5 terakhir
 * pada artikel tersebut
 *
 * @author irianto bunga <me@iriantobunga.com>
 * @since Version 1.0
 * @example BASE_PATH/test/test_komentar.php
 *
 * @param integer $last=5
 * @return array|boolean daftar komentar lima terakhir dalam array of object, FALSE ketika error
 */
 
function get_last_commented_article($last=5) {
	// query mengambil 5 komentar terakhir
	$query = 'SELECT kmt.*, art.artikel_id, art.artikel_judul
				FROM komentar AS kmt 
				LEFT JOIN (artikel_komentar AS ak) ON (kmt.komentar_id=ak.komentar_id)
				LEFT JOIN (artikel art) ON (ak.artikel_id=art.artikel_id)
				ORDER BY kmt.komentar_tgl DESC
				limit '.$last;
				
	// cek apakah query cache diaktifkan?
	if (query_cache_status() == TRUE) {
		// OK, query cache diaktifkan 
		// sekarang mari coba ambil cache dari file
		$result = query_cache_data($query, 10);
		site_debug(print_r($result, TRUE), "CACHE QUERY");
		
		// cek $result, jika tidak FALSE maka query cache ada, jadi
		// berhenti sampai disini saja. Namun jika tidka ada maka jalankan
		// query biasa (atau lanjut terus ke kode dibawah)
		if ($result !== FALSE) {
			return $result;
		}
	} 
	
	$result = mysql_query($query);
	if (!$result) {
		// query error
		return FALSE;
	}
	
	// query OK
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	$komentar = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $data;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $komentar);
	}
	
	// kembalikan hasil
	return $komentar;
}

function get_most_commented_article() {
	// query mengambil jumlah kometar terbanyak pada artikel tersebut
	$query = 'SELECT art.artikel_judul ,count(ak.artikel_id) as jml
				FROM artikel_komentar AS ak
				LEFT JOIN (artikel AS art) ON (ak.artikel_id=art.artikel_id)
				GROUP BY ak.artikel_id
				ORDER BY jml DESC';
				
	// cek apakah query cache diaktifkan?
	if (query_cache_status() == TRUE) {
		// OK, query cache diaktifkan 
		// sekarang mari coba ambil cache dari file
		$result = query_cache_data($query, 10);
		site_debug(print_r($result, TRUE), "CACHE QUERY");
		
		// cek $result, jika tidak FALSE maka query cache ada, jadi
		// berhenti sampai disini saja. Namun jika tidka ada maka jalankan
		// query biasa (atau lanjut terus ke kode dibawah)
		if ($result !== FALSE) {
			return $result;
		}
	}
				
	$result = mysql_query($query);
	if (!$result) {
		// query error
		return FALSE;
	}
	
	// query OK
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	$komentar = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $data;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $komentar);
	}
	
	// kembalikan hasil
	return $komentar;
}

/**
 * Method untuk memasukkan komentar
 * @param object $kmt object komentar yang akan passing ke query
 * @return boolean SUKSES atau gagalnya query dilakukan
 */
function insert_komentar($kmt) {
	/**
	 * Attribut dari parameter pertama $kmt diharapkan seperti berikut:
	 * $kmt->komentar_nama
	 * 
	 */
	$query = "INSERT INTO komentar (komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES ('{$kmt->komentar_nama}', '{$kmt->komentar_email}', '{$kmt->komentar_isi}', '{$kmt->komentar_tgl}')";
	$result = mysql_query($query);
	$kmt_id = mysql_insert_id();
	
	$query = "INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES ('{$kmt->artikel_id}', '$kmt_id')";
	$result = mysql_query($query);
	
	// masukkan query ke variabel global last_query
	set_last_query($query);
	increase_query_number();
	
	if (!$result) {
		// query error
		return FALSE;
	}
	
	return TRUE;	// jika sampai disini maka everything is ok
}
?>
