<?php
session_start();
if(!include_once "config.php"){
           header("location:install.php");
 }
if (!defined('MADMECEntry')) {
    define('MADMECEntry', true);
}

if(isset($_SESSION['username'])){
            echo $_SESSION['usertype'];
          if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "2")
            {

            ?>
                <script type="text/javascript">
                    window.location.href="dashboard.php";
                </script>
                <?php

            }
            else if(isset($_SESSION['usertype'])  && $_SESSION['usertype'] == "3")
            {
            $_SESSION['storeid']='';
            $_SESSION['storename']='';

                ?>
                <script type="text/javascript">
                    window.location.href="sadashboard.php";
                </script>
                <?php
            }
            else 
            {
                //do nothing
            }    
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Stock Management System</title>

<!-- Stylesheets -->

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/cmxform.css">
<link rel="stylesheet" href="js/lib/validationEngine.jquery.css">

<!-- Scripts -->
<script src="js/lib/jquery.min.js" type="text/javascript"></script>
<script src="js/lib/jquery.validate.min.js" type="text/javascript"></script>

<script>
/*$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});*/

$(document).ready(function() {

	// validate signup form on keyup and submit
	$("#login-form").validate({
		rules: {
			username: {
				required: true,
				minlength: 3
			},
			password: {
				required: true,
				minlength: 3
			}
		},
		messages: {
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 3 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 3 characters long"
			}
		}
	});

});
	</script>
	<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
</head>
<body>
<!--    Only Index Page for Analytics   -->
<?php include_once("analyticstracking.php") ?>
<!-- TOP BAR -->
<div id="top-bar">

	<div class="page-full-width">

		<!--<a href="#" class="round button dark ic-left-arrow image-left ">See shortcuts</a>-->
		</div> <!-- end full-width -->

</div> 
<!-- end top-bar -->

<!-- HEADER -->
<div id="header">

	<div class="page-full-width cf">

		<div id="login-intro" class="fl">

			<h1>Login to Dashboard</h1>
			<h5>Enter your credentials below</h5>

		</div> <!-- login-intro -->
    
		<!-- Change this image to your own company's logo -->
		<!-- The logo will automatically be resized to 39px height. -->
		<!--<a href="http://corp.madmec.com/" id="company-branding" class="fr"  target="blank"><img src="<?php if(isset($_SESSION['logo'])) { echo "upload/".$_SESSION['logo'];}else{ echo "upload/logo.png"; } ?>" alt="MadMec" /></a>-->

	</div> <!-- end full-width -->
	</div> <!-- end header -->

        <!--<h1 style="margin-left: 440px; font-family: Georgia;     font-weight: bold; font-size:20px; color: #0060BF"><a href="http://corp.madmec.com/" target="blank">Get In Touch With Us &nbsp;&nbsp;&nbsp; <strong style="color: green">corp.madmec.com</strong></a></h1>-->

<!-- MAIN CONTENT -->
	<div id="content">
		<form action="checklogin.php" method="POST" id="login-form" class="cmxform" autocomplete="off">

		<fieldset>
			<p> <?php 
	
			if(isset($_REQUEST['msg']) && isset($_REQUEST['type']) ) {
		
				if($_REQUEST['type'] == "error")
					$msg = "<div class='error-box round'>".$_REQUEST['msg']."</div>";
				else if($_REQUEST['type'] == "warning")
					$msg = "<div class='warning-box round'>".$_REQUEST['msg']."</div>"; 
				else if($_REQUEST['type'] == "confirmation")
					$msg = "<div class='confirmation-box round'>".$_REQUEST['msg']."</div>"; 
				else if($_REQUEST['type'] == "information")
					$msg = "<div class='information-box round'>".$_REQUEST['msg']."</div>"; 
			
				echo $msg;				
			}
			?>
	
			</p>
			<p>
                                    <label>Username</label>
                                        <input type="text" id="login-username" class="round full-width-input" placeholder="Enter Username" name="username" autofocus  />
			</p>
				<p>
                                <label>Password</label>
                                        <input type="password" id="login-password" name="password" placeholder="Enter Password" class="round full-width-input"  />
			</p>
			
                                <a href="forget_pass.php" class="button ">Forgot your password?</a>
	
			<!--<a href="dashboard.php" class="button round blue image-right ic-right-arrow">LOG IN</a>-->
			<input type="submit" class="button round blue image-right ic-right-arrow" name="submit" value="LOG IN" />
		</fieldset>
			<br/>
                        
                </form>
</div> <!-- end content -->
     

<!-- FOOTER -->
<div id="footer">
	</div> <!-- end footer -->
        
       
</body>
</html>