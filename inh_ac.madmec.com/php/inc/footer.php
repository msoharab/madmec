<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
?>	
	
	    </div>
     <!-- /. WRAPPER  -->
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="<?php echo URL.ASSET_JS; ?>jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo URL.ASSET_JS; ?>bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo URL.ASSET_JS; ?>jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="<?php echo URL.ASSET_JS; ?>morris/raphael-2.1.0.min.js"></script>
	<!-- jquery ui -->
    <script src="<?php echo URL.ASSET_JS; ?>jquery-ui.min.js"></script>
    <script src="<?php echo URL.MAIN_JS; ?>config.js"></script>
    <div id="load_box" >
		<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/> <hr /> <h2>Please wait...</h2> </center>
	</div>
</body>
</html>
