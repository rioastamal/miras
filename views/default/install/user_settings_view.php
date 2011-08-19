

		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>User Settings (Super Admin)</h1>
			
			<?php echo (get_flash_message()); ?>	
			<form class="miras" action="<?php echo (get_current_url());?>" method="post">
				<label>Username</label>
				<input class="text" type="text" name="username" id="username" value="<?php echo (@$data->sess->username);?>" size="16" maxlength="16" />	
				<label>First Name</label>
				<input class="text" type="text" name="firstname" id="firstname" value="<?php echo (@$data->sess->firstname);?>" size="16" />	
				<label>Last Name</label>
				<input class="text" type="text" name="lastname" id="lastname" value="<?php echo (@$data->sess->lastname);?>" size="16" />	
				<label>Password</label>
				<input class="text" type="password" name="pass1" id="pass1" value="" size="16" />	
				<label>Repeat</label>
				<input class="text" type="password" name="pass2" id="pass2" value="" size="16" />	
				<label>Email</label>
				<input class="text" type="text" name="email" id="email" value="<?php echo (@$data->sess->email);?>" size="16" />
				<br/>
				<div class="rig"><input class="button" type="submit" name="user-submit" id="user-submit" value="FINISH" /></div>
			</form>
		</div>
		<!-- END CONTENT -->
