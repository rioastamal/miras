<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel artikel
 */

 
 /**
 * Fungsi untuk menampilkan artikel terbaru dari masing-masing kategori
 * @author : Miftah Faridl
 * @since Version 1.0
 * @example BASE_PATH/test/test_kategori.php
 */
function get_latest_article($last=10) {
	
	$query = 'SELECT ar.artikel_id, ar.artikel_judul, ar.artikel_isi, ar.artikel_tgl, kt.kategori_id, kt.kategori_nama FROM (artikel ar LEFT JOIN artikel_kategori ak ON ar.artikel_id = ak.artikel_id)
				LEFT JOIN kategori kt ON ak.kategori_id = kt.kategori_id 
				ORDER BY ar.artikel_tgl DESC LIMIT 10';
				
	$result = mysql_query($query);
	
	if (!$result) {
		// query error
		return FALSE;
	}
	
	$artikel = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $artikel
		$artikel[] = $data;
	}
	// kembalikan hasil
	return $artikel;
}

/**
 * Fungsi untuk menampilkan artikel yang paling banyak terkomentari
 */
function get_most_commented_article($last=5) {
	
}

