<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
if(isset($_SESSION['USER_LOGIN_DATA'])){
    header("Location:dashboard.php");
}
require_once DOC_ADMIN_ROOT . INC . 'indexHeader.php';
?>
<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Madmec</strong> Login Form</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Control Panel</h3>
                            <p>Enter your username and password to log on:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form id="login-form" role="form" action="" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="username" placeholder="Username..." class="form-username form-control" id="username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
                            </div>
                            <button type="submit" class="btn" name="submit" id="submit">Sign in!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once DOC_ADMIN_ROOT . INC . 'indexFooter.php';
?>
<script type="text/javascript">
    $(document).ready(function () {
        window.setTimeout(function () {
            loginform();
        }, 400);
    });
</script>