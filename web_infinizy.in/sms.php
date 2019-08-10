<?php
session_start();
//echo print_r($_SESSION['USER_LOGIN_DATA']);
if (!isset($_SESSION['USER_LOGIN_DATA'])) {
    ?>
    <script type="text/javascript">
        window.location.href = "index.html";
    </script>
    <?php
}
?>
<html>
    <head>
        <title>Infinizy ::Smsform</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Bulk SMS, Bulk EMail , Hosting, Web Server , Servers , DNS, SMS , Email, SMS Packages, Transactional SMS , Promotional SMS" /><script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!-- Custom Theme files -->
        <link href="assets/css/style.css" rel='stylesheet' type='text/css' />

        <!-- Custom Theme files -->
        <!--webfont-->
        <style type="text/css">
            label.error{
                color: red;
            }
        </style>
        <!-- Custom Theme files -->
        <!--webfont-->
        <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
        <!--webfont-->
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="price_header">
            <div class="container">
                <div class="header_top">
                    <div class="header-left">
                        <div class="logo">
                            <a href="index.html"><h2>Infinizy</h2>
                                <!--<img src="images/logo.png" alt=""/> -->
                            </a>
                        </div>
                        <div class="menu">
                            <a class="toggleMenu" href="#"><img src="assets/images/nav.png" alt="" /></a>
                            <ul class="nav" id="nav">

                                <li><a href="index.html">About Us</a></li>
                                <li><a href="services.html">Services </a></li>
                                <li><a href="partner.html">Partners</a></li>
                                <li><a href="contact.html">Contact US</a></li>
                                <li><a href="index.html">Logout</a></li>
                                <div class="clearfix"></div>
                            </ul>

                            <script type="text/javascript" src="assets/js/responsive-nav.js"></script>
                        </div>
                    </div>
                    <ul class="phone" >

                        <li><i class="ph_icon"> </i></li>
                        <li><p>(+91)-9036257172</p></li>

                    </ul> </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="features">
                <div class="col-md-4">
                    <!--<div class="contact-left">
                            <h2>location</h2>
                              <div class="company_address">
                                            <p>Near Mahaveer Wilton Apartment</p>
                                            <p>JP Nagar 5<sup>th</sup> Phase,</p>
                                                            <p>Bangalore-560029</p>
                                                            <p>INDIA</p>
                                            <p>Phone:(+91)-9036257172</p>
                                            <p>Email: <span><a href="mailto:info(at)teamgear.com">info@infinizy.in</a></span></p>
                    <!--<p>Follow on: <span><a href="#">Facebook</a></span>, <span><a href="#">Twitter</a></span></p>
       </div>
      <div class="map">
<iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.150159095245!2d77.5863987148826!3d12.89806441997725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae153e3a2818d3%3A0x90da24ba7189f291!2sMadMec!5e0!3m2!1sen!2sin!4v1447060932302" width="500" height="500" frameborder="0" style="border:0" allowfullscreen></iframe></a></small>
</div>
</div>-->
                    <div class="sms">            <a href="#"><img src="assets/images/bulksms.jpg" alt="" /></a> </div>
                </div>
                <div class="col-md-8">
                    <div class="contact-right">
                        <h2>SMS  </h2>
                        <div class="contact-form">
                            <form method="post" action="register.php"  name="smsform"   id="smsform" >
                                <div class="form-group">
                                    <label for="Name">TO</label>
                                    <input type="number" name="number" class="form-control" placeholder="Mobile Number" required="required" maxlength="100"/>
                                </div>
                                <textarea  name="message" id="sendmessage" placeholder="Message" class="form-control" required=""></textarea>
                                <div class="col-md-8">  <label class="fa-btn btn-1 btn-1e btn3" ><input type="submit"   value="Send " id="Send"></label></div>
                                <div class="col-md-4"> &nbsp;&nbsp;&nbsp;  <span id="count" class="text-left"></span></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>

        <div class="footer_icon">
            <i class="icon"><img src="assets/images/footer_icon.png"> </i>
        </div>
        <div class="footer">
            <div class="footer">
                <div class="container">
                    <div class="col-md-2 span_2">
                        <h3>Resources</h3>
                        <ul class="list1">
                            <li><a href="services.html">Services</a></li>
                            <li><a href="partner.html">Partner</a></li>
                            <!--<li><a href="#">Why Us?</a></li>
                            <li><a href="pricing.html">Pricing</a></li> -->
                        </ul>
                    </div>
                    <div class="col-md-2 span_2">
                        <h3>About Us</h3>
                        <ul class="list1">
                            <li><a href="index.html">Our Story</a></li>
                            <li><a href="partner.html">Our Investors</a></li>
                            <!-- <
                             <li><a href="#">Jobs</a></li>  -->
                        </ul>
                    </div>
                    <div class="col-md-2 span_2">
                        <h3>Connect</h3>
                        <ul class="list1">
                            <li><a href="contact.html">Contact Us</a> </li>
                            <li><a href="https://facebook.com" target="_blank">Facebook</a></li>
                            <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
                            <!-- <li><a href="#">Terms of Use</a></li>
                             <li><a href="#">Solution</a></li>  -->
                    </div>
                    <div class="col-md-6 span_3 wow fadeInRight" data-wow-delay="0.4s">
                        <ul class="list2 list3">
                            <i class="phone"> </i>
                            <li class="phone_desc"><p>(+91)-9036257172</p></li>
                            <div class="clearfix"> </div>
                        </ul>
                        <ul class="list2">
                            <i class="msg"> </i>
                            <li class="phone_desc"><p><a href="mailto:info@infinizy.in"> info@infinizy.in</a></p></li>
                            <div class="clearfix"> </div>
                        </ul>

                        <p class="copy">&copy;2015 Powered by <a href="http://corp.madmec.com" target="_blank">MADMEC</a></p>
                    </div>
                </div>
            </div>


            <script src="assets/js/jquery.validate.js"></script>
            <script src="assets/js/jquery.validate.min.js"></script>
            <script src="assets/js/index.js"></script>
        </div>
    </div>
</body>
</html>