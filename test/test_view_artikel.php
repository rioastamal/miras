<?php

/**
 * Ini adalah file untuk melakukan test view/
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/test_view_artikel.php
 *
 * @author Alfa Radito
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

set_page_title('Test Artikel View');

// load model kategori
load_model('artikel');

// masukan artikel ke dalam variabel $data_view, sehingga
$data_view['daftar_artikel'] = get_latest_article(10);

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_artikel', $data_view);
load_view('sidebar');
load_view('footer');
