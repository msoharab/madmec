<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
?>
<div id="home">
    <!-- Slider Starts -->
    <div id="myCarousel" >
        <div class="carousel-inner">
            <!-- Item 1 -->
            <div class="item active">
                <img src="<?php echo URL . ASSET_IMG; ?>faq.jpg" alt="banner">
            </div>
            <!-- #Item 1 -->
        </div>
        <!-- #Slider Ends -->
    </div>
</div>
<section id="middle">
    <div class="container">
        <div class="row">
            <h2>We do more than you require</h2>
            <div class="col-xs-12 col-sm-8 wow fadeInRightBig">
                <h2><a>FAQ's</a></h2>
                <p><i>We list below answers to questions that arise frequently while developing websites. Should you require information that is not listed here; do not hesitate to contact us, we will be glad to address your query.</i></p>
            </div>
            <div class="col-xs-12 col-sm-4 wow fadeInRightBig">
                <img class="img-responsive img-blog"  src="<?php echo URL . ASSET_IMG; ?>faq.png">
            </div>
            <h2><a>Web Application FAQ's</a></h2>
        </div>
        <div class="row">
            <div class="col-sm-12 wow fadeInDown">
                <div class="accordion">
                    <div class="panel-group" id="accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading active">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse1">
                                       Will my website work on mobile devices?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> Yes, using responsive design we ensure our sites work on all devices, including desktops, laptops, tablets and mobiles.</p>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne2">
                                                                Do you build mobile apps?
                                                                <i class="fa fa-angle-down pull-right"></i>
                                                            </a>
                                                        </h3>
                                                    </div>
                                                    <div id="collapseOne2" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <p>Yes, We develop apps for mobile.A quick conversation will enable our team to find the best possible solution, including the functionality and platforms required, any goals to monetize the app, and other factors determining the overall scope of the project. In turn, we can provide a highly customizable plan fitting almost any budget. </p>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse2">
                                        Do you build mobile apps?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> Yes, We develop apps for mobile.A quick conversation will enable our team to find the best possible solution, including the functionality and platforms required, any goals to monetize the app, and other factors determining the overall scope of the project. In turn, we can provide a highly customizable plan fitting almost any budget.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1">
                                        What is the pricing logic in website design & development?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseTwo1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>This can vary depending on things such as how big the website is (number of pages) and the features and functionality that is included in the website. Our typical website projects start from around $5,000.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1">
                                        What is "Responsive Design" and why is it important?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseThree1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Responsive website design is an important technique implemented into a website to allow it to "respond" to the screen/display of the user, regardless of screen resolution. This means that you build ONE website that adjusts its design to be optimized perfectly on a widescreen monitor, iPads/tablet, and smart phones such as the Samsung S6 and iPhone.
                                    While responsive web design is more complex and time consuming to develop, it eliminates the need to develop a separate website for your mobile users. In addition, it allows you to update only one website instead of two.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseFour1">
                                        Can I sell products on my website?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseFour1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Sure thing - our content management system can build and host your online store, and we can set up all of the security necessary to ensure your customers' details remain safe and secure.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse5">
                                        Can we expect any delays during the development of our website?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Delays happen, but we do our best to plan our time accordingly. We typically juggle multiple projects at the same time, and each project gets equal time to ensure it is moving forward. The most common delays that we experience are waiting for feedback and collecting your website content (if you choose to develop it on your own).
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse6">
                                        Once my website is finished, can I have someone else manage it for me?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Yes, you sure can. Although we would encourage you to "stick with us", there are certain situations where it makes more sense for you to take control on your own. As long as we have control of the website maintenance, we are happy to fix bugs and errors for you that may arise. Additional charges may apply if we are asked to repair a website or web application that has been maintained by another party.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse7">
                                        What shpuld i do if there is a technical issue with my website or email?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>If you experience a technical issue, please call our support team at 080-26581108</p>
                                </div>
                            </div>
                        </div>
                    </div><!--/#accordion1-->
                </div>
            </div>
        </div><!--/.row-->
    </div><!--/.container-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 wow fadeInDown">
                <h2><a>In case, we do not like the design, then.</a></h2>
                <div class="accordion">
                    <div class="panel-group" id="accordion2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse8">
                                        Can we use fonts of our choice on our web pages?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse8" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Yes ,We proceed each project as per our client requirement.You can choose your font </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse9">
                                        I already have a website and I need it updating, can you help me?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse9" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Yes, we would be happy to look at you existing website and give you a quote for updating it.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse10">
                                        Do you redesign existing websites?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse10" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Yes we do.We provide migration service. We can redesign, retaining your company corporate style or we can redesign to give you a complete new image. Is your website up to date – let us provide you a Free of Charge Website Evaluation – we can redesign your website to take advantage of the latest web technologies.</p>
                                </div>
                            </div>
                        </div>
                    </div><!--/#accordion1-->
                </div>
            </div>
        </div><!--/.row-->
    </div><!--/.container-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 wow fadeInDown">
                <h2><a>Web Development FAQ's</a></h2>
                <div class="accordion">
                    <div class="panel-group" id="accordion3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse11">
                                        What is web development?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse11" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> Web development broadly refers to the tasks associated with developing websites for hosting via intranet or Internet. The Web development process includes Web design, Web content development, client-side/server-side scripting and network security configuration, among other tasks.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse12">
                                        Is there a difference between web design and web development?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse12" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    <p>Yes, web design refers to the "look and feel" of a website, while web development is the actual behind-the-scenes coding that makes your website work. For example, you can design a contact form on a web page-but without developing the server code that processes the form information and generates an email to the site owner, the form does not have any function. </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse13">
                                        Do your websites meet W3C Standards?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse13" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Yes, depending on your site's requirements we can code to any W3C standard to avoid common coding errors and warnings.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse14">
                                        How long does it take MadMec to build a website?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse14" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Website delivery time depends on several factors including project complexity, amount of custom development, client revisions, and more. A simple brochure website can take as little as 3 weeks while a more complicated ecommerce site can take up to 8 weeks.</p>       
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse15">
                                        Can I See My Website While It's In Progress?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse15" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>Absolutely! In fact, we encourage it. We build your website on our development server, and provide you with a username and password so that you can log in and monitor the progress of your site. During this phase, we encourage your feedback if something isn't quite the way you envisioned it or if you've changed your mind. Once your site is ready and you have provided your approval, we release it live on your server and submit your URL to the major search engines.</p>     
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse16">
                                        Do you offer consulting?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse16" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> We offer consulting, marketing, advertising, search engine optimization (SEO), search engine marketing, Adwords, social media management, and maintenance plans for both your post-launch activities and your ongoing monthly and annual plans. These ongoing services, regardless of their scale, are important for most businesses.
                                        If you're going to manage your own internet marketing and post-launch activities, start setting goals, defining your strategy and allocating resources before your site is live. Allow your web site and marketing to live, grow and adapt.</p>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse16">
                                                                How will CMS help?
                                                                <i class="fa fa-angle-down pull-right"></i>
                                                            </a>
                                                        </h3>
                                                    </div>
                                                    <div id="collapse16" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                        </div>
                                                    </div>
                                                </div>-->
                    </div><!--/#accordion1-->
                </div>
            </div>
        </div><!--/.row-->
    </div><!--/.container-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 wow fadeInDown">
                <h2><a>Web Hosting FAQ's</a></h2>
                <div class="accordion">
                    <div class="panel-group" id="accordion4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapse17">
                                        What is Web Hosting?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse17" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p>A web hosting service allows individuals and organizations to make their website accessible via the World Wide Web. Web hosts are companies that provide space on a server owned or leased for use by clients, as well as providing Internet connectivity </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse18">
                                        What Is Shared Hosting?
                                        <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapse18" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> In a shared hosting environment multiple web sites are served through a single server. Shared hosting is the most common method of hosting sites for small-to-medium size users with light to moderate Web traffic.</p>
                                </div>
                            </div>
                        </div>
                    </div><!--/#accordion1-->
                </div>
            </div>
        </div><!--/.row-->
    </div><!--/.container-->
</section><!--/#middle-->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>