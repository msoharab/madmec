<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li>Mail Us</li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner6 animated zoomInUp">
        </div>
        <!-- mail -->
        <div class="mail">
            <h3>Mail Us</h3>
            <div class="agileinfo_mail_grids">
                <div class="col-md-4 agileinfo_mail_grid_left">
                    <ul>
                        <li><i class="fa fa-home" aria-hidden="true"></i></li>
                        <li>address<span>868 1st Avenue NYC.</span></li>
                    </ul>
                    <ul>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i></li>
                        <li>email<span><a href="mailto:info@example.com">info@example.com</a></span></li>
                    </ul>
                    <ul>
                        <li><i class="fa fa-phone" aria-hidden="true"></i></li>
                        <li>call to us<span>(+123) 233 2362 826</span></li>
                    </ul>
                </div>
                <div class="col-md-8 agileinfo_mail_grid_right">
                    <form name="contactForm" id="contactForm" method="post">
                        <div class="col-md-6 wthree_contact_left_grid">
                            <input type="text" name="name" id="name" placeholder="Name*" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Name*';
                                    }" required="required" data-rule-required="true" data-validation-required-message="Enter your name.">
                            <input type="email" name="email" id="email" placeholder="Email*" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Email*';
                                    }" required="required" data-rule-required="true" data-validation-required-message="Enter your email.">
                        </div>
                        <div class="col-md-6 wthree_contact_left_grid">
                            <input type="text" name="phone" id="phone" placeholder="Telephone*" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Telephone*';
                                    }" required="required" data-rule-required="true" data-validation-required-message="Enter your number">
                            <input type="text" name="subject" id="subject" placeholder="Subject*" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Subject*';
                                    }" required="required" data-rule-required="true" data-validation-required-message="Enter the Subject.">
                        </div>
                        <div class="clearfix"> </div>
                        <textarea name="message" id="message" placeholder="Message*" onfocus="this.value = '';" onblur="if (this.value == '') {
                                    this.value = 'Message...';
                                }"></textarea>
                        <input type="submit" id="messagebtn" name="messagebtn" value="Submit">
                        <input type="reset" value="Clear">
                    </form>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //mail -->
    </div>
    <div class="clearfix"></div>
</div>
<!-- //banner -->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
<script type="text/javascript">
    $(document).ready(function () {
        window.setTimeout(function () {
            bindContatForm();
        }, 400);
    });
</script>