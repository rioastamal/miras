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
	global $_MR;
	
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
	
	
	$artikel = array();
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array $artikel
		$artikel[] = $row;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $artikel);
	}
	
	// tutup result
	$result->close();
	
	// kembalikan hasil
	return $artikel;
}


/**
 * Method untuk memasukkan kategori
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param object $kat object kategori yang akan passing ke query
 * @return boolean SUKSES atau gagalnya query dilakukan
 */
function insert_kategori($kat) {
	global $_MR;
	
	/**
	 * Attribut dari parameter pertama $kat diharapkan seperti berikut:
	 * $kat->kategori_nama
	 */
	$query = "INSERT INTO kategori (kategori_nama) VALUES (?)";
	// selalu gunakan prepared statement untuk insert
	$stmt = $_MR['db']->prepare($query);
	
	// bind parameter dengan tipe string 's'
	$stmt->bind_param('s', $nama_kat);
	
	// variabel parameter selalu dipassing by reference oleh fungsi bind_param
	$nama_kat = $kat->kategori_nama;
	
	// waktnya eksekusi
	$result = $stmt->execute();
	
	// masukkan query ke variabel global last_query
	set_last_query($query);
	increase_query_number();
	
	// tutup prepared statement
	$stmt->close();
	
	if (!$result) {
		// query error
		return FALSE;
	}
	
	return TRUE;	// jika sampai disini maka everything is ok
}
