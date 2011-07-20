<?php

/**
 * Ini adalah file untuk melakukan test view/
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_view_komentar.php misal:
 *    http://localhost/berita21/test/test_view_komentar.php
 *
 * @author Irianto Bunga <me@iriantobunga.com>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

set_page_title('Test Komentar View');

// load model komentar
load_model('komentar');
load_model('artikel');

// masukan komentar ke dalam variabel $data_view, sehingga
$data_view['daftar_komentar'] = get_last_commented_article();
$data_view['daftar_artikel'] = get_latest_article(100);

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_komentar', $data_view);
load_view('sidebar');
load_view('footer');
