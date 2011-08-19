<!DOCTYPE html>
<html>
<head>
	<title><?php echo (get_page_title());?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo (get_theme_url());?>install/style.css" />
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
			<h1 id="site-title"><?php echo (FRAMEWORK_NAME);?> Installation</h1>
			<h3 id="site-desc">A PHP Framework That Makes Beginner Happy</h3>
		</div>
	</div>
	<!-- END HEADER -->
	
	<!-- BEGIN MAIN -->
	<div id="main">
