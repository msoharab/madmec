<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo URL; ?>"><?php echo SOFT_NAME; ?></a>
        <?php
        if (!isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]))
            header("Location:" . URL);
        ?>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="javascript:void(0);" id="UserProfile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="javascript:void(0);" id="Setting"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="javascript:void(0);" id="SignOut"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="navbar-default" role="navigation" id="sidebar">
        <div class="sidebar-nav navbar-collapse sidebar gray-skin">
            <ul class="nav" id="side-menu">
                <li id="profile_pic" class="bt-side text-center">
                    <img src="<?php
                    echo $_SESSION["USER_LOGIN_DATA"]["USER_PHOTO"];
//                                        if($_SESSION['BillingDetails']['BILL_LOGO']== NULL || $_SESSION['BillingDetails']['BILL_LOGO']=="")
//                                        {
//                                            echo $_SESSION['BillingDetails']['BILL_LOGO'];
//                                        }
//                                        else
//                                        {
//                                           echo BILL_LOGO;
//                                        }
                    ?>" width="150" /> <hr />
                    <h4 class="text-danger">
<?php echo ucfirst($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]); ?>
                    </h4>
                </li>
                <!-- Users -->
                <li class="bt-side"> <a href="javascript:void(0);" id="Users" class="atleftmenu"><i class="fa fa-user fa-2x fa-fw"></i>&nbsp;Users</a> </li>
                <!-- Stock -->
                <li class="bt-side"> <a href="javascript:void(0);" id="Stock" class="atleftmenu"><i class="fa fa-database fa-2x fa-fw"></i>&nbsp;Stock</a> </li>
                <!-- Material Order -->
                <li class="bt-side"> <a href="javascript:void(0);" id="MaterialOrder" class="atleftmenu"><i class="fa fa-reorder fa-2x fa-fw"></i>&nbsp;MaterialOrder</a> </li>
                <!--Marketing Company and Manager-->
                 <li class="bt-side"> <a href="javascript:void(0);" id="MarketingManager" class="atleftmenu"><i class="fa fa-users fa-2x fa-fw"></i>&nbsp;Marketing Manager</a> </li>
                <!-- Project -->
                <li class="bt-side"> <a href="javascript:void(0);"><i class="fa fa-cog fa-2x fa-fw"></i>&nbsp;Project<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Requirements -->
                        <li> <a href="javascript:void(0);" id="Requirements" class="atleftmenu"><i class="fa fa-bookmark fa-2x fa-fw"></i>&nbsp;Requirements</a> </li>
                        <!-- Quotation -->
                        <li> <a href="javascript:void(0);" id="Quotation" class="atleftmenu"><i class="fa fa-gift fa-2x fa-fw"></i>&nbsp;Quotation</a> </li>
                        <!-- Purchase Order -->
                        <li> <a href="javascript:void(0);" id="PurchaseOrder" class="atleftmenu"><i class="fa fa-bookmark-o fa-2x fa-fw"></i>&nbsp;PurchaseOrder</a> </li>
                        <!-- Project Plan -->
                        <li> <a href="javascript:void(0);" id="ProjectPlan" class="atleftmenu"><i class="fa fa-sitemap fa-2x fa-fw"></i>&nbsp;ProjectPlan</a> </li>
                        <!-- PCC -->
                        <li> <a href="javascript:void(0);" id="PCC" class="atleftmenu"><i class="fa fa-bolt fa-2x fa-fw"></i>&nbsp;PCC</a> </li>
                        <!-- Drawing -->
                        <li> <a href="javascript:void(0);" id="Drawing" class="atleftmenu"><i class="fa fa-photo fa-2x fa-fw"></i>&nbsp;Drawing</a> </li>
                        <!-- Invoice -->
                        <li> <a href="javascript:void(0);" id="Invoice" class="atleftmenu"><i class="fa fa-legal fa-2x fa-fw"></i>&nbsp;Invoice</a> </li>
                    </ul>
                </li>
                <!-- Accounts -->
                <li class="bt-side"> <a href="javascript:void(0);"><i class="fa fa-money fa-2x fa-fw"></i>&nbsp;Accounts<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <!-- Incomming -->
                        <li> <a href="javascript:void(0);" id="Incomming" class="atleftmenu"><i class="fa fa-plus-circle fa-2x fa-fw"></i>&nbsp;Incoming</a> </li>
                        <!-- Outgoing -->
                        <li> <a href="javascript:void(0);" id="Outgoing" class="atleftmenu"><i class="fa fa-minus-circle fa-2x fa-fw"></i>&nbsp;Outgoing</a> </li>
                        <!-- PettyCash -->
                        <li> <a href="javascript:void(0);" id="PettyCash" class="atleftmenu"><i class="fa fa-exchange fa-2x fa-fw"></i>&nbsp;PettyCash</a> </li>
                        <!-- Due -->
                        <li> <a href="javascript:void(0);" id="Due" class="atleftmenu"><i class="fa fa-signal fa-2x fa-fw"></i>&nbsp;Due</a> </li>
                        <!-- Followups -->
                        <li> <a href="javascript:void(0);" id="Followups" class="atleftmenu"><i class="fa fa-road fa-2x fa-fw"></i>&nbsp;Followups</a> </li>
                    </ul>
                </li>
                <!-- Reports -->
                <li class="bt-side"> <a href="javascript:void(0);" id="Reports" class="atleftmenu"><i class="fa fa-bar-chart-o fa-2x fa-fw"></i>&nbsp;Reports</a> </li>
                <!--<li class="bt-side"> <a href="javascript:void(0);" class="atleftmenu" id="SignOut"><i class="fa fa-sign-out fa-2x fa-fw"></i>&nbsp;SignOut</a> </li>-->
                <li id="dummy" class="bt-side text-center">
                    <h4 class="text-danger">
                        Version 1.0
                    </h4>
                </li>
            </ul>
        </div>
    </div>
</nav>