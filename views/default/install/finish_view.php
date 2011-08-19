

		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Installation Completed</h1>
			
			<p>Thank you for using MIRAS, now you can start accessing Miras at 
			the following address.<br/><br/>
			<a href="<?php echo (get_site_url());?>"><?php echo (get_site_url());?></a>
			</p>
			<p>If you changes the permission of file db_config.php, 
			do not forget to revert it back to normal mode 0644.</p>
			<code>$ chmod 0644 <?php echo ($data->config_file);?></code>
			
			<br/>
			<h1>Stay Updates</h1>
			<ul>
				<li>Official Website: <a href="http://miras.raweet.org/">http://miras.raweet.org/</a></li>
				<li>Follow Us: <a href="http://twitter.com/MirasFramework">@MirasFramework</a></li>
				<li>Become a Fan: <a href="https://www.facebook.com/pages/Miras/241066589264903">Miras on Facebook</a></li>
			</ul>
			
			<br/>
			<h1 class="red">Important!</h1>
			<p>Please delete the following directories and its content, do not worry it is safe to do.</p>
			<code><?php echo($data->dir_to_delete);?></code>
		</div>
		<!-- END CONTENT -->
