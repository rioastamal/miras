<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan untuk melakukan routing
 * dari URL ke sebuah file controller, page argument dan lain-lain.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
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
 * @changelog
 *   => 2011-08-24 Dalam melakukan pemecahan URI fungsi yang digunakan diganti 
                   dari preg_match ke preg_split
     => 2011-08-27 Menambahkan pengecekan nama controller apakah berakhiran 
                   '_backend' atau atau tidak
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
	$parts = array();
	
	// fix slash ganda // dengan single / jika memang terjadi
	$uri = preg_replace('@//+@', '/', $uri);
	
	// split $index dari the uri 
	$split = explode($index, $uri);		
	site_debug( print_r($split, TRUE), 'URI INDEX' );
	
	// get the controller
	if (@$split[1]) {
		// Split elemen setelah _MR['index_page'] 
		$parts = preg_split('@/@', $split[1], -1, PREG_SPLIT_NO_EMPTY);
		site_debug(print_r($parts, TRUE), '#PARTS');
		
		// controller adalah element dengan index pertama [ NOL ]
		if (count($parts) > 0) {
			$controller = $parts[0];
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
		
		// nama controllernya adalah index berikutnya
		if (isset($parts[1])) {
			// ubah hypen(-) ke underscore jika memang terdapat simbol tersebut
			$controller = str_replace('-', '_', $parts[1]);
		} else {
			$controller = '';
		}
		
		// cek apakah controller masih berupa direktori?
		// WTF! you make me tired 
		if (is_dir(BASE_PATH . '/plugins/' . $plugin_name . '/controllers/' . $controller)) {
			// controller merupakan direktori jadi tambahkan dengan variabel
			// $matches yang ber-index 2
			site_debug($controller, 'CONTROLLER PLUGIN DIRECTORY');

			// controller sebenarnya berarti ada di index 2
			if (isset($parts[2])) {
				$real_controller = str_replace('-', '_', $parts[2]);
			} else {
				// nama controller tidak diberikan jadi gunakan 
				// default controller
				$real_controller = $_MR['default_controller'];
			}

			// cek apakah ada argument yang diberikan pada controller tersebut
			if (isset($parts[3])) {
				$_MR['controller_arguments'] = array_slice($parts, 3);
			}
			
			// set backend status
			if (strpos($real_controller, '_backend') !== FALSE) {
				set_backend_status(TRUE);
			}
			
			$controller = $controller . '/' . $real_controller;
		} else {
			
			// map controller ke file
			// jika controller tidak disebutkan asumsikan default_controller
			if ($controller == '') {
				$controller = $_MR['default_controller'];
			}
			
			// set backend status
			if (strpos($controller, '_backend') !== FALSE) {
				set_backend_status(TRUE);
			}
			
			// karena bukan direktori berari index dimulai dari 2
			if (isset($parts[2])) {
				$_MR['controller_arguments'] = array_slice($parts, 2);
			}
		}
		
		$file = BASE_PATH . '/plugins/' . $plugin_name . '/controllers/' . $controller . '_ctl.php';
		
	} else {
		// nama direktori atau controller tidak ditemukan dalam direktori plugins/
		// cek apakah controller merupakan direktori atau tidak
		// cek pada base path normal
		if (is_dir(BASE_PATH . '/controllers/' . $controller)) {
			// controller merupakan direktori jadi tambahkan dengan variabel
			// $matches yang ber-index 1
			site_debug($controller, 'CONTROLLER DIRECTORY');

			// cek isi dari parts ke-1 kosong atau tidak
			if (isset($parts[1])) {
				$real_controller = $parts[1];
				$real_controller = str_replace('-', '_', $real_controller);
			} else {
				// isikan dengan default controller
				$real_controller = $_MR['default_controller'];
			}
			
			// set backend status
			if (strpos($real_controller, '_backend') !== FALSE) {
				set_backend_status(TRUE);
			}
			
			$_MR['controller_arguments'] = array_slice($parts, 2);
			
			$controller = $controller . '/' . $real_controller;
		} else {
			// arguments seharusnya dimulai dari index ke 1 jika bukan merupakan
			// sebuah direktori
			if (isset($parts[1])) {
				$_MR['controller_arguments'] = array_slice($parts, 1);
			}
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
	header("HTTP/1.1 404 Not Found");
	throw new Exception ("Controller {$controller} tidak ditemukan.");
}

/**
 * Fungsi untuk mendapatkan argument yang dipassing ke halaman controller
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

/**
 * Fungsi untuk menset controller ke status backend atau tidak
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param boolean $status Status yang diberikan berupa TRUE atau FALSE
 * @return void
 */
function set_backend_status($status) {
	global $_MR;
	
	if (!is_bool($status)) {
		throw Exception('Nilai parameter dari set_backend_status harus bertipe boolean.');
	}
	$_MR['is_backend_controller'] = $status;
}

/**
 * Fungsi untuk mendapatkan status dari suatu controller, apakah dia
 * berupa backend atau tidak
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return boolean
 */
function get_backend_status() {
	global $_MR;
	
	return $_MR['is_backend_controller'];
}
