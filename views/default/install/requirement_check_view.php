

		<!-- BEGIN CONTENT -->
		<div id="content">
			<h1>Requirements Check</h1>
			
			<table style="width:100%">
				<tr>
					<th>No</th>
					<th class="lef">Requirement</th>
					<th>Yours</th>
					<th>Status</th>
				</tr>
				<?php foreach ($data->reqs as $id=>$req) : ?>
				<tr class="<?php echo ($req->status);?>">
					<td class="mid vtop"><?php echo ($id);?></td>
					<td class=""><?php echo ($req->message);?></td>
					<td class="mid"><?php echo ($req->yours);?></td>
					<td class="mid upper"><?php echo ($req->status);?></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<?php if ($data->next_step) : ?>
			<div class="rig"><button class="button" onclick="location.href='<?php echo ($data->step2_url);?>'">STEP 2</button></div>
			<?php endif; ?>
		</div>
		<!-- END CONTENT -->
