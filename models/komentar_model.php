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
				FROM artikel AS art LEFT JOIN (artikel_komentar AS ak) ON (art.artikel_id=ak.artikel_id)
				LEFT JOIN (komentar kmt) ON (ak.komentar_id=kmt.komentar_id)
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
?>
