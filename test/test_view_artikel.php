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

// karena BASE_PATH dipindah ke index maka create konstanta BASE_PATH secara manual
define('BASE_PATH', dirname( $current_path . '/../..'));
include_once (BASE_PATH . '/libs/boot_strap.php');

set_page_title('Test Artikel View');

// load model artikel
load_model('artikel');

// load model kategori
load_model('kategori');

if (isset($_POST['submit_artikel'])) {
	$judul_art = $_POST['judul_art'];
	$isi_art = $_POST['isi_art'];
	$tgl_art = $_POST['tgl_art'];
	$kategori_id = $_POST['kategori_id'];
	
	$new_art = new stdClass();
	$new_art->artikel_judul = trim( $_POST['judul_art'] );
	$new_art->artikel_isi = trim( $_POST['isi_art'] );	// hilangkan spasi awal dan akhir
	$new_art->artikel_tgl = trim( $_POST['tgl_art'] );
	$new_art->kategori_id = trim( $_POST['kategori_id'] );
	
	// mulai masukkan ke database
	// hasil dari fungsi insert_kategori() selalu boolean jadi dapat dicocokkan dengan if
	if (!insert_artikel($new_art)) {
		set_flash_class('flash-error');
		set_flash_message("Gagal menyimpan artikel '{$judul_art}'.");
	} else {
		set_flash_message("Berhasil menyimpan artikel dengan judul '{$judul_art}'.");
	}
}

// masukan artikel dan daftar kategori ke dalam variabel $data_view, sehingga
$data_view['daftar_artikel'] = get_latest_article(10);
$data_view['daftar_kategori'] = get_all_kategori(FALSE);

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_artikel', $data_view);
load_view('sidebar');
load_view('footer');
