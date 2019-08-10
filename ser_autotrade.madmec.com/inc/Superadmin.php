<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo URL; ?>"><?php echo SOFT_NAME; ?></a>
		
	</div>
	<!--  onclick="window.location.href='<?php echo URL.'control.php'; ?>';" -->

			<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-1x"></i>
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0);" id="notification" class="atleftmenu"><i class="fa fa-bell-o"></i> notification </a>
				</li>
				<li class="divider"></li>
				<li>
						<a href="javascript:void(0);" id="logouts" class="atleftmenu"><i class="fa fa-exclamation-triangle"></i> LogOut</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
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
					<a href="javascript:void(0);" id="Clients" class="atleftmenu">Clients</a>
				</li>
								<li class="bt-side">
					<a href="javascript:void(0);" id="Order_follow-Ups" class="atleftmenu">Order follow-Ups</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="client_collection" class="atleftmenu">Client Collection</a>
				</li>
                                <li class="bt-side">
					<a href="javascript:void(0);" id="admin_dues" class="atleftmenu">Dues</a>
				</li>
                                <li class="bt-side">
					<a href="javascript:void(0);" id="admin_duefollowup" class="atleftmenu">Follow UP</a>
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

