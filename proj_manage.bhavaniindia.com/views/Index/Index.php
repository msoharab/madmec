<?php
$login = isset($this->idHolders["ricepark"]["index"]["Login"]) ? (array) $this->idHolders["ricepark"]["index"]["Login"] : false;
?>
<body id="login-bg">
    <!-- Start: login-holder -->
    <div id="login-holder">
        <!-- start logo -->
        <div id="logo-login">
            <a href="#"><h1 style="color:white;">Bhavani Traders</h1></a>
        </div>
        <!-- end logo -->
        <div class="clear"></div>
        <!--  start loginbox ................................................................................. -->
        <div id="loginbox">
            <!--  start login-inner -->
            <form action=""
                  id="<?php echo $login["form"]; ?>"
                  name="<?php echo $login["form"]; ?>"
                  method="post">
                <div id="login-inner">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Username</th>
                            <td><input type="text"
                                       class="form-control login-inp"
                                       id="<?php echo $login["fields"][0]; ?>"
                                       name="<?php echo $login["fields"][0]; ?>"
                                       data-rules='{"required": true,"minlength": "3"}'
                                       data-messages='{"required": "Enter User Name","minlength": "Length Should be minimum 4 Characters"}'
                                       placeholder="User Name" /></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><input type="password"
                                       class="form-control login-inp"
                                       id="<?php echo $login["fields"][1]; ?>"
                                       name="<?php echo $login["fields"][1]; ?>"
                                       data-rules='{"required": true,"minlength": "5"}'
                                       data-messages='{"required": "Enter Password","minlength": "Length Should be minimum 5 Characters"}'
                                       placeholder="Password" /></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td valign="top"><input type="checkbox"
                                                    class="pull-center"
                                                    data-rules='{}'
                                                    data-messages='{}'
                                                    id="<?php echo $login["fields"][2]; ?>"
                                                    name="<?php echo $login["fields"][2]; ?>" /><label for="login-check">Remember me</label></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><button type="submit"
                                        id="<?php echo $login["fields"][3]; ?>"
                                        name="<?php echo $login["fields"][3]; ?>"
                                        data-rules='{}'
                                        data-messages='{}'
                                        class="btn btn-primary btn-block btn-flat">Sign In</button></td>
                        </tr>
                    </table>
                </div>
            </form>
            <!--  end login-inner -->
            <div class="clear"></div>
            <a href="#" class="forgot-pwd">Forgot Password?</a>
        </div>
        <!--  end loginbox -->
        <!--  start forgotbox ................................................................................... -->
        <div id="forgotbox">
            <div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
            <!--  start forgot-inner -->
            <div id="forgot-inner">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>Email address:</th>
                        <td><input type="text" value=""   class="login-inp" /></td>
                    </tr>
                    <tr>
                        <th> </th>
                        <td><input type="button" class="submit-login"  /></td>
                    </tr>
                </table>
            </div>
            <!--  end forgot-inner -->
            <div class="clear"></div>
            <a href="" class="back-login">Back to login</a>
        </div>
        <!--  end forgotbox -->
    </div>
    <!-- End: login-holder -->
    <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"] . $this->config["CONTROLLERS"]; ?>Login.js"></script>
