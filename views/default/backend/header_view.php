<!DOCTYPE html>
<html>
<head>
	<title><?php echo (get_page_title());?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo (get_theme_url());?>backend/style.css" />
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
			<h1 id="site-title"><a href="<?php echo (get_site_url());?>"><?php echo (FRAMEWORK_NAME);?></a></h1>
			<h3 id="site-desc"><?php echo (get_option('site_description'));?></h3>
		</div>
	</div>
	<!-- END HEADER -->
	
	<!-- BEGIN MAIN -->
	<div id="main">
