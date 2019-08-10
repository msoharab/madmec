<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-xs-offset-0 col-md-offset-1">
            <aside class="col-xs-12 col-md-3 border-right-lightgrey takemetop">
                <div class="business-heading align-center">
                    <strong>
                        <?php echo ucfirst($_SESSION["USERDATA"]["logindata"]["user_name"]); ?>
                    </strong>
                </div>
                <?php
                require_once 'profilePicture.php';
                ?>
                <div class="business-heading align-center">My Businesses</div>
                <?php
                require_once 'listBusinesses.php';
                ?>
                <div class="clearfix"></div>
                <div class="business-heading align-center">Admin Businesses</div>
                <?php
                require_once 'listAdminBusinesses.php';
                ?>
            </aside>
            <div class="col-xs-12 col-sm-12 col-md-5"
                 id="<?php echo $this->idHolders["nookleads"]["deal"]["list"]["parentDiv"]; ?>"
                 style="border-right:solid 1px #E4D0D0;">
                <div class="business-heading"><strong>Deal</strong></div>
                <div class="row" id="<?php echo $this->idHolders["nookleads"]["deal"]["list"]["outputDiv"] ?>">
                    <?php
                    require_once 'listLead.php';
                    ?>
                </div>
            </div>
            <aside class="col-xs-12 col-md-3 border-left-lightgrey takemetop">
                <div class="list-group">
                    <button type="button"
                            id="<?php echo $this->idHolders["nookleads"]["deal"]["create"]["parentBut"]; ?>"
                            name="<?php echo $this->idHolders["nookleads"]["deal"]["create"]["parentBut"]; ?>"
                            data-toggle="modal"
                            data-target="#<?php echo $this->idHolders["nookleads"]["deal"]["create"]["parentDiv"]; ?>"
                            data-whatever="@mdo"
                            class="list-group-item btn btn-block btn-success">
                        Individual Lead
                    </button>
                </div>
                <div class="business-heading align-center">Subscription</div>
                <?php
                require_once 'listSubscription.php';
                ?>
            </aside>
        </div>
    </div>
</div>
<!-- Start modals -->
<?php
require_once 'createBusiness.php';
require_once 'report.php';
require_once 'individualLead.php';
/* Load Business Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Business.js" ></script>';
/* Load Geography Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Geography.js" ></script>';
/* Load Languages Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Languages.js" ></script>';
/* Load Report Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Report.js" ></script>';
/* Load Sections Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Sections.js" ></script>';
/* Load Subscribe Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Subscribe.js" ></script>';
/* Load Popular Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Popular.js" ></script>';
/* Load Lead Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Lead.js" ></script>';
/* Load NewLead Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'NewLead.js" ></script>';
/* Load Profile Pic Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'ProfilePic.js" ></script>';
?>