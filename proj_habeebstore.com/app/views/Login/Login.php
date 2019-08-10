<?php
$login = isset($this->idHolders["shop"]["index"]["Login"]) ? (array) $this->idHolders["shop"]["index"]["Login"] : false;
?>
<form action=""
      id="<?php echo $login["form"]; ?>"
      name="<?php echo $login["form"]; ?>"
      method="post">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Habeeb Shop</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <div class="form-group has-feedback">
                <input type="text"
                       class="form-control"
                       id="<?php echo $login["fields"][0]; ?>"
                       name="<?php echo $login["fields"][0]; ?>"
                       data-rules='{"required": true,"minlength": "3"}'
                       data-messages='{"required": "Enter User Name","minlength": "Length Should be minimum 4 Characters"}'
                       placeholder="User Name" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password"
                       class="form-control"
                       id="<?php echo $login["fields"][1]; ?>"
                       name="<?php echo $login["fields"][1]; ?>"
                       data-rules='{"required": true,"minlength": "6"}'
                       data-messages='{"required": "Enter Password","minlength": "Length Should be minimum 6 Characters"}'
                       placeholder="Password" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <label>
                        <input type="checkbox"
                               class="pull-center"
                               data-rules='{}'
                               data-messages='{}'
                               id="<?php echo $login["fields"][2]; ?>"
                               name="<?php echo $login["fields"][2]; ?>" /> Remember Me
                    </label>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"
                            id="<?php echo $login["fields"][3]; ?>"
                            name="<?php echo $login["fields"][3]; ?>"
                            data-rules='{}'
                            data-messages='{}'
                            class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
            <div class="social-auth-links text-center" style="display: none;">
                <p>- OR -</p>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_16"]; ?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_17"]; ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
            </div>
            <!-- /.social-auth-links -->
            <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_18"]; ?>" class="pull-center" id="forgotPassBut"> Forgot password... ?</a>
            <!--<a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_6"]; ?>" class="pull-right">Register</a>-->
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</form>
