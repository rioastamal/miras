
		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Action</h1>
			<p>
				<a href="<?php echo ($data->plugin_url);?>">Create New User</a>
			</p>
			
			<h1>List of Users</h1>
			<table>
				<tr>
					<th>No</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Status</th>
					<th><input id="user-check-all" type="checkbox" /></th>
				</tr>
				<?php $i = 0; foreach ($data->users as $user) : ?>
				<tr>
					<td><?php echo (++$i);?></td>
					<td><?php echo ($user->user_fullname);?></td>
					<td><?php echo ($user->user_email);?></td>
					<td><?php echo ($user->user_type_name);?></td>
					<td><?php echo ($user->user_status_label);?></td>
					<td><input class="user-checkbox" type="checkbox" name="user_id[<?php echo ($user->user_id);?>]" id="user-id-<?php echo ($user->user_id);?>" /></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<div id="bulk-action-div">
				<select name="bulk-action" id="bulk-action">
					<option value="">Bulk Action</option>
				</select>
			</div>
		</div>
		<!-- END CONTENT -->

		<script type="text/javascript">
			document.getElementById('user-check-all').onclick = function() {
				status = this.checked;
				$('.user-checkbox').attr('checked', status);
			}
		</script>
