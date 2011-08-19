
		<!-- BEGIN CONTENT -->
		<div id="content">
		<?php echo (get_flash_message()); ?>	
		<h1>Ganti Deskripsi Website</h1>
		<form class="miras" action="<?php echo (get_site_url());?>/tugu-pahlawan/ganti-deskripsi/action/save-description" method="post">
			<label class="label">Deskripsi</label>
			<input class="text" type="text" name="deskripsi" value="<?php echo ($data->sess->desc);?>" id="deksripsi" style="width:96%" />
			<br/>
			<input class="button" type="submit" value="SIMPAN" name="desc-submit" id="desc-submit" />
		</form>
		</div>
		<!-- END CONTENT -->
