<?php

/**
 * Fungsi untuk mendapatkan argumen berdasarkan $key.
 *
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 *
 */
function get_argument_by($key) {
	global $_MR;
	// cek apakah variabel key ada pada array $_MR['controller_arguments']
	if (in_array($key, $_MR['controller_arguments'])) {
		// cek berapa nilai index key
		$index_arg = array_search($key, $_MR['controller_arguments']);
		if ($index_arg == 0) {
			$index_arg += 1;
			// cek apakah index ada
			if (array_key_exists($index_arg, $_MR['controller_arguments'])) {
				return $_MR['controller_arguments'][$index_arg];
			} 
		} 
		// cek apakah index merupakan bilangan genap atau ganjil
		if ($index_arg % 2 == 0) {
			$index_arg += 1;
			return $_MR['controller_arguments'][$index_arg];
		} 
		
		return FALSE;
		
	}
	
}

/**
 * Fungsi untuk meload url yang sedang diakses.
 *
 *
 * @author Alfa Radito 
 * @since Version 1.0
 *
 *
 */

function get_current_url() {
	
	 if(!isset($_SERVER["HTTPS"])) {
		 $_SERVER["HTTPS"] = "";
	 }
	
	 $cur_url = 'http';
	 if ($_SERVER["HTTPS"] == "on") {
		 $cur_url .= "s";
	 }
	 $cur_url .= "://";
	 $cur_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 return $cur_url;

}
