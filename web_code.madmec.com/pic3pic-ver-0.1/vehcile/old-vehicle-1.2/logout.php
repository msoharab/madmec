<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	function main(){
		session_destroy();
		session_commit();
//		echo '<script src="'.URL.ASSET_JSF.'config.js" language="javascript" charset="UTF-8" ></script>
//		<script type="text/javascript">'
//			, 'logoutAdmin({});'
//			, '</script>'
//;
    header("Location:".URL);
	}
	main();
?>
