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
			
	$result = mysql_query($query);
	
	if (!$result) {
		// query error
		return FALSE;
	}
	
	$artikel = array();
	while ($data = mysql_fetch_object($result)) {
		// masukkan data setiap result object ke array $artikel
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
	
	$result = mysql_query($query);
	
	if (!$result) {
		// query error
		return FALSE;
	}
	
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
	 
	 $id_artikel = mysql_insert_id();
	 
	 $query2 = "INSERT INTO artikel_kategori (artikel_id, kategori_id) VALUES
				('{$id_artikel}','{$art->kategori_id}')";
	 $result = mysql_query($query2);
	 
	 if (!$result) {
		 //query error
		 return FALSE;
	 }
	 
	 return TRUE; //jika sampai di sini everythings gonna be OK 
}
