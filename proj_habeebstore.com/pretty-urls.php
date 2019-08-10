<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
?>
<!DOCTYPE html>
<html>
<head>
<title>Habeeb Enterprises a Ecommerce Online Shopping</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="Habeeb Enterprises Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="<?php echo URL ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="<?php echo URL ?>assets/css/style.css" rel='stylesheet' type='text/css' />
<!-- js -->
   <script src="<?php echo URL ?>assets/js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo URL ?>assets/js/move-top.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<link href="<?php echo URL ?>assets/css/font-awesome.css" rel="stylesheet"> 
</head>
<body>
<div class="header">
	<div class="container">
		<div class="logo">
			<h1 ><a href="index.php"><b>T<br>H<br>E</b>Habeeb Enterprises<span>The Best Supermarket</span></a></h1>
		</div>
	</div>			
</div>
<div class="content-top">
	<div class="container">
		<div class="col-md-12">
			<center><a href="<?php echo URL;?>" class="btn btn-block btn-warning"><i class="fa fa-home fa-3x" aria-hidden="true"></i>Home</a></center><hr />
		</div>
	</div>
</div>
<script>window.jQuery || document.write('<script src="<?php echo URL ?>assets/js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
<script src="<?php echo URL ?>assets/js/jquery.vide.min.js"></script>
<div class="footer">
	<div class="container">
		<div class="clearfix"></div>
			<div class="footer-bottom">
				<h2 ><a href="index.php"><b>T<br>H<br>E</b>Habeeb Enterprises<span>The Best Supermarket</span></a></h2>
				<p class="fo-para">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
				<div class=" address">
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-home" aria-hidden="true"></i>12K Street , 45 Building Road Canada.</p>
					</div>
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-phone" aria-hidden="true"></i>+1234 758 839 , +1273 748 730</p>	
					</div>
					<div class="col-md-4 fo-grid1">
						<p><a href="mailto:info@example.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>info@example1.com</a></p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<div class="copy-right">
			<p> &copy; 2016 Habeeb Enterprises. All Rights Reserved | Design by  <a href="#"> W3layouts</a></p>
		</div>
	</div>
</div>
<!-- //footer-->
<!-- smooth scrolling -->
<script type="text/javascript">
	$(document).ready(function() {
	/*
		var defaults = {
		containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear' 
		};
	*/								
	$().UItoTop({ easingType: 'easeOutQuart' });
	});
</script>
<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->
<!-- for bootstrap working -->
<script src="<?php echo URL ?>assets/js/bootstrap.js"></script>
</body>
</html>