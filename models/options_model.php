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
 * Method untuk memasukkan options kedalam database
 * @return boolean SUKSES atau gagalnya query dilakukan
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 */
function option_insert_save() {
	global $_MR; 	
	
	$insert_cache = $_MR['options_insert_cache'];
	/* query dimasukkan kedalam array agar dapat melakukan multi_query
	 * val dari query diberi ' untuk type text, varchar
	 */
	foreach ($insert_cache as $opt_key => $opt_val) {
		$value = $opt_val['value'];
		$autoload = $opt_val['autoload'];
		$query[] = 'INSERT INTO options (option_name, option_value, option_autoload) VALUES (\'' . $opt_key . '\', \'' . $value . '\', ' . $autoload . ')';
	}

	// query digabungkan kedalam sebuat variable dengan pemisah ';'
	$query = implode(';', $query);

	// execute multi query
	$multi_query = $_MR['db']->multi_query($query);
	if ($multi_query === FALSE) {
		// query error atau sudah dipernah dimasukkan
		return FALSE;
	}
	
	// close connection
	$_MR['db']->close();
	
	return TRUE;
}

/**
 * Method untuk memasukkan options kedalam array $_MR['options'] dan $_MR['options_insert_cache']
 * @param String $opt_name 
 * @param String $opt_value
 * @param Integer optional $opt_autoload default 1
 * @return void
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 */
function insert_option($opt_name, $opt_value, $opt_autoload=1) {
	global $_MR; 
	
	// mengecek $opt_value apakah array atau jika iya maka diserialize terlebih dahulu
	if (is_array($opt_value) || is_object($opt_value)) {
		$opt_value = serialize($opt_value);
	}
	/* memasukkan opt_name sebagai key dan opt_value sebagai val pada _MR[options]
	*  memasukkan opt_name sebagai key dan array sebagai val pada _MR[options_insert_cache]
	*/
	$_MR['options'][$opt_name] = $opt_value;
	$_MR['options_insert_cache'][$opt_name] = array(
												'value' => $opt_value,
												'autoload' => $opt_autoload
											  );
}

/* File ini berisi query yg berhubungan dengan option
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 * @return void
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
