<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- <a href="#" class="navbar-brand"><i class="menubtn fa fa-bars "></i></a>  -->
        <a class="navbar-brand">Tamboola</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw" ></i>  <span id="alert_count" ></span> <i class="fa fa-caret-down" ></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0);" id="custrequestt" title="Customer's Request">
                        <div id="custrequest">
                            fetch Customer Request From Database
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <?php
        if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-reorder fa-fw" ></i>  <span id="alert_count"></span> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);" id="userrequestfrmmmadmin" title="user's Request">
                            <div id="displayreqts">
                                fetch User Request From Database
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <?php
        }
        ?>
        <li class="dropdown" style="display : none;">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>  <span id="alert_count">( 0 )</span> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'enquiry/list_today_enquiries.php'; ?>';">
                        <div>
                            Enquiry Follow-ups
                            <span class="pull-right text-muted small"><span id="fol_count">( 0 )</span></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'stats/customer_stats.php'; ?>';">
                        <div>
                            Expired customers
                            <span class="pull-right text-muted small"><span id="exp_count">( 0 )</span></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'stats/no_show.php'; ?>';">
                        <div>
                            No show customers
                            <span class="pull-right text-muted small"><span id="track_count">( 0 )</span></span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user"></i><i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0);" id="profile" class="toggletop menuAL">
                        <i class="fa fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);"   onclick='window.open("<?php echo URL . "helpdesk/"; ?>");' >
                        <i class="fa fa-info-circle"></i> Help
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';">
                        <i class="fa fa-sign-out fa-fw "></i> Logout
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default" role="navigation" id="sidebar">
        <div class="sidebar-nav navbar-collapse sidebar">
            <ul class="nav" id="side-menu">

                <li id="gymname" class="bt-side">
                    <a href="javascript:void(0);"
                    <?php
                    if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
                        ?>
                           id="SingleDash"
                           <?php
                       }
                       ?>
                       class="menuAL toggle"><img src="<?php echo LOGO_1; ?>" class="img-circle" width="50" /></i>
                        <label id="printrs" name="0"><?php echo ucwords($_SESSION["SETGYM"]["GYM_NAME"]) ?></label></a>
                </li>

                <li id="home" class="bt-side">
                    <a href="javascript:void(0);" id="Dash" class="menuAL toggle"><i class="fa fa-home "></i> Home</a>
                </li>
                <?php
                if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
                    ?>
                    <li id="home" class="bt-side">
                        <a href="javascript:void(0);" id="owneruser" class="menuAL toggle"><i class="fa fa-users "></i> Users</a>
                    </li>
                    <?php
                }
                ?>
                <!-- /.nav-enquiry -->
                <li id="enquiry" class="bt-side">
                    <a href="#">Enquiry<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" id="EnquiryAdd" class="menuAL toggle">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>enquiry.png" border="0" width="30" height="30"/>&nbsp;Add Enquiry</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" id="EnquiryFollow" class="menuAL toggle"><i class="fa fa-th-list fa-fw "></i>&nbsp;Follow-ups</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"id="EnquiryListAll" class="menuAL toggle"><i class="fa fa-th-list fa-fw "></i>&nbsp;List All</a>
                        </li>
                    </ul>
                    <!-- /.nav-Customer -->
                </li>
                <li id="customers" class="bt-side">
                    <a href="#">Customers<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerAdd">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_user.png" border="0" width="30" height="30"/>
                                &nbsp;Add Customer
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerList">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_users.png" border="0" width="30" height="30"/>
                                &nbsp;List Customers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerImport">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="30" height="30"/>
                                &nbsp;Import Customers
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="groups" class="bt-side">
                    <a href="#">Groups<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CGroupAdd">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_group.png" border="0" width="30" height="30"/>
                                &nbsp;Create
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CGList">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_groups.png" border="0" width="30" height="30"/>
                                &nbsp;List Groups
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="trainers" class="bt-side">
                    <a href="#">Employee<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerAdd">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_trainer.png" border="0" width="30" height="30"/>
                                &nbsp;Add Employee
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerList">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_trainer.png" border="0" width="30" height="30"/>
                                &nbsp;List Employee
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerImport">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="30" height="30"/>
                                &nbsp;Import Employee
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="accounts" class="bt-side">
                    <a href="javascript:void(0);">Accounts<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle"  id="Fee">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>fee-icon-2.gif" border="0" width="30" height="30"/>
                                &nbsp;Offer Payment
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="PackageFee">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>packages.png" border="0" width="30" height="30"/>
                                &nbsp;Package Payment
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="StaffPay">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="30" height="30"/>
                                &nbsp;Staff Payments
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="ClubExpenses">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="30" height="30"/>
                                &nbsp;Club Expenses
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="DueBalance">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>due.png" border="0" width="30" height="30"/>
                                &nbsp;Due / Balance
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="manage" class="bt-side">
                    <a href="#">Manage<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="AddFacility">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_facility2.png" border="0" width="30" height="30"/>
                                &nbsp;Facilities
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="AddOffer">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_offers.png" border="0" width="30" height="30"/>
                                &nbsp;Offers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="ListOffer">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_offers.png" border="0" width="30" height="30"/>
                                &nbsp;List Offers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="AddPackage">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_packages.png" border="0" width="30" height="30"/>
                                &nbsp;Packages
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="ListPackage">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_packages.png" border="0" width="30" height="30"/>
                                &nbsp;List Packages
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="attendance" class="bt-side">
                    <a href="#">Attendance<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="MarkCustAtt">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>
                                &nbsp;Customers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="MarkTrinAtt">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>
                                &nbsp;Employees
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="stats" class="bt-side">
                    <a href="#">Stats<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="StAccount">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>accounts.png" border="0" width="30" height="30"/>
                                &nbsp;Transactions
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="StRegistrations">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="30" height="30"/>
                                &nbsp;Registrations
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="StCustomers">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>stats.png" border="0" width="30" height="30"/>
                                &nbsp;Customers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="StEmployee">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer.png" border="0" width="30" height="30"/>
                                &nbsp;Employee
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="reports" class="bt-side">
                    <a href="#">Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RClub">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>gym_collection.png" border="0" width="30" height="30"/>
                                &nbsp;Offers
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RPackage">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>package_collection.png" border="0" width="30" height="30"/>
                                &nbsp;Package
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RRegistrations">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="30" height="30"/>
                                &nbsp;Registrations
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RPayments">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="30" height="30"/>
                                &nbsp;Payments
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RExpenses">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="30" height="30"/>
                                &nbsp;Expenses
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RBalanceSheet">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>profit_loss.png" border="0" width="30" height="30"/>
                                &nbsp;Balance Sheet
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RCustomers">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>customer_attendance.png" border="0" width="30" height="30"/>
                                &nbsp;Customers Attendance
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="REmployee" style="display:none;">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer_attendance.png" border="0" width="30" height="30"/>
                                &nbsp;Employee
                            </a>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="RReceipts">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>receipts.png" border="0" width="30" height="30"/>
                                &nbsp;Receipts
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li id="crm" class="bt-side">
                    <a href="#">CRM<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMAPP">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>mobile_app.png" border="0" width="30" height="30"/>
                                &nbsp;Mobile App
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="toggle" id="CRMEmail" style="display:none;">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>email.png" border="0" width="30" height="30"/>
                                &nbsp;Email Manager
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="toggle" id="CRMsms" style="display:none;">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>sms.png" border="0" width="30" height="30"/>
                                &nbsp;SMS manage
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMFeedback">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>feedback.png" border="0" width="30" height="30"/>
                                &nbsp;Feedbacks
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMExpiry">
                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>demon.png" border="0" width="30" height="30"/>
                                &nbsp;Expiry Intimation
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <!-- ---- End all Menu -->
                <li id="dummy" class="bt-side"><a href="javascript:void(0);">Version 3.0<span class="fa arrow"></span></a></li>
            </ul>
        </div>
        <div class="overlay"></div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
