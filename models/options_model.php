<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel options
 *
 * @package models
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk melakukan update pada option
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $option_name 
 * @param string $option_value
 */
function update_option($option_name, $option_value) {
	global $_MR;
	
	$_MR['options'][$option_name] = $option_value;
	
	// cek nilai dari option value jika berupa string atau object maka serialize
	// nilai tersebut agar bisa dimasukkan ke database
	if (is_array($option_value) || is_object($option_value)) {
		$option_value = serialize($option_value);
	}
}

/**
 * Method untuk memasukkan options
 * @param object $opt object options yang akan passing ke query
 * @return boolean SUKSES atau gagalnya query dilakukan
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 */
function insert_options($opt_name, $opt_value, $opt_autoload=1) {
	global $_MR; 
	
	// mengecek $opt_value apakah array atau jika iya maka diserialize terlebih dahulu
	if (is_array($opt_value) || is_object($opt_value)) {
		$opt_value = serialize($opt_value);
	}
	
	$query = "INSERT INTO options (option_name, option_value, option_autoload) VALUES (?, ?, ?)";
	// selalu gunakan prepared statement untuk insert
	$stmt = $_MR['db']->prepare($query);
	// bind parameter dengan tipe string 's'
	$stmt->bind_param('ssi', $name_opt, $value_opt, $autoload_opt);
	
	// variabel parameter selalu dipassing by reference oleh fungsi bind_param
	$name_opt = $opt_name;
	$value_opt = $opt_value;
	$autoload_opt = $opt_autoload;
	
	// waktnya eksekusi
	$result= $stmt->execute();

	// masukkan query ke variabel global last_query
	set_last_query($query);
	increase_query_number();

	// tutup prepared statement
	$stmt->close();
	
	//jika execute gagal maka kembalikan FALSE
	if (!$result) {
		// query error
		return FALSE;
	}
	
	return TRUE;	// jika sampai disini maka everything is ok
}

/* File ini berisi query yg berhubungan dengan option
 *
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 *
 */
function set_all_options() {
	global $_MR;
	// select option name dan value dimana option_autoload bernilai '1'
	$query = 'SELECT option_name, option_value 
	          FROM options
	          WHERE option_autoload = 1';
	
	$result = $_MR['db']->query($query);
	if ($result === FALSE) {
		// query error
		return FALSE;
	}
	
	// increment status dari jumlah query yang telah dijalankan
	increase_query_number();
	
	// masukkan data query terakhir
	set_last_query($query);
	
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array 
		$opt_value = NULL;
		$temp = unserialize($row->option_value);
		if ($temp !== FALSE) {
			$opt_value = $temp;
		} else {
			$opt_value = $row->option_value;
		}
		
		$_MR['options'][$row->option_name] = $opt_value;
	}
	
	// tutup result
	$result->close();
}
