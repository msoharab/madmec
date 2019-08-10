<?php ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->GymDets["short_logo"]; ?>"  alt="User Image" width="45" height="45">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->GymDets["gymname"]); ?>
                </p>
                <a href="#">
                    <i class="fa fa-circle text-success">
                    </i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_35"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Home</span>
                </a>
            </li>
            <!--<li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_33"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Managers / Admin's</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right" aria-hidden="true">
                    </i>
                    <span>Master Data</span>
                    <small class="fa fa-angle-left pull-right">
                    </small>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_34"] . 'Company'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Company</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_34"] . 'Application'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Application</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_34"] . 'User'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Users</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Enquiry</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'EnquiryAdd'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Add Enquiry</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'EnquiryFollows'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Follow-up Enquiries</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'EnquiryList'; ?>">
                            <i class="fa fa-circle-o">
                            </i>List Enquiries</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_20"] . 'EnquirySentCred'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Send Credentials</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Business</span>
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_31"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Orders</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_21"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Clients</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_22"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Gym</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_32"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Collection</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Customers</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_24"] . 'AddCustomers'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Add Customer</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_24"] . 'CustomersList'; ?>">
                            <i class="fa fa-circle-o">
                            </i>List Customers</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_24"] . 'CustomersImport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Import Customers</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Group Customers</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_25"] . 'AddGroups'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Create Group</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_25"] . 'ListGroups'; ?>">
                            <i class="fa fa-circle-o">
                            </i>List Groups</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Employees</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_26"] . 'EmployeesAdd'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Add Employee</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_26"] . 'EmployeesList'; ?>">
                            <i class="fa fa-circle-o">
                            </i>List Employees</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_26"] . 'EmployeesImport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Import Employees</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Accounts</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_27"] . 'AccountsSellOffer'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Sell Offers</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_27"] . 'AccountsPackage'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Sell Packages</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_27"] . 'AccountsStaffPay'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Pay Your Staff</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_27"] . 'AccountsExpen'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Club Expenses</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_27"] . 'AccountsDueBal'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Due / Balances</a>
                    </li>
                </ul>
            </li>-->
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Facility'; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Facilities</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Offers'; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Offers</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Packages'; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Packages</span>
                </a>
            </li>
            <!--
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Manage</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_22"]; ?>">
                            <i class="fa fa-circle-o">
                            </i>Gym</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Facility'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Facilities</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Offers'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Offers</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_28"] . 'Packages'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Packages</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Attendance</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_29"] . 'Customers'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Customers</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_29"] . 'Employees'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Employees</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Stats</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_30"] . 'Transaction'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Today's Transactions</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_30"] . 'Registration'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Today's Registrations</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_30"] . 'Customers'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Today's Attendance</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>CRM</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-arrow-right">
                    </i>
                    <span>Reports</span>
                    <span class="fa fa-angle-left pull-right">
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'OfferReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Offer Sales</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'PackageReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Package Sales</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'PaymentReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Staff Payments</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'ExpensesReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Club Expenses</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'BalanceReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Balance Sheet</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'AttendanceReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Attendance Report</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"] . 'ReceiptReport'; ?>">
                            <i class="fa fa-circle-o">
                            </i>Receipts</a>
                    </li>
                </ul>
            </li>-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
