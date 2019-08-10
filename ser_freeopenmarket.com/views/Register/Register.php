<?php
$register = isset($this->idHolders["onlinefood"]["index"]["Register"]) ? (array) $this->idHolders["onlinefood"]["index"]["Register"] : false;
?>
<form action=""
      id="<?php echo $register["form"]; ?>"
      name="<?php echo $register["form"]; ?>"
      method="post">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>Online Food Order</b></a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <input type="text"
                       class="form-control"
                       id="<?php echo $register["fields"][0]; ?>"
                       name="<?php echo $register["fields"][0]; ?>"
                       data-rules='{"required": true,"minlength": "5"}'
                       data-messages='{"required": "Enter Name","minlength": "Length Should be minimum 5 Characters"}'
                       placeholder="Full name">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <input type="email"
                       class="form-control"
                       id="<?php echo $register["fields"][1]; ?>"
                       name="<?php echo $register["fields"][1]; ?>"
                       data-rules='{"required": false,"email": true,"minlength": "8"}'
                       data-messages='{"required": "Enter Email id","minlength": "Length Should be minimum 8 Characters"}'
                       placeholder="Email">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <input type="password"
                       class="form-control"
                       id="<?php echo $register["fields"][2]; ?>"
                       name="<?php echo $register["fields"][2]; ?>"
                       data-rules='{"required": true,"minlength": "6"}'
                       data-messages='{"required": "Enter Password","minlength": "Length Should be minimum 6 Characters"}'
                       placeholder="password">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <input type="password"
                       class="form-control"
                       id="<?php echo $register["fields"][3]; ?>"
                       name="<?php echo $register["fields"][3]; ?>"
                       data-rules='{"required": true,"minlength": "6","equalTo": "#<?php echo $register["fields"][2]; ?>"}'
                       data-messages='{"required": "Retype password","minlength": "Length Should be minimum 6 Characters","equalTo":"Enter same password"}'
                       placeholder="Retype password">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                <input type="number"
                       class="form-control"
                       id="<?php echo $register["fields"][4]; ?>"
                       name="<?php echo $register["fields"][4]; ?>"
                       data-rules='{"required": true,"maxlength": "10","minlength":"10"}'
                       data-messages='{"required": "Enter Mobile number","maxlength": "Length Should be 10 digits","minlength":"length should be 10 digits"}'
                       pattern='^[7-9]{1}[0-9]{9}'
                       placeholder="Mobile">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                <input type="number"
                       class="form-control"
                       id="<?php echo $register["fields"][5]; ?>"
                       name="<?php echo $register["fields"][5]; ?>"
                       data-rules='{"required": false,"maxlength": "10","minlength":"10"}'
                       data-messages='{"maxlength": "Length Should be 10 digits","minlength":"length should be 10 digits"}'
                       pattern='^[7-9]{1}[0-9]{9}'
                       placeholder="Mobile">
            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-type form-control-feedback"></span>
                <select class="form-control"
                        name="<?php echo $register["fields"][6]; ?>"
                        id="<?php echo $register["fields"][6]; ?>"
                        data-rules='{"required": true}'
                        data-messages='{"required": "Select User type"}'>
                </select>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <label>
                        <input type="checkbox"
                               data-rules='{"required": true}'
                               data-messages='{"required": "Please agree Terms & Conditions"}'
                               id="<?php echo $register["fields"][7]; ?>"
                               name="<?php echo $register["fields"][7]; ?>">  I agree to the <a href="#">terms</a>
                    </label>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat"
                            id="<?php echo $register["fields"][8]; ?>"
                            name="<?php echo $register["fields"][8]; ?>"
                            data-rules='{}'
                            data-messages='{}'>Register</button>
                </div><!-- /.col -->
            </div>
            <div class="social-auth-links text-center" style="display: none;">
                <p>- OR -</p>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_16"]; ?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_17"]; ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
            </div>
            <!-- /.social-auth-links -->
            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>" class="pull-center" id="forgotPassBut"> Forgot password... ?</a>
            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_3"]; ?>" class="pull-right">I already have a membership</a>
        </div><!-- /.form-box -->
    </div><!-- /.login-box -->
</form>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: '<?php echo $this->config["URL"] . $this->config["CTRL_6"] . 'getIdHolders' ?>',
            type: 'POST',
            dataType: 'JSON'
        }).onlinefood.index;
        var obj = new Register();
        obj.__constructor(para);
        obj.__AddUser();
    });
</script>