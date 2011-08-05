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
	global $_MR;
	
	$dirs = scandir(BASE_PATH . '/plugins/');
	// slice (hilangkan) dua element awal yaitu direktori . dan ..
	$dirs = array_slice($dirs, 2);
	
	foreach ($dirs as $plugin) {
		// cek terlebih dahulu file informasi dari plugin ada atau tidak
		// nama file ini harus sesuai format nama_plugin.info
		$json_info = BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.info';
		if (!file_exists($json_info)) {
			// skip...
			$_MR['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'plugin tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah file nama_plugin.php ada atau tidak
		$path_file = BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.php';
		if (!file_exists($path_file)) {
			$_MR['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'file php tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah direktori controllers ada atau tidak
		$path_dir_ctl = BASE_PATH . '/plugins/' . $plugin . '/controllers';
		if (!file_exists($path_dir_ctl)) {
			$_MR['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'controllers tidak ditemukan'
			);
			continue;
		}

		// cek apakah direktori views ada atau tidak		
		$path_dir_view = BASE_PATH . '/plugins/' . $plugin . '/views';
		if (!file_exists($path_dir_view)) {
			$_MR['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'views tidak ditemukan'
			);
			continue;
		}
		
		// cek apakah direktori models ada atau tidak
		$path_dir_model = BASE_PATH . '/plugins/' . $plugin . '/models';
		if (!file_exists($path_dir_model)) {
			$_MR['error_plugins'][] = array(
				'nama plugin' => $plugin,
				'error message' => 'models tidak ditemukan'
			);
			continue;
		}
		
		// ok, let's include the plugin
		include_once(BASE_PATH . '/plugins/' . $plugin . '/' . $plugin . '.php');
		
		// logika untuk mengecek apakah plugin telah membuat beberapa fungsi
		// yang diperlukan seperti:
		// - nama_plugin_on_install()
		// - nama_plugin_on_uninstall()
		// - nama_plugin_on_activate()
		// - nama_plugin_on_deactivate()
		// - nama_plugin_on_upgrade()
		$needed_function = array($plugin . '_on_install',
								 $plugin . '_on_uninstall',
								 $plugin . '_on_activate',
								 $plugin . '_on_deactivate',
								 $plugin . '_on_upgrade');
		foreach ($needed_function as $nf) {
			if (!function_exists($nf)) {
				site_debug('Fungsi ' . $nf . ' : Plugin ' . $plugin, 'FUNCTION NOT EXISTS');
				throw new Exception('Nama function ' . $nf . ' tidak ditemukan pada plugin ' . $plugin); 
			}
		}
		
		// informasi plugin berupa format JSON, jadi untuk mengubahnya kedalam
		// bentuk PHP Object digunakan json_encode
		$json_info = json_decode(file_get_contents($json_info));
		
		// masukkan ke dalam daftar plugin yang telah diload
		$_MR['loaded_plugins'][] = $plugin;
		
	}
	
	site_debug(print_r($_MR['error_plugins'], TRUE), 'ERROR PLUGINS');
	site_debug(print_r($_MR['loaded_plugins'], TRUE), 'LOADED PLUGINS');
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
	global $_MR;
	
	$_MR['hooks'][$hookname][] = $function_name;
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
	global $_MR;
	
	// cek dulu apakah nama hook yang akan dijalankan ada didalam daftar hook
	// atau tidak
	if (array_key_exists($hookname, $_MR['hooks'])) {
		// jika ada maka lakukan looping untuk menjalankan hook tersebut
		// karena kemungkinan satu hook dijalankan oleh banyak plugin (fungsi)
		foreach ($_MR['hooks'][$hookname] as $function_name) {
			// check apakah fungsi sudah didefinisikan atau belum
			if (function_exists($function_name)) {
				call_user_func_array($function_name, array(&$args));
			}
		}
	}
}
