
		<!-- BEGIN CONTENT -->
		<div id="content">
		<h1>Tugu Pahlawan Surabaya</h1>
			<p>Berikut ini adalah beberapa contoh controller yang disertakan
			dalam plugin Tugu Pahlawan.</p>
			<ul>
				<?php if ($data->user->role->is_guest): ?>	
				<li><a href="<?php echo ($data->site_url);?>/tugu-pahlawan/login">Login</a></li>
				<?php else: ?>	
				<li><a href="<?php echo ($data->site_url);?>/tugu-pahlawan/login/action/logout">Logout</a></li>
				<li><a href="<?php echo ($data->site_url);?>/tugu-pahlawan/my-profile">My Profile</a></li>
				<?php endif; ?>
				<li><a href="<?php echo ($data->site_url);?>/tugu-pahlawan/secret-document">Dokumen Rahasia</a></li>
				<li><a href="<?php echo ($data->site_url);?>/tugu-pahlawan/bung-tomo">Bung Tomo</a></li>
			</ul>
		</div>
		<!-- END CONTENT -->
