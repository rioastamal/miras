
		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Site Settings</h1>
			<form class="miras" action="post">
				<label class="label">Title</label>
				<input class="text" type="text" name="site_title" value="<?php echo (@$data->sess->title);?>" id="site_title" />
				<label class="label">Title</label>
				<input class="text" type="text" name="site_desc" value="<?php echo (@$data->sess->desc);?>" id="site_desc" size="32" />
			</form>
		</div>
