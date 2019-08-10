<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	echo '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			span{text-transform:capitalize;color:#4169E1 !important; font-weight:bold !important;}
		</style>
		</head>
		<body style="width:9in;margin-left: auto;margin-right: auto;">
			<div >
				'.$_SESSION['content'].'
			</div>
		</body>
		</html>';
	
?>