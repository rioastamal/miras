<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel artikel
 */

 
 /**
 * Fungsi untuk menampilkan artikel terbaru dari masing-masing kategori
 * @author Alfa Radito Sii Anak Ganteng <qwertqwe16@yahoo.co.id>, Miftah Faridl
 * @since version 1.0
 * @example BASE_PATH/models/artikel_model.php
 */
function get_latest_article($last=10) {
	// query untuk menampilkan 10 artikel terbaru
	$query = 'SELECT a.artikel_id, a.artikel_judul, a.artikel_isi, a.artikel_tgl, k.kategori_id, k.kategori_nama
			FROM artikel_kategori ak 
			LEFT JOIN artikel a ON ak.artikel_id = a.artikel_id
			LEFT JOIN kategori k ON ak.kategori_id = k.kategori_id
			ORDER BY a.artikel_tgl DESC
			LIMIT ' . $last;
			
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
	
	
	$artikel = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan data setiap result object ke array $artikel
		$artikel[] = $data;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $artikel);
	}
	// kembalikan hasil
	return $artikel;
}

/**
 * Fungsi untuk menampilkan artikel berdasarkan judul dan isi
 */
function get_article_based_on($judul='', $isi='') {
	
	if ($judul=='' && $isi!='') {
		$query = 'SELECT * FROM artikel
			  WHERE artikel_isi LIKE \'%'.$isi.'%\'';
	} elseif ($judul!='' && $isi=='') {
		$query = 'SELECT * FROM artikel
			  WHERE artikel_judul LIKE \'%'.$judul.'%\'';
	} elseif ($judul!='' && $isi!='') {
		$query = 'SELECT * FROM artikel
			  WHERE artikel_judul LIKE \'%'.$judul.'%\' OR artikel_isi LIKE \'%'.$isi.'%\'';
	} else {
		
		return array();
	}
	
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
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	
	$artikel = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan data setiap result object ke array $artikel
		$artikel[] = $data;
	}
	// kembalikan hasil
	return $artikel;
}

/**
 * @author : Miftah Faridl
 * @email  : vcode84@gmail.com
 * @date   : July,12,2011
 */ 
 
function insert_artikel($art) {
	/**
	 * Atribut dari parameter pertama $art diharapkan seperti berikut :
	 * $art->artikel_judul
	 */
	 
	 $query = "INSERT INTO artikel (artikel_judul, artikel_isi, artikel_tgl) VALUES 
				('{$art->artikel_judul}','{$art->artikel_isi}','{$art->artikel_tgl}')";
				
	
				
	 $result = mysql_query($query);
	 
	 if (!$result) {
		 //query error
		 return FALSE;
	 }
	 
	  // masukkan query ke variabel global last_query
		set_last_query($query);
		increase_query_number();
	 
	 $id_artikel = mysql_insert_id();
	 
	 $query2 = "INSERT INTO artikel_kategori (artikel_id, kategori_id) VALUES
				('{$id_artikel}','{$art->kategori_id}')";
	 $result = mysql_query($query2);
	 
	 
	 if (!$result) {
		 //query error
		 return FALSE;
	 }
	 
	  // masukkan query ke variabel global last_query
	set_last_query($query);
	increase_query_number();
	 
	 return TRUE; //jika sampai di sini everythings gonna be OK 
}

function get_article_by_id($id='') {
	// query untuk menampilkan 10 artikel terbaru
	$query = "SELECT a.artikel_id, a.artikel_judul, a.artikel_isi, a.artikel_tgl, k.kategori_id, k.kategori_nama
			FROM artikel_kategori ak 
			LEFT JOIN artikel a ON ak.artikel_id = a.artikel_id
			LEFT JOIN kategori k ON ak.kategori_id = k.kategori_id
			WHERE a.artikel_id = '{$id}'
			ORDER BY a.artikel_tgl DESC";
			
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
	
	
	$artikel = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan data setiap result object ke array $artikel
		$artikel[] = $data;
	}
	
	// masukkan hasil query ke cache
	if (query_cache_status() == TRUE) {
		site_debug(print_r($result, TRUE), "WRITE QUERY CACHE");
		query_cache_write($query, $artikel);
	}
	// kembalikan hasil
	return $artikel;
}
