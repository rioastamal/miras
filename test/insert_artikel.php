<?php

/**
 * Ini adalah file untuk melakukan test insert pada model kategori
 * kategori.
 *
 * Penggunaan:
 * 1. Arahkan browser ke lokasi file test_kategori.php misal:
 *    http://localhost/berita21/test/insert_kategori.php
 *
 * @author Alfa Radito 
 */

// include boot strap file untuk meload semua library yang dibutuhkan
$current_path = dirname(__FILE__);
include_once ($current_path . '/../libs/boot_strap.php');

// load model kategori, tidak perlu menyebutkan nama file lengkap
load_model('artikel');
load_model('kategori');

// jika variabel $_POST['submit_kategori'] diset maka ini adalah proses submit
// (user mengklik tombol SIMPAN
if (isset($_POST['submit_artikel'])) {
	$new_art = new stdClass();
	$new_art->artikel_judul = trim( $_POST['judul_art'] );
	$new_art->artikel_isi = trim( $_POST['isi_art'] );	// hilangkan spasi awal dan akhir
	$new_art->artikel_tgl = trim( $_POST['tgl_art'] );
	$new_art->kategori_id = trim( $_POST['kategori_id'] );
	
	// mulai masukkan ke database
	// hasil dari fungsi insert_kategori() selalu boolean jadi dapat dicocokkan dengan if
	if (!insert_artikel($new_art)) {
		echo ("JANCOK onok opo gak iso nyimpen<br/>");
	} else {
		echo ("Oh! masuk mas <br/>");
	}
}

$get_kat = get_all_kategori();
$get_art = get_latest_article(); ?>	

<form action="insert_artikel.php" method="post">
	<label>Judul Artikel</label><br/>
	<input type="text" name="judul_art" value="" size="15" /><br/>
	<label>Isi Artikel</label><br/>
	<textarea name="isi_art"></textarea><br/>
	<label>Tanggal Artikel</label><br/>
	<input type="text" name="tgl_art" value="" size="15" /> <span>pake format YYYY-MM-DD</span><br/>
	<select name="kategori_id">
		<?php foreach ($get_kat as $k) : ?>
			<option value="<?php echo ($k->kategori_id);?>"><?php echo ($k->kategori_nama);?></option>
		<?php endforeach; ?>
	</select><br/>
	<input type="submit" name="submit_artikel" value="SIMPAN" />
</form>

<h3>Isi Artikel</h3>
<ul>
<?php foreach ($get_art as $g) : ?>
	<li><?php echo ("Judul Artikel : " . $g->artikel_judul);?></li>
	<li><?php echo ("Isi Artikel : " .$g->artikel_isi);?></li>
	<li><?php echo ("Tanggal Artikel : " .$g->artikel_tgl);?></li>
<?php endforeach; ?>
</ul>
