<?php ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->UserDets["profic"]; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->UserDets["user_name"]); ?>
                </p>
                <a href="#">
                    <i class="fa fa-circle text-success">
                    </i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user">
                    </i>
                    <span>User</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Personal Details</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Business Details</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Request</a>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Transaction</a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Commission</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                    <i class="fa fa-user-secret">
                    </i>
                    <span>API User</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share-square-o">
                    </i>
                    <span>Recharge Gateway</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Business</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Technical</a>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Transaction</a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Commission</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_21"]; ?>">
                    <i class="fa fa-money">
                    </i>
                    <span>Master Data</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
            </li>
            <li class="treeview">
                <a href="<?php echo "#"; ?>">
                    <i class="fa fa-area-chart">
                    </i> 
                    <span>Stock</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Purchase Stock</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Sales Stock</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Stock On Payment</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Stock On Credit</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table">
                    </i>
                    <span>Services</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_10"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Online Recharge</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_10"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Bulk Sms</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_10"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Bus Booking</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_10"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Movie Ticket</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-envelope">
                    </i> 
                    <span>SMS Gateway</span> 
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_12"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Business</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_12"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Technical</a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o">
                            </i>Transaction</a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_12"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_12"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-link">
                    </i>
                    <span>Routing</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Static</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Dynamic</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-calendar">
                    </i> 
                    <span>CRM</span>
                    <small class="label pull-right bg-red">
                    </small>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"]; ?>">
                    <i class="fa fa-book">
                    </i> <span>Reports</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
