<!DOCTYPE html>
<html>
<head>
<title>MIRAS ERROR</title>
<style type="text/css">
	* {
		padding: 0;
		margin: 0;
	}
	body {
		color: #333;
		font-family: Verdana;
		font-size: 12px;
	}
	#wrapper {
		width: 90%;
		padding: 8px;
		border: 1px solid #ccc;
		margin: 0 auto;
		margin-top: 3em;
		margin-bottom: 1em;
		background: #ECECEC;
	}
	#wrapper h2 {
		margin-bottom: 1em;
		padding-bottom: 8px;
		border-bottom: 1px solid #ccc;
		color: #c60000;
	}
	#wrapper #error-content {
		font-size: 16px;
	}
</style>
</head>
<body>
	<div id="wrapper">
		<h2>MIRAS ERROR</h2>
		<div id="error-content">
			<?php echo $error_msg;?>	
		</div>
	</div>
</body>
</html>
