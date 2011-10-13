
		<!-- BEGIN CONTENT -->
		<div id="content">
			<?php echo (get_flash_message()); ?>	
			<h1>New User</h1>
			<form class="miras" action="" method="post">
				<label class="label">Username</label>
				<input class="text" type="text" name="username" value="<?php echo (@$data->sess->username);?>" id="username" size="16" />
				<label class="label">Password</label>
				<input class="text" type="password" name="password" value="" id="password" size="16" />
				<label class="label">First Name</label>
				<input class="text" type="text" name="firstname" value="<?php echo (@$data->sess->firstname);?>" id="firstname" size="16" />
				<label class="label">Last Name</label>
				<input class="text" type="text" name="lastname" value="<?php echo (@$data->sess->lastname);?>" id="firstname" size="16" />
				<label class="label">Email</label>
				<input class="text" type="text" name="email" value="<?php echo (@$data->sess->email);?>" id="email" size="16" />
				<label class="label">Role</label>
				<select name="user-role" id="user-role">
					<option>-- Choose Role --</option>
				</select>
				<label class="label">Status</label>
				<select name="user-status" id="user-status">
					<option>-- Choose Status --</label>
				</select>
			</form>
		</div>
		<!-- END CONTENT -->

		<script type="text/javascript">
		</script>
