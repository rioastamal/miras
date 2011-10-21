<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi untuk meload URL dari javascript atau CSS
 *
 * @package Miras
 * @subpackage Helpers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi untuk meload javascript. Contoh:
 *
 * <code>
 *  // contoh 1
 *  mr_add_js('jquery', '1.3.2');
 *  
 *  // akan menambahkan URL berikut pada daftar javascript yang akan diload
 *  // asumsi theme default dan berada di frontend
 *  // http://example.com/views/default/jquery-1.3.2.js
 *
 *  // contoh 2
 *  mr_add_js('mootools', '1.0', 'http://cdn.example.com/js/');
 *  // hasilnya adalah
 *  // http://cdn.example.com/js/mootools-1.0.js
 *
 *  // contoh 3
 *  mr_add_js('prototype', '', 'http://cdn.example.com/js/');
 *  // hasilnya adalah
 *  // http://cdn.example.com/js/prototype.js
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.3
 *
 * @param string $js_name - Nama javascript yang akan diload
 * @param string $js_version - Versi dari file javascript yang akan diload
 * @param string $js_url - Optional, URL dari script JS (dengan akhir slash '/')
 */
function mr_add_js($js_name, $js_version, $js_url='') {
	global $_MR;
	
	$js_location = '';
	$separator = '-';
	$theme_url = get_theme_url();
	
	$js_name = trim($js_name);
	$js_version = trim($js_version);
	
	// hilangan separator jika tidak ada versi
	if ($js_version == '') {
		$separator = '';
	}
	
	// jika js_url tidak disertakan maka asumsikan meload dari lokasi views
	// default
	if ($js_url == FALSE) {
		// cek apakah ini merupakan backend atau tidak
		if (get_backend_status()) {
			$theme_url = $theme_url . 'backend';
		}
		
		// gabungkan dengan URL theme
		$js_file = $js_name . $separator . $js_version . '.js';
		$js_location = $theme_url . '/' . $js_file;
	} else {
		$js_file = $js_name . $separator . $js_version . '.js';
		$js_location = $js_url . $js_file;
	}
	
	$_MR['loaded_javascripts'][$js_file] = $js_location ;
}
