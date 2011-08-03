<?php foreach ($data['daftar_artikel'] as $arti) : ?>
<h3>Daftar Artikel Saat Ini Dengan ID = <?php echo ($arti->artikel_id) ;?></h3>
<?php endforeach;?>
		<ul>
		<?php foreach ($data['daftar_artikel'] as $art) : ?>
			<li><?php echo ($art->artikel_id);?></li>
			<li><?php echo ($art->artikel_judul);?></li>
			<li><?php echo ($art->artikel_isi);?></li>
			<li><?php echo ($art->artikel_tgl);?></li>
		<?php endforeach; ?>
		</ul>
