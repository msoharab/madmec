<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo URL; ?>"><?php echo SOFT_NAME; ?></a>
		<button class="btn pull-right btn pull-right btn-primary btn-md" id="buttoggle"> <i class="fa fa-bars fa-2x "></i></button>
	</div>
	<!--  onclick="window.location.href='<?php echo URL.'control.php'; ?>';" -->
<!--		<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-1x"></i>
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0);" id="Profile" class="atleftmenu"><i class="fa fa-user fa-1x"></i> Profile</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="javascript:void(0);" onclick="">
						<a href="javascript:void(0);" id="logoutt" class="atleftmenu"><i class="fa fa-sign-out fa-fw fa-x2"></i> Logout
					</a>
				</li>
			</ul>
			 /.dropdown-user
		</li>
		 /.dropdown
	</ul>-->

	<div class="navbar-default" role="navigation" id="sidebar" width="100px">
		<div class="sidebar-nav navbar-collapse sidebar gray-skin">
			<ul class="nav" id="side-menu">
				<li>
					<class="atleftmenu" id="buttoggle"/>
				</li>
				<li id="profile_pic" class="bt-side text-center">
					<img src="<?php echo $_SESSION["USER_LOGIN_DATA"]["USER_PHOTO"]; ?>" class="img-circle" width="150"/>
					<h4 class="text-danger">
						<?php echo ucfirst($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]); ?>
					</h4>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="Users" class="atleftmenu">Users</a>
				</li>
				<li class="bt-side" style="display:none;">
					<a href="javascript:void(0);" id="Product" class="atleftmenu">Products</a>
				</li>
				<li class="bt-side" style="display:none;">
					<a href="javascript:void(0);" id="Sales" class="atleftmenu">Sales</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="Purchase" class="atleftmenu">Purchase</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="Sale" class="atleftmenu">Sale</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="Collection" class="atleftmenu">Collection</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="Payments" class="atleftmenu">Payments</a>
				</li>
				<li class="bt-side">
				<li class="bt-side">
					<a href="javascript:void(0);" id="billsinvoice" class="atleftmenu">Receipts</a>
				</li>
                                <li class="bt-side">
					<a href="javascript:void(0);" id="duesMenu" class="atleftmenu">Dues</a>
				</li>
                                <li class="bt-side">
					<a href="javascript:void(0);" id="Profile" class="atleftmenu">Profile</a>
				</li>
                                <li class="bt-side">
					<a href="javascript:void(0);" id="Setting" class="atleftmenu">Setting</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="SignOutss" class="atleftmenu">SignOut</a>
				</li>
				<li id="dummy" class="bt-side text-center">
					<h4 class="text-danger">
						Version 1.0
					</h4>
				</li>
			</ul>
		</div>
	</div>
</nav>

