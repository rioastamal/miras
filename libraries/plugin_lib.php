<?php
/**
 * File ini berisi fungsi-fungsi yang berhubungan dengan sistem plugin
 *
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi untuk meload plugin yang ada didirektori plugins
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return void
 */
function load_plugins() {
	global $_B21;
	
	$dirs = scandir(BASE_PATH . '/plugins/');
	// slice (hilangkan) dua element awal yaitu direktori . dan ..
	$dirs = array_slice($dirs, 2);
	
	foreach ($dirs as $plugin) {
		// cek terlebih dahulu file informasi dari plugin ada atau tidak
		// nama file ini harus sesuai format nama_plugin.info
		$json_info = BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.info';
		if (!file_exists($json_info)) {
			// skip...
			$_B21['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'plugin tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah file nama_plugin.php ada atau tidak
		$path_file = BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.php';
		if (!file_exists($path_file)) {
			$_B21['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'file php tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah direktori controllers ada atau tidak
		$path_dir_ctl = BASE_PATH . '/plugins/' . $plugin . '/controllers';
		if (!file_exists($path_dir_ctl)) {
			$_B21['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'controllers tidak ditemukan'
			);
			continue;
		}

		// cek apakah direktori views ada atau tidak		
		$path_dir_view = BASE_PATH . '/plugins/' . $plugin . '/views';
		if (!file_exists($path_dir_view)) {
			$_B21['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'views tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah direktori models ada atau tidak
		$path_dir_model = BASE_PATH . '/plugins/' . $plugin . '/models';
		if (!file_exists($path_dir_model)) {
			$_B21['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'models tidak ditemukan'
			);
			continue;
		}
		
		// informasi plugin berupa format JSON, jadi untuk mengubahnya kedalam
		// bentuk PHP Object digunakan json_encode
		$json_info = json_decode(file_get_contents($json_info));
		
		// masukkan ke dalam daftar plugin yang telah diload
		$_B21['loaded_plugins'][] = $plugin;
		
		// ok, let's include the plugin
		include_once(BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.php');
	}
	
	site_debug(print_r($_B21['error_plugins'], TRUE), 'ERROR PLUGINS');
	site_debug(print_r($_B21['loaded_plugins'], TRUE), 'LOADED PLUGINS');
}

/**
 * Fungsi untuk menambahkan daftar hook
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @return void
 */
function add_hook($hookname, $function_name) {
	global $_B21;
	
	$_B21['hooks'][$hookname][] = $function_name;
}

/**
 * Fungsi untuk menjalankan hooks yang sudah terdaftar 
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @param string $hookname nama hook yang kan dijalankan
 * @param mixed $args parameter yang akan dipassing ke hooks
 *
 * @return void
 */
function run_hooks($hookname, &$args='') {
	global $_B21;
	
	// cek dulu apakah nama hook yang akan dijalankan ada didalam daftar hook
	// atau tidak
	if (array_key_exists($hookname, $_B21['hooks'])) {
		// jika ada maka lakukan looping untuk menjalankan hook tersebut
		// karena kemungkinan satu hook dijalankan oleh banyak plugin (fungsi)
		foreach ($_B21['hooks'][$hookname] as $function_name) {
			// check apakah fungsi sudah didefinisikan atau belum
			if (function_exists($function_name)) {
				call_user_func_array($function_name, array(&$args));
			}
		}
	}
}
