<?php
$register = isset($this->idHolders["nookleads"]["index"]["register"])
        ? (array) $this->idHolders["nookleads"]["index"]["register"]
        : false;
$facebook = isset($this->idHolders["nookleads"]["index"]["facebook"])
        ? (array) $this->idHolders["nookleads"]["index"]["facebook"]
        : false;
$googleplus = isset($this->idHolders["nookleads"]["index"]["googleplus"])
        ? (array) $this->idHolders["nookleads"]["index"]["googleplus"]
        : false;
?>
<!-- Register modal start-->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="RegisterModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="RegisterModal">Register</h3>
            </div>
            <div class="modal-body">
                <form id="custregform">
                    <div class="form-group">
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo $facebook["url"]?>"
                               title="Facebook"
                               class="btn btn-facebook btn-block"
                               id="<?php echo $facebook["id2"]?>">
                                <i class="fa fa-facebook"></i>
                                Register Using Facebook
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <a href="<?php echo $googleplus["url"]?>"
                               title="Google+"
                               class="btn btn-google-plus btn-block"
                               id="<?php echo $googleplus["id2"]?>">
                                <i class="fa fa-google-plus"></i>
                                Register Using Google
                            </a>
                        </div>
                    </div><br>
                    <p class="text-center"> - Or - </p>
                    <div class="form-group">
                        <label for="recipient-name1" class="control-label" id="cust_nmmsg"> Full Name:</label>
                        <input type="text"
                               class="form-control"
                               id="recipient-name1"
                               placeholder="Full Name"/>
                    </div>
                    <div class="form-group">
                        <label for="recipient-email" class="control-label" id="emmsg"> Email-Id:</label>
                        <input
                            type="email"
                            class="form-control"
                            id="recipient-email"
                            placeholder="Email-Id"/>
                    </div>
                    <div class="form-group">
                        <label for="recipientpass1" class="control-label" id="passmsgmsg"> Password:</label>
                        <input class="form-control"
                               type="password"
                               placeholder="Password"
                               id="recipientpass1"/>
                    </div>
                    <div class="form-group">
                        <label for="recipientpass2" class="control-label" id="cpassmsgmsg"> Confirm Password:</label>
                        <input class="form-control"
                               placeholder="Confirm Password"
                               type="password"
                               id="recipientpass2"/>
                    </div>
                    <!--
                    <div class="form-group">
                        <p class="pull-left" id="engmsg">Prove you are a human</p>
                        <i class="fa fa-thumbs-o-up fa-fw pull-right"></i>
                    </div>
                    -->
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <input type="checkbox"
                               name="test"
                               value="Agreed"
                               id="human"
                               checked="checked" />
                        <label>
                            &nbsp; Accept Terms & Condition
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary pull-left" id="old-receipent">Already have an account Login</button>-->
                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        id="regCloseBut">
                    Close
                </button>
                <button type="button"
                        class="btn btn-primary"
                        id="registerInBut">
                    Register
                </button>
                <div id="RegisterOutput" class="col-lg-12"></div>
            </div>
        </div>
    </div>
</div>
<!-- Register modal end-->
