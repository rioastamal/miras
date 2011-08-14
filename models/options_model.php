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
 * 
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 * 
 * @return void
 */
function option_cache_save() {
	global $_MR; 	
	$query = array();
	
	// insert option
	$insert_cache = $_MR['options_insert_cache'];
	/* query dimasukkan kedalam array agar dapat melakukan multi_query
	 * val dari query diberi ' untuk type text, varchar
	 */
	foreach ($insert_cache as $opt_key => $opt_val) {
		$value = $_MR['db']->real_escape_string($opt_val['value']);
		$autoload = $_MR['db']->real_escape_string($opt_val['autoload']);
		$query[] = "INSERT INTO options (option_name, option_value, option_autoload) VALUES ('$opt_key', '$value', $autoload)";
	}
		
	// update option
	$update_cache = $_MR['options_update_cache'];
	/* query dimasukkan kedalam array agar dapat melakukan multi_query
	 * val dari query diberi ' untuk type text, varchar
	 */
	foreach ($update_cache as $opt_key => $opt_val) {
		$value = $_MR['db']->real_escape_string($opt_val['value']);
		$autoload = $_MR['db']->real_escape_string($opt_val['autoload']);
		$query[] = "UPDATE options SET option_value='$value', option_autoload='$autoload' WHERE option_name='$opt_key'";
	}
	
	// delete option
	$delete_cache = $_MR['options_delete_cache'];
	/* query dimasukkan kedalam array agar dapat melakukan multi_query
	 * val dari query diberi ' untuk type text, varchar
	 */
	foreach ($delete_cache as $opt_key => $opt_val) {
		$value = $_MR['db']->real_escape_string($opt_val['value']);
		$autoload = $_MR['db']->real_escape_string($opt_val['autoload']);
		$query[] = "DELETE FROM options WHERE option_name='$opt_key'";
	}
	
	if ($query) {
		// query digabungkan kedalam sebuat variable dengan pemisah ';'
		$query = implode(';', $query);

		// execute multi query
		$multi_query = $_MR['db']->multi_query($query);
	}	
}

/**
 * Method untuk memasukkan options kedalam array $_MR['options'] dan $_MR['options_insert_cache']
 * 
 * @author Irianto Bunga Pratama<me@iriantobunga.com>
 * @since Version 1.0
 * 
 * @param String $opt_name 
 * @param String $opt_value
 * @param Integer optional $opt_autoload default 1
 * 
 * @return void
 */
function insert_option($opt_name, $opt_value, $opt_autoload=1) {
	global $_MR; 
	
	/* memasukkan opt_name sebagai key dan opt_value sebagai val pada _MR[options]
	 */
	$_MR['options'][$opt_name] = $opt_value;
	
	// mengecek $opt_value apakah array atau jika iya maka diserialize terlebih dahulu
	if (is_array($opt_value) || is_object($opt_value)) {
		$opt_value = serialize($opt_value);
	}
	
	/*  memasukkan opt_name sebagai key dan array sebagai val pada _MR[options_insert_cache]
	 */
	$_MR['options_insert_cache'][$opt_name] = array(
												'value' => $opt_value,
												'autoload' => $opt_autoload
											  );
}

