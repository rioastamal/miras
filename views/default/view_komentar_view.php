	<!-- BEGIN CONTENT -->
	<div id="content">
		<h3>Daftar Komentar</h3>
		<ul>
		<?php foreach ($data['daftar_komentar'] as $kmt) : ?>
			<li><?php echo ($kmt->artikel_judul);?></li>
			<ul>
				<li><?php echo ($kmt->komentar_nama);?></li>
				<li><?php echo ($kmt->komentar_email);?></li>
				<li><?php echo ($kmt->komentar_isi);?></li>
				<li><?php echo ($kmt->komentar_tgl);?></li>
			</ul>
		<?php endforeach; ?>
		</ul>
	</div>
	<!-- BEGIN CONTENT -->
