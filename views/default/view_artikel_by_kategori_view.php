<?php foreach($data['daftar_artikel'] as $kat) :?>
<h3>Daftar Artikel Saat Ini Dengan Kategori = <?php echo ($kat->kategori_nama) ;?></h3>
		<ul>
			<li><?php echo ($kat->artikel_id);?></li>
			<li><?php echo ($kat->artikel_judul);?></li>
			<li><?php echo ($kat->artikel_isi);?></li>
			<li><?php echo ($kat->artikel_tgl);?></li>
<?php endforeach;?>
		</ul>
