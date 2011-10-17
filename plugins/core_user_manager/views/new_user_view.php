
		<!-- BEGIN CONTENT -->
		<div id="content">
			<?php echo (get_flash_message()); ?>	
			<h1>New User</h1>
			<form class="miras" action="<?php echo ($data->post_url);?>" method="post">
				<label class="label">Username</label>
				<input class="text" type="text" name="username" value="<?php echo (@$data->sess->username);?>" id="username" size="16" />
				<label class="label">Password</label>
				<input class="text" type="password" name="password" id="password" size="16" value="<?php echo (@$data->sess->password);?>" />
				<label class="label">Retype</label>
				<input class="text" type="password" name="password2" id="password2" size="16" value="<?php echo (@$data->sess->password2);?>" />
				<label class="label">First Name</label>
				<input class="text" type="text" name="firstname" value="<?php echo (@$data->sess->firstname);?>" id="firstname" size="16" />
				<label class="label">Last Name</label>
				<input class="text" type="text" name="lastname" value="<?php echo (@$data->sess->lastname);?>" id="lastname" size="16" />
				<label class="label">Email</label>
				<input class="text" type="text" name="email" value="<?php echo (@$data->sess->email);?>" id="email" size="16" />
				<label class="label">Role</label>
				<select name="user-role" id="user-role">
					<option>-- Choose Role --</option>
					<?php foreach ($data->user_types as $type) : ?>
					<option <?php echo (mr_selected_if((string)$type->user_type_id, (string)@$data->sess->user_role));?> value="<?php echo ($type->user_type_id);?>"><?php echo ($type->user_type_name);?></option>	
					<?php endforeach; ?>	
				</select>
				<label class="label">Status</label>
				<select name="user-status" id="user-status">
					<option>-- Choose Status --</label>
					<?php foreach ($data->status_list as $code => $name) : ?>
					<option <?php echo (mr_selected_if((string)$code, (string)@$data->sess->user_status));?> value="<?php echo ($code);?>"><?php echo ($name);?></option>	
					<?php endforeach; ?>	
				</select>
				<br/>
				<input class="button" type="submit" name="create-user-button" value="CREATE USER" id="create-user-button" />
			</form>
		</div>
		<!-- END CONTENT -->

		<script type="text/javascript">
		</script>
