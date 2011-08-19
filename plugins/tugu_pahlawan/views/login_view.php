
		<!-- BEGIN CONTENT -->
		<div id="content">
		<?php echo (get_flash_message()); ?>	
		<h1>Login</h1>
		<form class="miras" action="<?php echo (get_site_url());?>/tugu-pahlawan/login/action/proses-login" method="post">
			<label class="label">Username</label>
			<input class="text" type="text" name="username" value="<?php echo (@$data->sess->username);?>" id="username" size="16" />
			<label class="label">Password</label>
			<input class="text" type="password" name="password" value="" id="password" size="16" />
			<br/>
			<input class="button" type="submit" value="LOGIN" name="login-submit" id="login-submit" />
		</form>
		</div>
		<!-- END CONTENT -->
