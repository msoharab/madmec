<?php ?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>">
                    <i class="fa fa-home fa-fw"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_3"]; ?>">
                    <i class="fa fa-sign-in fa-fw"></i>
                    <span>Login</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_18"]; ?>">
                    <i class="fa ion-locked fa-fw"></i>
                    <span>Forgot Password</span>
                </a>
            </li>
			<!--
            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_6"]; ?>">
                    <i class="ion-android-done-all"></i>
                    <span>Register</span>
                </a>
            </li>
			-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
