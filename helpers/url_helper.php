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
	if (in_array($key, $_MR['controller_arguments'])) {
		$index_arg = array_search($key, $_MR['controller_arguments']);
		if ($index_arg == 0) {
			$index_arg += 1;
			//print_r($_MR['controller_arguments'][$index_arg]);
			return $_MR['controller_arguments'][$index_arg];
		} elseif ($index_arg % 2 == 0) {
			$index_arg += 1;
			//print_r($_MR['controller_arguments'][$index_arg]);
			return $_MR['controller_arguments'][$index_arg];
		} elseif (array_key_exists($index_arg, $_MR['controller_arguments'])) {
			return $_MR['controller_arguments'][$index_arg];
		} else {
			return FALSE;
		}
		
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
