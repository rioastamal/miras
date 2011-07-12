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
	$result = mysql_query($query);
	
	if (!$result) {
		// query error
		return false;
	}
	
	$komentar = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $data;
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
	$result = mysql_query($query);
	
	if (!$result) {
		// query error
		return false;
	}
	
	$komentar = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $data;
	}
	
	// kembalikan hasil
	return $komentar;
}
?>
