<?php
/**
 * Ini adalah file untuk melakukan test fungsi-fungsi yang ada pada model
 * option.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_option.php misal:
 *    http://localhost/berita21/test/test_option.php
 * atau, gunakan PHP CLI
 * 2. /path/ke/bin/php /path/ke/lokasi/berita21/test/test_option.php
 *
 * @author Irianto Bunga Pratama <me@iriantobunga.com>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
// karena BASE_PATH dipindah ke index maka create konstanta BASE_PATH secara manual
define('BASE_PATH', dirname( $current_path . '/../..'));
include_once (BASE_PATH . '/mr/boot_strap.php');

// load model options, tidak perlu menyebutkan nama file lengkap
load_model('options');

echo ("<pre>\n");
set_all_options();

// tes satu plugin aktif
insert_option('aktif plugin', array('hello_dolly'));

// tes banyak plugin aktif
$plugin_array = array(
					'hello_dolly',
					'no_ie6'
				);

insert_option('aktif plugin', $plugin_array);

option_cache_save();
$option = print_r($_MR['options'], TRUE);
site_debug($option, 'Cetak isi MR option');
$option_insert_cache = print_r($_MR['options_insert_cache'], TRUE);
site_debug($option_insert_cache, 'Cetak isi MR option_insert_cache');
$option_update_cache = print_r($_MR['options_update_cache'], TRUE);
site_debug($option_update_cache, 'Cetak isi MR option_update_cache');


show_debug();
echo ("</pre>\n");
