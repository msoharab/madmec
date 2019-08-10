<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo URL; ?>">
            <?php echo SOFT_NAME; ?>
        </a>
    </div>
    <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> Today's date :
        <?php echo date( "d / M / Y");?> 
		<a href="#" class="btn btn-danger square-btn-adjust atleftmenu" id="SignOut"><i class="fa fa-sign-out fa-2x"></i>SignOut</a> 
	</div>
</nav>
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li id="profile_pic" class="bt-side text-center"> <img src="<?php echo $_SESSION["USER_LOGIN_DATA"]["USER_PHOTO"]; ?>" class="img-circle" width="150" />
                <h4 class="text-danger">
					<?php echo ucfirst($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]); ?>
				</h4>
            </li>
            <!-- Users -->
            <li class="bt-side"> <a href="javascript:void(0);" id="Users" class="atleftmenu"><i class="fa fa-user fa-3x"></i>Users</a> </li>
            <!-- Stock -->
            <li class="bt-side"> <a href="javascript:void(0);" id="Stock" class="atleftmenu"><i class="fa fa-database fa-3x"></i>Stock</a> </li>
            <!-- Material Order -->
            <li class="bt-side"> <a href="javascript:void(0);" id="MaterialOrder" class="atleftmenu"><i class="fa fa-reorder fa-3x"></i>MaterialOrder</a> </li>
            <!-- Project -->
            <li class="bt-side"> <a href="javascript:void(0);"><i class="fa fa-cog fa-3x"></i>Project<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <!-- Requirements -->
                    <li> <a href="javascript:void(0);" id="Requirements" class="atleftmenu"><i class="fa fa-bookmark fa-2x"></i>Requirements</a> </li>
                    <!-- Quotation -->
                    <li> <a href="javascript:void(0);" id="Quotation" class="atleftmenu"><i class="fa fa-gift fa-2x"></i>Quotation</a> </li>
                    <!-- Purchase Order -->
                    <li> <a href="javascript:void(0);" id="PurchaseOrder" class="atleftmenu"><i class="fa fa-bookmark-o fa-2x"></i>PurchaseOrder</a> </li>
                    <!-- Project Plan -->
                    <li> <a href="javascript:void(0);" id="ProjectPlan" class="atleftmenu"><i class="fa fa-sitemap fa-2x"></i>ProjectPlan</a> </li>
                    <!-- PCC -->
                    <li> <a href="javascript:void(0);" id="PCC" class="atleftmenu"><i class="fa fa-bolt fa-2x"></i>PCC</a> </li>
					<!-- Drawing -->
					<li> <a href="javascript:void(0);" id="Drawing" class="atleftmenu"><i class="fa fa-photo fa-2x fa-fw"></i>Drawing</a> </li>
                    <!-- Invoice -->
                    <li> <a href="javascript:void(0);" id="Invoice" class="atleftmenu"><i class="fa fa-legal fa-2x"></i>Invoice</a> </li>
                </ul>
            </li>
            <!-- Accounts -->
            <li class="bt-side"> <a href="javascript:void(0);"><i class="fa fa-money fa-3x"></i>Accounts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <!-- Incomming -->
                    <li> <a href="javascript:void(0);" id="Incomming" class="atleftmenu"><i class="fa fa-plus-circle fa-2x"></i>Incomming</a> </li>
                    <!-- Outgoing -->
                    <li> <a href="javascript:void(0);" id="Outgoing" class="atleftmenu"><i class="fa fa-minus-circle fa-2x"></i>Outgoing</a> </li>
                    <!-- PettyCash -->
                    <li> <a href="javascript:void(0);" id="PettyCash" class="atleftmenu"><i class="fa fa-exchange fa-2x"></i>PettyCash</a> </li>
                    <!-- Due -->
                    <li> <a href="javascript:void(0);" id="Due" class="atleftmenu"><i class="fa fa-signal fa-2x"></i>Due</a> </li>
                    <!-- Followups -->
                    <li> <a href="javascript:void(0);" id="Followups" class="atleftmenu"><i class="fa fa-road fa-2x"></i>Followups</a> </li>
                </ul>
            </li>
            <!-- Reports -->
            <li class="bt-side"> <a href="javascript:void(0);" id="Reports" class="atleftmenu"><i class="fa fa-bar-chart-o fa-3x"></i>Reports</a> </li>
        </ul>
    </div>
</nav>