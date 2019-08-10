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
                    <i class="fa fa-database">
                    </i>
                    <span>Master Data</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_21"] . 'Company'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Company</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_21"] . 'Application'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Application</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_21"] . 'User'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Users</a>
                    </li>
                </ul>
            </li>
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
            <!--<li class="treeview">
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_10"]; ?>">
                    <i class="fa fa-table"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tablet">
                    </i>
                    <span>Operators</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_22"] . 'Manage'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Manage</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_22"] . 'ListOperator'; ?>">
                            <i class="fa fa-circle-o">
                            </i>List</a>
                    </li>
                </ul>
            </li>-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share-square-o">
                    </i>
                    <span>Gateways</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]. 'GatewayBusiness'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Business info</a>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Protocols
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayTechnical'; ?>">
                                    <i class="fa fa-circle-o">
                                    </i>REST</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayTechnical'; ?>">
                                    <i class="fa fa-circle-o">
                                    </i>XML-RPC</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayTechnical'; ?>">
                                    <i class="fa fa-circle-o">
                                    </i>SOAP</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Operators
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'Manage'; ?>">
                                    <i class="fa fa-circle-o">
                                    </i>Manage</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'ListOperator'; ?>">
                                    <i class="fa fa-circle-o">
                                    </i>List</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"] . 'Mapping'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Mapping</a>
                    </li>
                    <li>
                        <a href="<?php echo "#"; ?>">
                            <i class="fa fa-circle-o">
                            </i>Transaction
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Commission</a>
                    </li>
                </ul>
            </li>
            <!--<li class="treeview">
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
                            </i>Orders</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Purchase Stock</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Stock Planing</a>
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
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_13"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Stock Statistics</a>
                    </li>
                </ul>
            </li>-->
            <!--<li>
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
            </li>-->
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
            <!--
            <li class="treeview">
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"]; ?>">
                    <i class="fa fa-user-secret">
                    </i>
                    <span>API User</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiUserPersonal'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Personal</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiUserBusiness'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Business</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiUserRequest'; ?>">
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
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiFinancialTransactions'; ?>">
                                    <i class="fa fa-circle">
                                    </i>Financial</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiServiceTransactions'; ?>">
                                    <i class="fa fa-circle">
                                    </i>Services</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'ApiCommissions'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Commission</a>
                    </li>
                </ul>
            </li>-->
            <!--<li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-calendar">
                    </i>
                    <span>CRM</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Email</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>SMS</a>
                    </li>
                </ul>
            </li>-->
            <!--<li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"]; ?>">
                    <i class="fa fa-book">
                    </i> <span>Reports</span>
                </a>
            </li>-->
            <li>
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
