<?php

/**
 * Ini adalah file untuk melakukan test view/
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/test_view_kategori.php
 *
 * @author Rio Astamal <me@rioastamal.net>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

set_page_title('Test Kategori View');

// load model kategori
load_model('kategori');

// masukan kategori ke dalam variabel $data_view, sehingga
$data_view['daftar_kategori'] = get_all_kategori(FALSE);

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_kategori', $data_view);
load_view('sidebar');
load_view('footer');
