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
// karena BASE_PATH dipindah ke index maka create konstanta BASE_PATH secara manual
define('BASE_PATH', dirname( $current_path . '/../..'));
include_once (BASE_PATH . '/libs/boot_strap.php');

set_page_title('Test Komentar View');

// load model komentar
load_model('komentar');
load_model('artikel');

// jika variabel $_POST['submit_komentar'] diset maka ini adalah proses submit
// (user mengklik tombol SIMPAN
if (isset($_POST['submit_komentar'])) {
	$new_kmt = new stdClass();
	$new_kmt->komentar_nama = trim( $_POST['nama_kmt'] );	// hilangkan spasi awal dan akhir
	$new_kmt->komentar_email = trim( $_POST['email_kmt'] );
	$new_kmt->komentar_isi= trim( $_POST['isi_kmt'] );
	$new_kmt->komentar_tgl = trim( $_POST['tgl_kmt'] );
	$new_kmt->artikel_id = trim( $_POST['id_art'] );
	
	// mulai masukkan ke database
	// hasil dari fungsi insert_komentar() selalu boolean jadi dapat dicocokkan dengan if
	if (!insert_komentar($new_kmt)) {
		set_flash_class('flash-error');
		set_flash_message("Gagal menyimpan komentar");
	} else {
		set_flash_message("Komentar berhasil disimpan.");
	}
}	

// masukan komentar ke dalam variabel $data_view, sehingga
$data_view['daftar_komentar'] = get_last_commented_article();
$data_view['daftar_artikel'] = get_latest_article(100);

// Load view dengan urutan 1. header 2. content utama 3. sidebar 4. footer
load_view('header');
load_view('add_komentar', $data_view);
load_view('sidebar');
load_view('footer');
