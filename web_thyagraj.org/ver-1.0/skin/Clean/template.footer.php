<?php
//  +------------------------------------------------------------------------+
//  | template.footer.php                                                    |
//  +------------------------------------------------------------------------+
if (isset($footer) == false)
	exit();
?>
</div><!-- end content_container -->
</div>
</div>
<!-- end content_container -->
<div id="footer_container">
<?php echo $footer; ?>
</div><!-- end footer_container -->
</div>
</div><!-- end wrapper_container -->
<script type="text/javascript">
	$(document).ready(function () {
		$(window).load(function () {
			$('#preloader').fadeOut('slow', function () {
				$(this).remove();
			});
			$('body').css({
				overflowX : 'hidden',
			});
		});
	});
</script>
</body>
</html>
