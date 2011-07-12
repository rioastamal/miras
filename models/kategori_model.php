<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel kategori
 *
 * @package models
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk mendapatkan seluruh kategori beserta jumlah artikel yang ada
 * pada kategori tersebut
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * @example BASE_PATH/test/test_kategori.php
 *
 * @param boolean $jumlah_artikel apakah jumlah artikel juga diikutkan dalam query
 * @return array|boolean Daftar kategori dalam array of object, FALSE ketika error
 */
function get_all_kategori($jumlah_artikel=TRUE) {
	// apakah jumlah artikel juga diikutkan dalam hasil query?
	if ($jumlah_artikel) {
		// oh yeah, ikutkan...
		$query = 'SELECT kt.*, COUNT(ak.artikel_id) jml_artikel FROM kategori kt 
					LEFT JOIN artikel_kategori ak ON ak.kategori_id=kt.kategori_id
					GROUP BY kt.kategori_id
					ORDER BY kt.kategori_nama';
	} else {
		// Sepertinya pemanggil fungsi tidak butuh jumlah artikel
		// mari lakukan simple query saja
		$query = 'SELECT * FROM kategori ORDER BY kategori_nama';
	}
	$result = mysql_query($query);
	if (!$result) {
		// query error
		return FALSE;
	}
	
	$artikel = array();
	while ($row = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $artikel
		$artikel[] = $row;
	}
	// kembalikan hasil
	return $artikel;
}

/**
 * Fungi untuk mendapatkan 
 */
function get_most_commented_article($last=5) {
	
}

/**
 * Method untuk memasukkan kategori
 * @param object $kat object kategori yang akan passing ke query
 * @return boolean SUKSES atau gagalnya query dilakukan
 */
function insert_kategori($kat) {
	/**
	 * Attribut dari parameter pertama $kat diharapkan seperti berikut:
	 * $kat->kategori_nama
	 */
	$query = "INSERT INTO kategori (kategori_nama) VALUES ('{$kat->kategori_nama}')";
	$result = mysql_query($query);
	if (!$result) {
		// query error
		return FALSE;
	}
	
	return TRUE;	// jika sampai disini maka everything is ok
}
