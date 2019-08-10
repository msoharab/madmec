<div id="keycodes_temp" style="display:none"></div>
<!--Button to scroll to top of screen-->
<div class="toTopNav">^</div>
<script src="<?php echo URL.ASSET_JSF; ?>mmcontrol.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/metisMenu/metisMenu.min.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/picedit.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/previewForm.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>plugins/bootstrap-datepicker.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>sb-admin-2.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>address.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>menu1.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>menu2.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>menu3.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>menu4.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>mapping.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_BSF; ?>bootstrap.min.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.validate.min.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>additional-methods.min.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.form.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery-ui.min.js"></script>
<script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.calendar-widget.js"></script>
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS.ASSET_BSF; ?>bootstrap.min.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>plugins/dataTables/dataTables.bootstrap.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>plugins/metisMenu/metisMenu.min.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>plugins/picedit.min.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>plugins/previewForm.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>plugins/datepicker.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>sb-admin-2.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>datatables.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>style.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS; ?>theme.css" type="text/css"  />
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS.ASSET_JQF; ?>jquery.custom-scrollbar.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS.ASSET_JQF; ?>themes-jquery-ui.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_CSS.ASSET_JQF; ?>jquery.Jcrop.css" type="text/css"  /> 
<link rel="stylesheet" href="<?php echo URL.ASSET_DIR; ?>font-awesome-4.2.0/css/font-awesome.min.css" type="text/css"  /> 
<script language="javascript" charset="UTF-8">
$(document).ready(function(){
	var loadCSS = function(href) {
		var link = document.createElement("link");
		link.setAttribute("rel", "stylesheet");
		link.setAttribute("type", "text/css");
		link.setAttribute("href", href);
		$("head").append(link); 
		console.log(href + ' = Loadded');
	};
	var loadJS = function(src) {
		var script = document.createElement("script");
		script.setAttribute("language", "javascript");
		script.setAttribute("charset", "UTF-8");
		script.setAttribute("type", "text/javascript");
		script.setAttribute("src", src);
		$("head").append(script); 
		console.log(src + ' = Loadded');
	}; 
	var JSFILES = [
		"<?php echo URL.ASSET_JSF; ?>mmcontrol.js", 
		"<?php echo URL.ASSET_JSF; ?>plugins/dataTables/jquery.dataTables.js", 
		"<?php echo URL.ASSET_JSF; ?>plugins/dataTables/dataTables.bootstrap.js",
		"<?php echo URL.ASSET_JSF; ?>plugins/metisMenu/metisMenu.min.js",
		"<?php echo URL.ASSET_JSF; ?>plugins/picedit.js",
		"<?php echo URL.ASSET_JSF; ?>plugins/previewForm.js",
		"<?php echo URL.ASSET_JSF; ?>plugins/bootstrap-datepicker.js",
		"<?php echo URL.ASSET_JSF; ?>sb-admin-2.js",
		"<?php echo URL.ASSET_JSF; ?>address.js",
		"<?php echo URL.ASSET_JSF; ?>menu1.js",
		"<?php echo URL.ASSET_JSF; ?>menu2.js",
		"<?php echo URL.ASSET_JSF; ?>menu3.js",
		"<?php echo URL.ASSET_JSF; ?>menu4.js",
		"<?php echo URL.ASSET_JSF; ?>mapping.js",
		"<?php echo URL.ASSET_JSF.ASSET_BSF; ?>bootstrap.min.js", 
		"<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.validate.min.js",
		"<?php echo URL.ASSET_JSF.ASSET_JQF; ?>additional-methods.min.js",
		"<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.form.js",
		"<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery-ui.min.js",
		"<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery.calendar-widget.js"
	];
	var CSSFILES = [
		"<?php echo URL.ASSET_CSS.ASSET_BSF; ?>bootstrap.min.css", 
		"<?php echo URL.ASSET_CSS; ?>plugins/dataTables/dataTables.bootstrap.css", 
		"<?php echo URL.ASSET_CSS; ?>plugins/metisMenu/metisMenu.min.css", 
		"<?php echo URL.ASSET_CSS; ?>plugins/picedit.min.css", 
		"<?php echo URL.ASSET_CSS; ?>plugins/previewForm.css", 
		"<?php echo URL.ASSET_CSS; ?>plugins/datepicker.css", 
		"<?php echo URL.ASSET_CSS; ?>sb-admin-2.css", 
		"<?php echo URL.ASSET_CSS; ?>datatables.css", 
		"<?php echo URL.ASSET_CSS; ?>style.css", 
		"<?php echo URL.ASSET_CSS; ?>theme.css",
		"<?php echo URL.ASSET_CSS.ASSET_JQF; ?>jquery.custom-scrollbar.css", 
		"<?php echo URL.ASSET_CSS.ASSET_JQF; ?>themes-jquery-ui.css", 
		"<?php echo URL.ASSET_CSS.ASSET_JQF; ?>jquery.Jcrop.css", 
		"<?php echo URL.ASSET_DIR; ?>font-awesome-4.2.0/css/font-awesome.min.css" 
	];
	$.each(JSFILES, function( index, value ) {
	  /* loadJS(value); */
	});
	$.each(CSSFILES, function( index, value ) {
	  /* loadCSS(value); */
	});
	//Create button to scroll to top of page
	$('.toTopNav').css({
		cursor:'pointer',
		position:'fixed',
		width:'35px',
		height:'35px',
		zIndex:'1400',
		backgroundColor:'#C0C0C0',
		textAlign:'center',
		fontSize:'28px',
		color:'#FFFFFF',
		top:$(document).height() - Number(50),
		left:$(document).width() - Number(70)
	});
	//Scroll to the top of page
	$('.toTopNav').click(function(){
		$('html, body').animate({scrollTop:0}, 'fast');
		return false;
	});
	//Scroll to the top of page
	$('.toTopNav').bind('mouseover',function(){
		$(this).css({
			opacity:'1'
		});
	});
	$('.toTopNav').bind('mouseout',function(){
		$(this).css({
			opacity:'0.4'
		});
	});
});
</script>
</body>
</html>