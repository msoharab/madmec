<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
        function main(){
            if(isset($_POST['name']) && isset($_POST['mobile']) && strlen($_POST['mobile']) >= 10 ){
                insertMember();
                unset($_POST);
            }
            elseif( isset($_POST['action']) && $_POST['action'] == 'fetchnumber' ){
                $_SESSION['numbers'] = fetchNumber();
                exit(0);
            }
            elseif( isset($_POST['action']) && $_POST['action'] == 'checkNumber' ){
                checkNumber($_POST['num']);
                exit(0);
            }
            
        }
        function insertMember(){
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            if(isset($_POST['more_details']) && $_POST['more_details'] === 'yes'){
                $email = $_POST['email'];
                $dob = date("Y-m-d",strtotime($_POST['dob']));
                $gender = $_POST['gender'];
                $zipcode = $_POST['zipcode'];
                $address = $_POST['address'];
                $locality = $_POST['locality'];
                $city = $_POST['city'];
                $province = $_POST['province'];
                $query = "INSERT INTO `user_profile`
                            ( `user_name`, `cell_code`, `cell_number`, `email`,  `user_type_id`, `status_id`, `date_of_join`, `dob`, `gender`, `addressline`,  `city`, `province`, `country`, `zipcode`) 
                            VALUES
                            ('".mysql_real_escape_string($name)."','+91','".mysql_real_escape_string($mobile)."','".mysql_real_escape_string($email)."','4','1',NOW(),'".mysql_real_escape_string($dob)."','".mysql_real_escape_string($gender)."','".mysql_real_escape_string($address)."','".mysql_real_escape_string($city)."','".mysql_real_escape_string($province)."','India','".mysql_real_escape_string($zipcode)."');";
                    
            }
            else{
                 $query = "INSERT INTO `user_profile`
                            ( `user_name`, `cell_code`, `cell_number`, `user_type_id`, `status_id`, `date_of_join`) 
                            VALUES
                            ('".mysql_real_escape_string($name)."','+91','".mysql_real_escape_string($mobile)."','4','1',NOW());";
            }
            /* insert into the database*/
            $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
            if(get_resource_type($link) == 'mysql link'){
                if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                    $res = executeQuery($query);
                    if($res){
                        $_SESSION['message'] = '<h1 style="color:#000000;">Thank you for registering :)</h1>'
                                . '<h3 style="color:#000000;">Welocme to AIMIM Membership Bangalore</h3>'
                                . '<a class="btn btn-danger" href="'.URL.'">OK, Add New Member</a>';
                    }
                }
            }
            if(get_resource_type($link) == 'mysql link')
            mysql_close($link);
        }
        function fetchNumber(){
            /* insert into the database*/
            $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
            if(get_resource_type($link) == 'mysql link'){
                if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                    $query = "SELECT `cell_number` FROM `user_profile`;";
                    $res = executeQuery($query);
                    $numbers = array();
                    $i = 0;
                    while($row = mysql_fetch_assoc($res)){
                        $numbers[$i] = $row['cell_number'];
                        $i++;
                    }
                }
            }
            if(get_resource_type($link) == 'mysql link')
            mysql_close($link);
            return $numbers;
        }
        function checkNumber($num){
            if(in_array( $num,$_SESSION['numbers']))
                echo 'true';
            else
                echo 'false';
        }
        main();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AIMIM Membership Bangalore</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">AIMIM</span> Bangalore
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <!--<li>
                        <a class="page-scroll" href="#download">Download</a>
                    </li>-->
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
					<div class="col-md-8">
					</div>
                    <div class="col-md-4">
                         <div class="panel panel-red" style="background-color:#000;z-index:100;opacity:0.8;color:#23793b">
                            <div class="panel-heading">
                                <h3 class="panel-title">Please fill the form to be Member</h3>
                            </div>
                            <div class="panel-body" id="signinform">
                                
                                    <?php 
                                        if(isset($_SESSION['message'])){
                                            echo $_SESSION['message'];
                                            unset($_SESSION['message']);
                                        }
                                        else{
                                            include_once (DOC_ROOT.INC."form.php");
                                        }
                                    ?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About the Party</h2>
                <p>The All India Majlis Ittehad ul Muslimeen (AIMIM) is a political party dedicated to protect and advance the rights of Muslims, Dalits, BCs, Minorities and all other underprivileged communities in India. It bears true faith and allegiance to the Constitution of India. It strongly believes in the nation’s secular democracy and strives to protect and enhance its quality by effective representation from local municipal councils to the parliament.</p>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="content-section text-center" style="display:none;">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Download Grayscale</h2>
                    <p>You can download Grayscale for free on the preview page at Start Bootstrap.</p>
                    <a href="http://startbootstrap.com/template-overviews/grayscale/" class="btn btn-default btn-lg">Visit Download Page</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact AIMIM Bangalore</h2>
                <p>Feel free to email us or call us to give feedbacks or show your support, or to just say hello!</p>
                    <p><a href="mailto:feedback@startbootstrap.com">feedback@managae_aimim.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                   
                </ul>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div id="map"></div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Your Website 2014</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="assets/js/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets/js/grayscale.js"></script>
    <script>
        $(document).ready(function(){
            fetchnumber();
		});
		function show_form(){
			$("#member_form").css( "opacity", "1" );
			
		}
		function dim_form(){
			$("#member_form").css( "opacity", "0.7" );
		}
        function addMoreDetails(){
            if($('#more_detail_check').is(':checked'))
                $('#more_details').show();
            else
                $('#more_details').hide();
        }
        function fetchnumber(){
           $.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'fetchnumber'},
		success:function(data){
                    //alert(data);
                }
	    });
        }
        function checkNumber(){
            var num = $("#mobile").val();
             $.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'checkNumber','num':num},
		success:function(data){
                    console.log(data);
                    if(data == "true" ){
                        $("#submit").prop('disabled',true);
                        $("#mobile_err").show();
                    }
                    else{
                        $("#submit").prop('disabled',false);
                        $("#mobile_err").hide();
                    }
                }
	    });
        }
    </script>
    <style>
        .nav *{color:42DCA3;}
    </style>
</body>

</html>
