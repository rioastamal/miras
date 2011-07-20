	
	
	<!-- @author : miftah faridl <vcode84@gmail.com -->
	
	<!-- BEGIN CONTENT -->
	<div id="content">
		<h1>Tambah Artikel</h1>
		<form action="" method="post">
			<label>Nama Artikel</label>
			<input type="text" name="nama_kat" value="" id="" /><br/>
			<input type="submit" name="submit-art" value="SIMPAN" />
		</form>
		
		<h3>Daftar Artikel Saat Ini</h3>
		<ul>
		<?php foreach ($data['daftar_artikel'] as $art) : ?>
			<li><?php echo ($kat->kategori_judul);?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<!-- BEGIN CONTENT -->
