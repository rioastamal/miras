<?php

/**
 * Ini adalah file untuk melakukan test insert pada model komentar
 * komentar.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_komentar.php misal:
 *    http://localhost/berita21/test/insert_komentar.php
 *
 * @author Irianto Bunga <me@iriantobunga.com>
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model komentar, tidak perlu menyebutkan nama file lengkap
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
		echo ("Live is adventure, try again<br/>");
	} else {
		echo ("Yes......!<br/>");
	}
}

$kmt = get_last_commented_article();
$art = get_latest_article(100);
?>

<form action="insert_komentar.php" method="post">
	<label>Judul Artikel</select><br/>
	<select name="id_art">
		<?php foreach ($art as $a) : ?>
			<option value="<?php echo ($a->artikel_id);?>"><?php echo ($a->artikel_judul);?></option>
		<?php endforeach; ?>	
	</select><br/>
	<label>Nama </label><br/>
	<input type="text" name="nama_kmt" value="" size="15" /><br/>
	<label>Email</label><br/>
	<input type="text" name="email_kmt" value="" size="15" /><br/>
	<label>Komentar</label><br/>
	<textarea type="text" name="isi_kmt" value="" size="100" ></textarea><br/>
	<label>tgl</label><br/>
	<input type="text" name="tgl_kmt" value="" size="15" /><br/>
	<input type="submit" name="submit_komentar" value="SIMPAN" />
</form>

<h3>Daftar Komentar</h3>
<ul>
<?php foreach ($kmt as $k) : ?>
	<li><?php echo ($k->artikel_judul);?></li>
	<ul>
		<li><?php echo ($k->komentar_nama);?></li>
		<li><?php echo ($k->komentar_email);?></li>
		<li><?php echo ($k->komentar_isi);?></li>
		<li><?php echo ($k->komentar_tgl);?></li>
	</ul>
<?php endforeach; ?>
</ul>
