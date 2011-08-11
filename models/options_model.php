<?php

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
	
	// cek apakah option yang dimaksud ada dalam daftar cache yan
}
