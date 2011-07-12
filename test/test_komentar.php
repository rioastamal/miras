<?php
/**
 * Ini adalah file untuk melakukan test fungsi-fungsi yang ada pada model
 * komentar.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_komentar.php misal:
 *    http://localhost/berita21/test/test_komentar.php
 * atau, gunakan PHP CLI
 * 2. /path/ke/bin/php /path/ke/lokasi/berita21/test/test_komentar.php
 *
 * @author Irianto Bunga <me@iriantobunga.com>
 */
 
// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model komentar, tidak perlu menyebutkan nama file lengkap
load_model('komentar');

echo ("<pre>\n");

// mari coba meload menggunakan salah satu fungsi pada model komentar.
// code berikut mengambil 5 komentar terakhir pada artikel
$kat = get_last_commented_article();
print_r($kat);

$jml_kom = get_most_commented_article();
print_r($jml_kom);

echo ("\n");
echo ("</pre>\n");

?>
