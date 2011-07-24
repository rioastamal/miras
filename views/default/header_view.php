<!DOCTYPE html>
<html>
<head>
	<title><?php echo (get_page_title());?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo (get_theme_url());?>style.css" />
	<?php run_hooks('page_head'); ?>
</head>
<body>

<!-- BEGIN WRAPPER -->
<div id="wrapper">
	
	<!-- BEGIN HEADER -->
	<div id="header">
		<div id="menu">
			<ul>
				<?php echo (tpl_build_menu()); ?>
			</ul>
		</div>
	</div>
	<!-- END HEADER -->
	
	<!-- BEGIN MAIN -->
	<div id="main">
