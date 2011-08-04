	
	<!-- @author : miftah faridl <vcode84@gmail.com -->
	
	<!-- BEGIN CONTENT -->
	<div id="content">
		<h1>Tambah Artikel</h1>
		<?php echo (get_flash_message());?>
		
		<form action="<?php echo (get_site_url());?>/add-artikel" method="post" class="mr">
			<label>Judul Artikel</label><br/>
			<input type="text" class="text" name="judul_art" value="" id="" size="15" /><br/>
			
			<label>Isi Artikel</label><br/>
			<textarea name="isi_art"></textarea><br/>
			
			<label>Tanggal Artikel</label><br/>
			<input type="text" class="text" name="tgl_art" value="" size="15" id="" /> <span>pake format YYYY-MM-DD</span><br/>
			
			<select name="kategori_id">
				<?php foreach ($data['daftar_kategori'] as $kat) : ?>
				<option value="<?php echo ($kat->kategori_id);?>"><?php echo ($kat->kategori_nama);?></option>
				<?php endforeach; ?>
			</select><br/>
			<input class="button" type="submit" name="submit_artikel" value="SIMPAN" />
		</form>
		
		<h3>Daftar Artikel Saat Ini</h3>
		<ul>
		<?php foreach ($data['daftar_artikel'] as $art) : ?>
			<li><?php echo ($art->artikel_judul);?></li>
			<li><?php echo ($art->artikel_isi);?></li>
			<li><?php echo ($art->artikel_tgl);?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<!-- BEGIN CONTENT -->
