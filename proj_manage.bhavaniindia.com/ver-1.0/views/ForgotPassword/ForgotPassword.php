<?php
$fpassword = isset($this->idHolders["ricepark"]["index"]["ForgotPassword"]) ? (array) $this->idHolders["ricepark"]["index"]["ForgotPassword"] : false;
?>
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
        <!--  start forgotbox ................................................................................... -->
        <div id="forgotbox">
             <form action=""
              id="<?php echo $fpassword["form"]; ?>"
              name="<?php echo $fpassword["form"]; ?>"
              method="post">
            <div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
            <!--  start forgot-inner -->
            <div id="forgot-inner">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>Email address:</th>
                        <td><input type="email"
                               class="form-control login-inp"
                               id="<?php echo $fpassword["fields"][0]; ?>"
                               name="<?php echo $fpassword["fields"][0]; ?>"
                               data-rules='{"required": true,"email": true,"minlength": "8"}'
                               data-messages='{"required": "Enter Email ID","email": "Enter Email id","minlength": "Length Should be minimum 8 Characters"}'
                               placeholder="Email">
                        </td>
                    </tr>
                    <tr>
                        <th> </th>
                        <td><input type="button" class="submit-login"
                            id="<?php echo $fpassword["fields"][1]; ?>"
                            name="<?php echo $fpassword["fields"][1]; ?>"
                            data-rules='{}'
                            data-messages='{}' />
                           </td>
                    </tr>
                </table>
            </div>
             </form>
            <!--  end forgot-inner -->
            <div class="clear"></div>
            <a href="" class="back-login">Back to login</a>
        </div>
        <!--  end forgotbox -->

    </div>
    <!-- End: login-holder -->
</body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: '<?php echo $this->config["URL"] . $this->config["CTRL_18"] . 'getIdHolders' ?>',
            type: 'POST',
            dataType: 'JSON'
        }).recharge.index;
        var obj = new ForgotPassword();
        obj.__constructor(para);
        obj.__SendPass();
    });
</script>
