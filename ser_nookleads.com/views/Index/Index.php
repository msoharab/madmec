<?php
$index = isset($this->idHolders["nookleads"]["index"]) ? (array) $this->idHolders["nookleads"]["index"] : false;
$login = isset($this->idHolders["nookleads"]["index"]["login"]) ? (array) $this->idHolders["nookleads"]["index"]["login"] : false;
$register = isset($this->idHolders["nookleads"]["index"]["register"]) ? (array) $this->idHolders["nookleads"]["index"]["register"] : false;
$contuctus = isset($this->idHolders["nookleads"]["index"]["contactus"]) ? (array) $this->idHolders["nookleads"]["index"]["contactus"] : false;
$help = isset($this->idHolders["nookleads"]["index"]["help"]) ? (array) $this->idHolders["nookleads"]["index"]["help"] : false;
$guidelines = isset($this->idHolders["nookleads"]["index"]["guidelines"]) ? (array) $this->idHolders["nookleads"]["index"]["guidelines"] : false;
$privacy = isset($this->idHolders["nookleads"]["index"]["privacy"]) ? (array) $this->idHolders["nookleads"]["index"]["privacy"] : false;
$terms = isset($this->idHolders["nookleads"]["index"]["terms"]) ? (array) $this->idHolders["nookleads"]["index"]["terms"] : false;
$rules = isset($this->idHolders["nookleads"]["index"]["rules"]) ? (array) $this->idHolders["nookleads"]["index"]["rules"] : false;
$unique = isset($this->idHolders["nookleads"]["index"]["unique"]) ? (array) $this->idHolders["nookleads"]["index"]["unique"] : false;
$facebook = isset($this->idHolders["nookleads"]["index"]["facebook"]) ? (array) $this->idHolders["nookleads"]["index"]["facebook"] : false;
$googleplus = isset($this->idHolders["nookleads"]["index"]["googleplus"]) ? (array) $this->idHolders["nookleads"]["index"]["googleplus"] : false;
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" 
                 id="<?php echo $this->idHolders["nookleads"]["index"]["list"]["parentDiv"]; ?>"
                 style="border-right : solid 1px #E4D0D0;">
                <h3>Deal</h3>
                <div class="row" 
                     id="<?php echo $this->idHolders["nookleads"]["index"]["list"]["outputDiv"] ?>">           
                         <?php
                         //require_once 'listLead.php';
                         ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6" style="border-left : solid 1px #E4D0D0;">
                <div class="text-center">
                    <h3>Connect With nOOkLeads</h3>
                </div>
                <div class="col-lg-12">
                    <!-- <h3> Login</h3>
                    <div class="row"><div class="col-lg-11"><div class="business-heading align-center"></div></div></div>
                    <div class="panel panel-danger">
                        <div class="modal-header"></div>
                        <div class="modal-body">
                            <form id="signinform">
                                <div class="form-group" >
                                    <label 
                                        for="recipient-name" 
                                        class="control-label" 
                                        id="user_name_msg">
                                        Email-Id / Username:
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="recipient-name" 
                                        placeholder="Email-Id:">
                                </div>
                                <div class="form-group">
                                    <label 
                                        for="message-text" 
                                        class="control-label" 
                                        id="pass_msg">
                                        Password:
                                    </label>
                                    <input 
                                        class="form-control" 
                                        id="message-text" 
                                        type="password" 
                                        placeholder="Password">
                                    </input>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" 
                               class="pull-left" 
                               id="forgotPassBut">
                                Forgot password... ?
                            </a>
                            <button type="button" 
                                    class="btn btn-primary" 
                                    id="getIn">
                                Login
                            </button>
                            <div class="clearfix"></div>
                            <div id="outputLogRes" class="col-lg-12"></div>
                        </div>
                    </div>-->
                    <hr />
                    <div class="text-center">
                        <a href="<?php echo $facebook["url"] ?>"
                           title="Register with facebook" 
                           class="btn btn-facebook" 
                           id="<?php echo $facebook["id1"] ?>">
                            <i class="fa fa-facebook"></i> 
                            Facebook
                        </a>
                        <a href="<?php echo $googleplus["url"] ?>" 
                           title="Register with Google+" 
                           class="btn btn-google btn-google-plus" 
                           id="<?php echo $googleplus["id1"] ?>">
                            <i class="fa fa-google"></i> 
                            Google
                        </a>
                    </div>
                    <hr />
                    <div class="text-center">
                        <!--<a href="javascript:void();" 
                           data-toggle="modal" 
                           data-target="#<?php echo $contuctus["target"] ?>"  class="gap-right">Contact</a>-->
                        <a href="<?php echo $rules["url"] ?>" class="gap-right">Rules</a>
                        <a href="<?php echo $guidelines["url"] ?>" class="gap-right">| &nbsp; Guidelines</a>
                        <a href="<?php echo $privacy["url"] ?>" class="gap-right">| &nbsp; Privacy</a>
                        <a href="<?php echo $unique["url"] ?>" class="gap-right">| &nbsp; Loyalty</a>
                        <a href="<?php echo $terms["url"] ?>" class="gap-right">| &nbsp; Terms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('login.php');
require_once('register.php');
require_once('contatctUs.php');
?>
