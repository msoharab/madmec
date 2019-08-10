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
                    <span>Users</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"] . 'UserPersonal'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Personal</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"] . 'UserRequest'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Request</a>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Transaction
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"] . 'UserFinancialTransactions'; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"] . 'UserServiceTransactions'; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"] . 'UserCommissions'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Commission</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-exchange">
                    </i>
                    <span>Transaction</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_23"] . 'Recharge'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Recharge</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Bus Booking</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
