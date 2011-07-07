<?php

/**
 * Ini adalah file untuk melakukan test fungsi-fungsi yang ada pada model
 * kategori.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/test_artikel.php
 * atau, gunakan PHP CLI
 * 2. /path/ke/bin/php /path/ke/lokasi/berita21/test/test_artikel.php
 *
 * @author Alfa Radito
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model kategori, tidak perlu menyebutkan nama file lengkap
load_model('artikel');

echo ("<pre>\n");

// mari coba meload menggunakan salah satu fungsi pada model kategori.
// code berikut mengambil semua kategori dan jumlah artikel pada tiap kategori tersebut
$art = get_latest_article();
print_r($art);

echo ("\n");

// code berikut hanya mengambil semua kategori tanpa jumlah artikel
// $kat_nocount = get_all_kategori(FALSE);
// print_r($kat_nocount);

/**
 * Menampilkan kategori dalam bentuk HTML List
 * Author: Alfa Radito
 */

$list = "<ul>\n";
foreach ($art as $a) {
	$list .= '<li>' . $a->artikel_judul . ' Tanggal POST : (' . $a->artikel_tgl . ')' . "\n";
}
$list .= "</ul>\n";
echo ($list); 	// cetak LIST

echo ("</pre>\n");

