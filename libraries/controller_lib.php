<?php
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan controller
 * 
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk melakukan routing dari URL ke sebuah file controller
 *
 * <code>
 * // jika ada sebuah URL seperti berikut:
 * //  http://localhost/berita21/index.php/foo-bar
 * $controller = map_controller();
 *
 * // maka nila dari controller (asumsi lokasi root direktori webserver adalah /opt/lampp/htdocs)
 * // adalah /opt/lampp/htdocs/controllers/foo_bar_ctl.php
 * // sehingga file contrroler dapat di include dengan peritnah
 * include_once( $controller );
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return string lokasi dari file controller
 * @throws Exception
 */
function map_controller() {
	global $_MR;
	
	$file = '';
	$index = $_MR['index_page'];
	$controller = $_MR['default_controller'];
	$uri = $_SERVER['REQUEST_URI'];
	
	// fix slash ganda // dengan single / jika memang terjadi
	$uri = preg_replace('@//+@', '/', $uri);
	
	// split $index dari the uri 
	$split = explode($index, $uri);		
	site_debug( print_r($split, TRUE), 'URI INDEX' );
	
	// get the controller
	if (@$split[1]) {
		// cek apakah potongan URI setelah index.php cocok dengan REGEX
		// seperti dibawah ini
		if (preg_match('@/([a-zA-Z0-9\-_]+)/?([a-zA-Z0-9\-_]+)?(.*)@', $split[1], $matches)) {
			site_debug( print_r($matches, TRUE), 'CONTROLLER MATCHING' );
			$controller = $matches[1];
			
			// split $matches[3] dari /
			$arguments = preg_split('@/@', $matches[3], -1, PREG_SPLIT_NO_EMPTY);
			$_MR['controller_arguments'] = $arguments;
		}
	}
	
	// semua controller harus diconvert ke underscore karena konvensi nama file
	// controller diharuskan seperti itu (sesuai dengan coding guide awal)
	$controller = str_replace('-', '_', $controller);
	
	// cek apakah controller sama dengan nama direktori di plugin
	if (is_dir(BASE_PATH . '/plugins/' . $controller)) {
		site_debug($controller, 'CONTROLLER PLUGIN');

		// nama controller adalah nama plugin tersebut
		$plugin_name = $controller;
		
		// ubah hypen(-) ke underscore jika memang terdapat simbol tersebut
		$controller = str_replace('-', '_', $matches[2]);
		
		// cek apakah controller masih berupa direktori?
		// WTF! you make me tired 
		if (is_dir(BASE_PATH . '/plugins/' . $plugin_name . '/controllers/' . $controller) && $controller != '') {
			// controller merupakan direktori jadi tambahkan dengan variabel
			// $matches yang ber-index 2
			site_debug($controller, 'CONTROLLER PLUGIN DIRECTORY');

			// karena $matches hanya dibaasi sampai element ke 2, sedangkan
			// controller sebenarnya jika didalam controller plugin ada direktori
			// maka ambil dari URL contoller argument pertama
			$real_controller = get_argument(0);
			
			// hilangkan element pertama dari array controller argument
			array_shift($_MR['controller_arguments']);
			
			// ubah hypen(-) ke underscore jika memang terdapat simbol tersebut
			$real_controller = str_replace('-', '_', $real_controller);
			
			if ($real_controller == '') {
				$real_controller = $_MR['default_controller'];
			}
			
			$controller = $controller . '/' . $real_controller;
		}
		
		// map controller ke file
		// jika controller tidak disebutkan asumsikan default_controller
		if ($controller == '') {
			$controller = $_MR['default_controller'];
		}
		
		$file = BASE_PATH . '/plugins/' . $plugin_name . '/controllers/' . $controller . '_ctl.php';
		
	} else {
		// nama direktori atau controller tidak ditemukan dalam direktori plugins/
		// cek apakah controller merupakan direktori atau tidak
		// cek pada base path normal
		if (is_dir(BASE_PATH . '/controllers/' . $controller)) {
			// controller merupakan direktori jadi tambahkan dengan variabel
			// $matches yang ber-index 2
			site_debug($controller, 'CONTROLLER DIRECTORY');

			// ubah hypen(-) ke underscore jika memang terdapat simbol tersebut
			$real_controller = str_replace('-', '_', $matches[2]);
			if ($real_controller == '') {
				$real_controller = $_MR['default_controller'];
			}
			
			$controller = $controller . '/' . $real_controller;
		}
		
		// map controller ke file yang bersangkutan
		$file = BASE_PATH . '/controllers/' . $controller . '_ctl.php';
	}
	site_debug($file, 'FULL CONTROLLER PATH');
	site_debug( print_r($_MR['controller_arguments'], TRUE), 'CONTROLLER ARGUMENT' );
	
	// file exists?
	if (file_exists($file)) {
		return $file;
	}
	
	// jika sampai disini maka controller tidak ditemukan jadi thrown exception
	throw new Exception ("Controller {$controller} tidak ditemukan.");
}

/**
 * Funcgis untuk mendapatkan argument yang dipassing ke halaman controller
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param integer $index => index array argument yang dicari
 * @return mixed|boolean
 */
function get_argument($index=0) {
	global $_MR;
	
	// cek apakah index tersebut ada pada array controller argument atau tidak
	if (array_key_exists($index, $_MR['controller_arguments'])) {
		// index ada berarti diasumsikan juga ada nilainya
		// maka kembalikan array dengan index yang diminta
		return $_MR['controller_arguments'][$index];
	}
	
	// jika sampai disini berarti index array tidak ada
	return FALSE;
}
