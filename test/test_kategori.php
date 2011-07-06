<?php

/**
 * Ini adalah file untuk melakukan test fungsi-fungsi yang ada pada model
 * kategori.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/test_kategori.php
 * atau, gunakan PHP CLI
 * 2. /path/ke/bin/php /path/ke/lokasi/berita21/test/test_kategori.php
 *
 * @author Rio Astamal <me@rioastamal.net>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model kategori, tidak perlu menyebutkan nama file lengkap
load_model('kategori');

echo ("<pre>\n");

// mari coba meload menggunakan salah satu fungsi pada model kategori.
// code berikut mengambil semua kategori dan jumlah artikel pada tiap kategori tersebut
$kat = get_all_kategori();
print_r($kat);

echo ("\n");

// code berikut hanya mengambil semua kategori tanpa jumlah artikel
$kat_nocount = get_all_kategori(FALSE);
print_r($kat_nocount);

/**
 * Menampilkan kategori dalam bentuk HTML List
 * Author: Rio Astamal <me@rioatamal.net>
 */
$list = "<ul>\n";
foreach ($kat as $k) {
	$list .= '<li>' . $k->kategori_nama . ' (' . $k->jml_artikel . ')' . "\n";
}
$list .= "</ul>\n";
echo ($list); 	// cetak LIST

echo ("</pre>\n");

echo ("irianto ganteng");
