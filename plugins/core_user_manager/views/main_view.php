
		<!-- BEGIN CONTENT -->
		<div id="content">
			<?php echo (get_flash_message()); ?>	
			<h1>Action</h1>
			<p>
				<a href="<?php echo ($data->plugin_url);?>">Create New User</a>
			</p>
			
			<h1>List of Users</h1>
			<form action="<?php echo ($data->action_url);?>" method="post">
			<table>
				<tr>
					<th>No</th>
					<th>ID</th>
					<th>Username</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Status</th>
					<th><input id="user-check-all" type="checkbox" /></th>
				</tr>
				<?php $i = 0; foreach ($data->users as $user) : ?>
				<tr>
					<td><?php echo (++$i);?></td>
					<td><?php echo ($user->user_id);?></td>
					<td><?php echo ($user->user_name);?></td>
					<td><?php echo ($user->user_fullname);?></td>
					<td><?php echo ($user->user_email);?></td>
					<td><?php echo ($user->user_type_name);?></td>
					<td><?php echo ($user->user_status_label);?></td>
					<td><input class="user-checkbox" type="checkbox" name="user_id[<?php echo ($user->user_id);?>]" id="user-id-<?php echo ($user->user_id);?>" value="<?php echo ($user->user_id);?>" /></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<div id="bulk-action-div">
				<select name="bulk-action" id="bulk-action">
					<option value="">Bulk Action</option>
					<?php foreach ($data->bulk_action_list as $bulk): ?>
					<option value="<?php echo ($bulk->id);?>"><?php echo ($bulk->name);?></option>
					<?php endforeach; ?>
				</select>
				<input type="submit" name="bulk-submit" id="bulk-submit" value="GO" />
			</div>
			</form>
		</div>
		<!-- END CONTENT -->

		<script type="text/javascript">
			document.getElementById('user-check-all').onclick = function() {
				status = this.checked;
				$('.user-checkbox').attr('checked', status);
			}
		</script>
