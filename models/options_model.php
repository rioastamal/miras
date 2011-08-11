<?php

/**
 * File ini berisi query yg berhubungan dengan plugin
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
