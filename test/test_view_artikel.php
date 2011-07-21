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

// load model artikel
load_model('artikel');

// load model kategori
load_model('kategori');

if (isset($_POST['submit_artikel'])) {
	$new_art = new stdClass();
	$new_art->artikel_judul = trim( $_POST['judul_art'] );
	$new_art->artikel_isi = trim( $_POST['isi_art'] );	// hilangkan spasi awal dan akhir
	$new_art->artikel_tgl = trim( $_POST['tgl_art'] );
	$new_art->kategori_id = trim( $_POST['kategori_id'] );
	
	// mulai masukkan ke database
	// hasil dari fungsi insert_kategori() selalu boolean jadi dapat dicocokkan dengan if
	if (!insert_artikel($new_art)) {
		set_flash_class('flash-error');
		set_flash_message("Gagal menyimpan judul artikel '{$judul_art}'.");
		set_flash_message("Gagal menyimpan isi artikel '{$isi_art}'.");
		set_flash_message("Gagal menyimpan tanggal artikel '{$tgl_art}'.");
		set_flash_message("Gagal menyimpan kategori artikel '{$kategori_id}'.");
	} else {
		echo ("Oh YEAHH..!!! <br/>");
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
