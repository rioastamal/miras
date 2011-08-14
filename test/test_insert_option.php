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

// tes satu plugin aktif
insert_option('aktif0 plugin', 'hello_dolly');

// tes banyak plugin aktif
$plugin_array = array(
					'hello_dolly',
					'no_ie6',
					'secure_url'
				);

insert_option('aktif1 plugin', $plugin_array);
insert_option('aktif2 plugin', $plugin_array);
insert_option('aktif3 plugin', $plugin_array);
insert_option('aktif4 plugin', $plugin_array);
insert_option('aktif5 plugin', $plugin_array);
insert_option('aktif6 plugin', $plugin_array);
insert_option('aktif7 plugin', $plugin_array);

$option = print_r($_MR['options'], TRUE);
site_debug($option, 'Cetak isi MR option');
$option_insert_cache = print_r($_MR['options_insert_cache'], TRUE);
site_debug($option_insert_cache, 'Cetak isi MR option_insert_cache');

// tes option save
if (option_insert_save()===FALSE) {
	echo ('Tidak Tersimpan karena terdapat kesalahan atau kesamaan nama plugin');
} else {
	echo ('Tersimpan');
}

show_debug();
echo ("</pre>\n");
