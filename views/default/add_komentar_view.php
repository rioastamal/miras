
	<!-- BEGIN CONTENT -->
	<div id="content">
		<h1>Tambah Komentar</h1>
		<form action="" method="post">
			<select name="id_art">
		<?php foreach ($data['daftar_artikel'] as $art) : ?>
			<option value="<?php echo ($art->artikel_id);?>"><?php echo ($art->artikel_judul);?></option>
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
