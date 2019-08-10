<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
?>
<div class="aboutus  wow flipInY">
    <div class="carousel-caption">
        <p class="wow flipInX" style="color:white;">
            We create dreams, one pixel at a time
        </p>
    </div>
</div>
<div class="gmap-area">
    <div class="container">
        <div class="row" id="map"></div>
        <div class="row">
            <div class="col-lg-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="text-center" style="font-size:20; color:#003333"  >How to Reach Us?</p>
                <p class="text-center"><b>Our experienced Customer Service Representatives are available 24/7 to help you. <br />We want your business to triumph online — we'll take the time and go the extra mile to help.</b></p>
                <b>
                    <h5><strong>Address</strong></h5>
                    <p>#42, 5th Cross, 22nd Main<br />
                        Vinayaka Nagar, JP Nagar 5th Phase</p>
                    <p>Land Mark :- Opposite to Mahaveer Wilton Appartments<br />
                        Bangalore - 560078</p>
                    <p>Phone:080-2658 1108 <br />
                        Email Address: info@madmec.com</p>
                </b>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url(<?php echo URL . ASSET_IMG; ?>funding.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Drop Your Message</h2>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <form name="contactForm" id="contactForm" method="post">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required="required" data-rule-required="true" data-validation-required-message="Please enter your name.">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email"  required="required" data-validation-required-message="Please enter your email.">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control" required="required" data-validation-required-message="Please enter your number.">
                        </div>
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company" id="company" class="form-control" required="required" placeholder="Company Name" data-validation-required-message="Please enter your company name.">
                        </div>
                        <div class="form-group">
                            <label>Company Address *</label>
                            <textarea name="companyaddress" id="companyaddress" required="required" placeholder="Company Address" rows="8" class="form-control" data-validation-required-message="Please enter a address."></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Company Profile *</label>
                            <input  type="file" id="companyprofile" name="companyprofile" required="required" class="form-control" data-validation-required-message="Please Upload valid scanned document.">
                        </div>
                        <div class="form-group">
                            <label>Subject *</label>
                            <Select name="subject" id="subject" class="form-control">
                                <option>Request for a New Project</option>
                                <option>Website Updation(Existing Customer Only)</option>
                                <option>Suggestion for a New Project</option>
                                <option>Other Reason</option>
                            </Select>
                        </div>
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea name="message" id="message" required="required" placeholder="Message"  class="form-control" rows="8" data-validation-required-message="Please enter a messages."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="messagebtn" name="messagebtn" class="btn btn-primary btn-lg">Submit Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
<link href="<?php echo URL . ASSET_CSS; ?>contact.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo URL . ASSET_JSF; ?>plugins/picedit/css/picedit.min.css" rel="stylesheet" type="text/css" />
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAilKnQBsuNCIP5xhy2rPba0fDeEeQKESU&sensor=false"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/picedit/js/picedit.edit.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', init);
        function init() {
            var DESmarker = new google.maps.Marker({});
            var destination = new google.maps.LatLng(12.898085, 77.588968); // MadMec
            var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
            var mapOptions = {
                zoom: 20,
                center: new google.maps.LatLng(12.898085, 77.588968), // MadMec
                styles: [{
                        featureType: "all",
                        elementType: "all",
                        stylers: [{
                                invert_lightness: true
                            }, {
                                saturation: 10
                            }, {
                                lightness: 30
                            }, {
                                gamma: 0.5
                            }, {
                                hue: "#1C705B"
                            }]
                    }]
            };
            var mapElement = document.getElementById('map');
            window.setTimeout(function () {
                var map = new google.maps.Map(mapElement, mapOptions);
                DESmarker.setPosition(location);
            }, 1200);
            window.setTimeout(function () {
                DESmarker.setPosition(location);
            }, 2400);
        }
        window.setTimeout(function () {
            bindContatForm();
        }, 400);
    });
</script>
