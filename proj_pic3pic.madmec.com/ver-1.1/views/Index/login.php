<?php
$login = isset($this->idHolders["pic3pic"]["index"]["login"]) ? (array) $this->idHolders["pic3pic"]["index"]["login"] : false;
$facebook = isset($this->idHolders["pic3pic"]["index"]["facebook"]) ? (array) $this->idHolders["pic3pic"]["index"]["facebook"] : false;
$googleplus = isset($this->idHolders["pic3pic"]["index"]["googleplus"]) ? (array) $this->idHolders["pic3pic"]["index"]["googleplus"] : false;
?>
<!-- Login modal start -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="loginform">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            id="loginCloseBut">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="loginModal"> Login</h3>
                    <!--<button type="button" class="btn btn-primary pull-right" id="registerLogBut"> Register</button>-->
                </div>
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
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a href="<?php echo $facebook["url"] ?>"
                                   title="Facebook"
                                   target="_self"
                                   class="btn btn-facebook btn-block"
                                   id="<?php echo $facebook["id1"] ?>">
                                    <i class="fa fa-facebook"></i>
                                    Login With Facebook</a>
                            </div>
                            <div class="visible-sm visible-xs hidden-md hidden-lg"><br><br></div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a href="<?php echo $googleplus["url"] ?>"
                                   title="Google+" 
                                   target="_self"
                                   class="btn btn-google-plus btn-block"
                                   id="<?php echo $googleplus["id1"] ?>">
                                    <i class="fa fa-google-plus"></i>
                                    Login With Google
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#forgotPass"
                       class="pull-left"
                       id="forgotPassBut">
                        Forgot password... ?
                    </a>
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">
                        Close
                    </button>
                    <button type="button"
                            class="btn btn-primary"
                            id="getIn">
                        Login
                    </button>
                    <div class="clearfix"></div>
                    <div id="outputLogRes" class="col-lg-12"></div>
                </div>
            </div>
            <!-- forgotpass modal end-->
            <div id="forgotPass" style="display: none;">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            id="loginCloseBut">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="loginModal"> Forgot Password</h3>
                    <!--<button type="button" class="btn btn-primary pull-right" id="registerLogBut"> Register</button>-->
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordform">
                        <div class="form-group" >
                            <label
                                for="recipient-name"
                                class="control-label"
                                id="fuser_name_msg">
                                Email-Id / Username:
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                id="frecipient-name"
                                placeholder="Email-Id:">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a href="<?php echo $facebook["url"] ?>"
                                   title="Facebook"
                                   target="_blank"
                                   class="btn btn-facebook btn-block"
                                   id="<?php echo $facebook["id3"] ?>">
                                    <i class="fa fa-facebook"></i>
                                    Login With Facebook</a>
                            </div>
                            <div class="visible-sm visible-xs hidden-md hidden-lg"><br><br></div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a href="<?php echo $googleplus["url"] ?>"
                                   title="Google+" target="_blank"
                                   class="btn btn-google-plus btn-block"
                                   id="<?php echo $googleplus["id3"] ?>">
                                    <i class="fa fa-google-plus"></i>
                                    Login With Google
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            id="floginCloseBut"
                            data-dismiss="modal">
                        Close
                    </button>
                    <button type="button"
                            class="btn btn-primary"
                            id="fgetIn">
                        Send
                    </button>
                    <div class="clearfix"></div>
                    <div id="foutputLogRes" class="col-lg-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#forgotPassBut').click(function () {
        $('#forgotPass').show();
        $('#loginform').hide();
    });
    $('#loginBut').click(function () {
        $('#forgotPass').hide();
        $('#loginform').show();
    });
</script>
<!-- login modal end-->
