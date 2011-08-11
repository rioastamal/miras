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
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 * @example BASE_PATH/test/test_komentar.php
 *
 * @param integer $last=5
 * @return array|boolean daftar komentar lima terakhir dalam array of object, FALSE ketika error
 */
 
function get_comment_by_article_id($id=0) {
	global $_MR;
	
	// query mengambil komentar berdasarkan id artikel
	$query = 'SELECT kmt.*, art.artikel_id, art.artikel_judul
				FROM komentar AS kmt 
				LEFT JOIN (artikel_komentar AS ak) ON (kmt.komentar_id=ak.komentar_id)
				LEFT JOIN (artikel art) ON (ak.artikel_id=art.artikel_id)
				WHERE art.artikel_id = ' . $id .
				' ORDER BY kmt.komentar_tgl DESC';
				
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
	
	$result = $_MR['db']->query($query);
	if ($result === FALSE) {
		// query error
		return FALSE;
	}
	
	// query OK
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	$komentar = array();
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $row;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $komentar);
	}
	
	// tutup result
	$result->close();
	
	// kembalikan hasil
	return $komentar;
}
 
function get_last_commented_article($last=5) {
	global $_MR;
	
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
	
	$result = $_MR['db']->query($query);
	if ($result === FALSE) {
		// query error
		return FALSE;
	}
	
	// query OK
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	$komentar = array();
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array $artikel
		$komentar[] = $row;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $komentar);
	}
	
	// tutup result
	$result->close();
	
	// kembalikan hasil
	return $komentar;
}

function get_most_commented_article() {
	global $_MR;
	
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
				
	$result = $_MR['db']->query($query);
	if ($result === FALSE) {
		// query error
		return FALSE;
	}
	
	// query OK
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	$komentar = array();
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array $komentar
		$komentar[] = $row;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $komentar);
	}
	
	// tutup result
	$result->close();
	
	// kembalikan hasil
	return $komentar;
}

/**
 * Method untuk memasukkan komentar
 * @param object $kmt object komentar yang akan passing ke query
 * @return boolean SUKSES atau gagalnya query dilakukan
 */
function insert_komentar($kmt) {
	global $_MR; 
	
	/**
	 * Attribut dari parameter pertama $kmt diharapkan seperti berikut:
	 * $kmt->komentar_nama
	 * 
	 */
	
	$query = "INSERT INTO komentar (komentar_nama, komentar_email, komentar_isi, komentar_tgl) VALUES (?, ?, ?, ?)";
	// selalu gunakan prepared statement untuk insert
	$stmt = $_MR['db']->prepare($query);
	// bind parameter dengan tipe string 's'
	$stmt->bind_param('ssss', $nama_kmt, $email_kmt, $isi_kmt, $tgl_kmt);
	
	// variabel parameter selalu dipassing by reference oleh fungsi bind_param
	$nama_kmt = $kmt->komentar_nama;
	$email_kmt = $kmt->komentar_email;
	$isi_kmt = $kmt->komentar_isi;
	$tgl_kmt = $kmt->komentar_tgl;
	
	// waktnya eksekusi
	$result= $stmt->execute();
	
	$kmt_id = $_MR['db']->insert_id;
	
	// tutup prepared statement
	$stmt->close();
	
	//jika execute ke 1 gagal maka kembalikan FALSE
	if (!$result) {
		// query error
		return FALSE;
	}
	
	$query = "INSERT INTO artikel_komentar (artikel_id, komentar_id) VALUES (?, ?)";
	$stmt = $_MR['db']->prepare($query);
	// bind parameter dengan tipe string 's'
	$stmt->bind_param('ss', $id_art, $id_kmt);

	// variabel parameter selalu dipassing by reference oleh fungsi bind_param
	$id_art = $kmt->artikel_id;
	$id_kmt = $kmt_id;
	
	// waktnya eksekusi
	$result = $stmt->execute();
	
	// masukkan query ke variabel global last_query
	set_last_query($query);
	increase_query_number();
	
	// tutup prepared statement
	$stmt->close();
	
	// jika execute ke 2 gagal maka kembalikan FALSE
	if (!$result) {
		// query error
		return FALSE;
	}
	
	return TRUE;	// jika sampai disini maka everything is ok
}
?>
