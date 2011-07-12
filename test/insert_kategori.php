<?php

/**
 * Ini adalah file untuk melakukan test insert pada model kategori
 * kategori.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/insert_kategori.php
 *
 * @author Rio Astamal <me@rioastamal.net>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model kategori, tidak perlu menyebutkan nama file lengkap
load_model('kategori');

// jika variabel $_POST['submit_kategori'] diset maka ini adalah proses submit
// (user mengklik tombol SIMPAN
if (isset($_POST['submit_kategori'])) {
	$new_kat = new stdClass();
	$new_kat->kategori_nama = trim( $_POST['nama_kat'] );	// hilangkan spasi awal dan akhir
	
	// mulai masukkan ke database
	// hasil dari fungsi insert_kategori() selalu boolean jadi dapat dicocokkan dengan if
	if (!insert_kategori($new_kat)) {
		echo ("JANCOK onok opo gak iso nyimpen<br/>");
	} else {
		echo ("Oh yeah I'm the man!<br/>");
	}
}

$kat = get_all_kategori(); ?>	

<form action="insert_kategori.php" method="post">
	<label>Nama Kategori</label><br/>
	<input type="text" name="nama_kat" value="" size="15" /><br/>
	<input type="submit" name="submit_kategori" value="SIMPAN" />
</form>

<h3>Daftar Kategori</h3>
<ul>
<?php foreach ($kat as $k) : ?>
	<li><?php echo ($k->kategori_nama);?></li>
<?php endforeach; ?>
</ul>
