

		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Writing Settings</h1>
			<?php echo (get_flash_message()); ?>	
			
			<p><strong class="red">SQL Query</strong></p>
			<div style="overflow:auto;height:300px;border:1px dashed #ccc;background:#f1f1f1;margin-bottom:20px;">
				<pre><?php echo ($data->sql_query);?></pre>
			</div>
			
			<p><strong class="red"><?php echo ($data->config_file);?></strong></p>
			<code style=""><pre><?php echo ($data->file_content);?></pre></code>
			<?php if ($data->next_step) : ?>
			<div class="rig"><button class="button" onclick="location.href='<?php echo ($data->finish_url);?>'">FINISH</button></div>
			<?php endif; ?>
		</div>
		<!-- END CONTENT -->
