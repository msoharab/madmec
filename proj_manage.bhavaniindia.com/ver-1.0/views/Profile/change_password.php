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
                  id="<?php echo $Prof["form"]; ?>"
                  name="<?php echo $Prof["form"]; ?>"
                  method="post">
                <div id="login-inner">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Old Password</th>
                            <td><input type="password"
                                       class="form-control login-inp"
                                       id="<?php echo $Prof["fields"][0]; ?>"
                                       name="<?php echo $Prof["fields"][0]; ?>"
                                       data-rules='{"required": true,"minlength": "5"}'
                                       data-messages='{"required": "Enter Old Password","minlength": "Length Should be minimum 5 Characters"}'
                                       placeholder="Old Password" /></td>
                        </tr>
                        <tr>
                            <th>New Password</th>
                            <td><input type="password"
                                       class="form-control login-inp"
                                       id="<?php echo $Prof["fields"][1]; ?>"
                                       name="<?php echo $Prof["fields"][1]; ?>"
                                       data-rules='{"required": true,"minlength": "5"}'
                                       data-messages='{"required": "Enter New Password","minlength": "Length Should be minimum 5 Characters"}'
                                       placeholder="New Password" /></td>
                        </tr>
                        <tr>
                            <th>Confirm Password</th>
                            <td> <input type="password"
                                        class="form-control login-inp"
                                        id="<?php echo $Prof["fields"][2]; ?>"
                                        name="<?php echo $Prof["fields"][2]; ?>"
                                        data-rules='{"required": true,"minlength": "5","equalTo": "#<?php echo $Prof["fields"][1]; ?>"}'
                                        data-messages='{"required": "confirm password","minlength": "Length Should be minimum 5 Characters","equalTo":"Enter same password"}'
                                        placeholder="Confirm Password" /></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td> <button type="submit"
                                         class="btn btn-danger"
                                         id="<?php echo $Prof["fields"][3]; ?>"
                                         name="<?php echo $Prof["fields"][3]; ?>"
                                         data-rules='{}'
                                         data-messages='{}'/>Change Password</button></td>
                        </tr>
                    </table>
                </div>
            </form>
            <!--  end login-inner -->
            <div class="clear"></div>
        </div>
        <!--  end loginbox -->

    </div>
    <!-- End: login-holder -->

</body>
</html>