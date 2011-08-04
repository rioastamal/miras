
	<!-- BEGIN CONTENT -->
	<div id="content">
		<h1>Tambah Kategori</h1>
		
		<?php echo (get_flash_message());?>
		
		<form action="<?php echo (get_site_url());?>/add-kategori" method="post" class="mr">
			<label>Nama Kategori</label>
			<input class="text" type="text" name="nama_kat" value="" id="" /><br/>
			<input class="button" type="submit" name="submit-kat" value="SIMPAN" />
		</form>
		
		<h3>Daftar Kategori Saat Ini</h3>
		<ul>
		<?php foreach ($data['daftar_kategori'] as $kat) : ?>
			<li><?php echo ($kat->kategori_nama);?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<!-- BEGIN CONTENT -->
	
	
