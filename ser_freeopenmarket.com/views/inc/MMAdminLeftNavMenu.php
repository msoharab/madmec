<?php ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Order Freak</li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-dashboard">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                    <i class="fa fa-users">
                    </i> <span>Users</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_12"]; ?>">
                    <i class="ion ion-android-restaurant">
                    </i> <span>Restaurants</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_3"]; ?>">
                    <i class="fa fa-spoon">
                    </i> <span>Food</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"]; ?>">
                    <i class="ion ion-bag">
                    </i> <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_11"]; ?>">
                    <i class="ion ion-ios-more">
                    </i> <span>Sales</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>">
                    <i class="fa fa-sign-out">
                    </i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
