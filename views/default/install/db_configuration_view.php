

		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Database Configuration</h1>
			
			<?php echo (get_flash_message()); ?>	
			<form class="miras" action="<?php echo (get_current_url());?>" method="post">
				<label>Database Host (Hostname or IP address)</label>
				<input class="text" type="text" name="dbhost" id="dbhost" value="<?php echo (@$data->sess->dbhost);?>" size="16" />	
				<label>Database Name</label>
				<input class="text" type="text" name="dbname" id="dbname" value="<?php echo (@$data->sess->dbname);?>" size="16" />	
				<label>Database User</label>
				<input class="text" type="text" name="dbuser" id="dbuser" value="<?php echo (@$data->sess->dbuser);?>" size="16" />	
				<label>Database Password</label>
				<input class="text" type="password" name="dbpass" id="dbpass" value="" size="16" />	
				<label>Table Prefix</label>
				<input class="text" type="text" name="dbprefix" id="dbprefix" value="<?php echo (@$data->sess->dbprefix);?>" size="5" />
				<br/>
				<div class="rig"><input class="button" type="submit" name="db-submit" id="db-submit" value="STEP 3" /></div>
			</form>
		</div>
		<!-- END CONTENT -->
