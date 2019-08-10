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
		<div class="head-t">
			<?php 
				require_once('header_menu.php');
			?>
		</div>
	</div>			
</div>
<!---->
<div class="content-top">
	<div class="container">
		<div class="col-md-12">
			<center><h3>Welcome to Habeeb Enterprises - DataBase Setup</h3></center>
		</div>
	</div>
</div>
<div class="content-mid">
	<div class="container">
		<div class="col-md-12">
			&nbsp;
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<a href="<?php echo URL;?>database.php?db=1" class="btn btn-block btn-success"><i class="fa fa-arrow-up" aria-hidden="true"></i>Create</a>
			</div>
			<div class="col-md-6">
				<a href="<?php echo URL;?>database.php?db=0" class="btn btn-block btn-danger"><i class="fa fa-arrow-down" aria-hidden="true"></i>Drop</a>
			</div>
		</div>
	</div>
</div>
<div class="content-mid">
	<div class="container">
		<div class="col-md-12">
		<?php
			if(isset($_GET["db"])){
				if($_GET["db"] == "1"){
					$mysqli = new mysqli("127.0.0.1", "root", "");
					/* check connection */
					if (mysqli_connect_errno()) {
						echo 'Connect failed: - '. mysqli_connect_error() .'<hr />';
					}
					else{
						$query  = file_get_contents(SQL_ROOT.'app.sql');
						/* execute multi query */
						if ($mysqli->multi_query($query)) {
							do {
								/* store first result set */
								if ($result = $mysqli->store_result()) {
									while ($row = $result->fetch_row()) {
										echo $row[0];
									}
									$result->free();
								}
								/* print divider */
								if ($mysqli->more_results()) {
									echo '<hr />';
								}
							} while ($mysqli->more_results() && $mysqli->next_result());
						}
						/* close connection */
						$mysqli->close();
					}
				}
				if($_GET["db"] == "0"){
					$mysqli = new mysqli("127.0.0.1", "root");
					/* check connection */
					if (mysqli_connect_errno()) {
						echo 'Connect failed: - '. mysqli_connect_error() .'<hr />';
					}
					else{
						$query  = 'DROP DATABASE IF EXISTS `habeebshop`;';
						/* execute multi query */
						if ($mysqli->multi_query($query)) {
							do {
								/* store first result set */
								if ($result = $mysqli->store_result()) {
									while ($row = $result->fetch_row()) {
										echo $row[0];
									}
									$result->free();
								}
								/* print divider */
								if ($mysqli->more_results()) {
									echo '<hr />';
								}
							} while ($mysqli->more_results() && $mysqli->next_result());
						}
						/* close connection */
						$mysqli->close();
					}
				}
			}
		?>
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
<?php
exit(0);
?>