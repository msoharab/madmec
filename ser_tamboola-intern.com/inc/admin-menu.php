<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<!-- <a href="#" class="navbar-brand"><i class="menubtn fa fa-bars fa-2x"></i></a>  -->
		<a class="navbar-brand" href="<?php echo URL; ?>">Thambola</a>
	</div>
	<!-- /.navbar-header -->
	<ul class="nav navbar-top-links navbar-right">

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-bell fa-fw"></i>  <span id="alert_count">( 0 )</span> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'enquiry/list_today_enquiries.php'; ?>';">
						<div>
							Enquiry follow-ups
							<span class="pull-right text-muted small"><span id="fol_count">( 0 )</span></span>
						</div>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'stats/customer_stats.php'; ?>';">
						<div>
							Expired customers
							<span class="pull-right text-muted small"><span id="exp_count">( 0 )</span></span>
						</div>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'stats/no_show.php'; ?>';">
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
					<a href="javascript:void(0);" onclick="window.open('http://cms.madmec.com/help.php');">
						<i class="fa fa-info-circle"></i> Help
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.'logout.php'; ?>';">
						<i class="fa fa-sign-out fa-fw fa-x2"></i> Logout
					</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->
	<div class="navbar-default" role="navigation" id="sidebar">
		<div class="sidebar-nav navbar-collapse sidebar gray-skin">
			<ul class="nav" id="side-menu">
				<li id="home" class="bt-side">
				
					<a href="javascript:void(0);" id="Dash" class="menuAL toggle"><i class="fa fa-home fa-x2"></i> Home</a>
				</li>
				<li id="gymname" class="bt-side">
				
				<a href="javascript:void(0);" id="SingleDash" class="menuAL toggle"><i class="fa fa-users fa-2x"></i></i> 
					<label id="printrs" name="0"><?php echo ucfirst(GYMNAME) ?></label></a>
				</li>
				
				<!-- /.nav-enquiry -->
				<li id="enquiry" class="bt-side">
					<a href="#">Enquiry<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0);" id="EnquiryAdd" class="menuAL toggle">
							<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>enquiry.png" border="0" width="30" height="30"/>&nbsp;Add enquiry</a>
						</li>
						<li>
							<a href="javascript:void(0);" id="EnquiryFollow" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;Follow-ups</a>
						</li>
<!--						
						<li>
							<a href="javascript:void(0);" id="EnquiryPF" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;Pending follow-ups</a>
						</li>
						<li>
							<a href="javascript:void(0);" id="EnquiryEF" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;Expired follow-ups</a>
						</li>
-->
						<li>
							<a href="javascript:void(0);"id="EnquiryListAll" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;List All</a>
						</li>
					</ul>
					<!-- /.nav-Customer -->
				</li>
				<li id="customers" class="bt-side">
					<a href="#">Customers<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CustomerAdd">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/>
								&nbsp;Add Customer
							</a>
						</li>
					<!--	
					   <li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CustomerEdit">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>edit_user.png" border="0" width="30" height="30"/>
								&nbsp;Edit Customer
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CustomerDel">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>delete_user.png" border="0" width="30" height="30"/>
								&nbsp;Delete Customer
							</a>
						</li>
                 -->   						
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CustomerList">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>
								&nbsp;List customers
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CGroupAdd">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_group.png" border="0" width="30" height="30"/>
								&nbsp;Add Group
							</a>
						</li>
             <!--						
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CGroupEdit">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>edit_group.png" border="0" width="30" height="30"/>
								&nbsp;Edit Group
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CGroupDel">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>delete_group.png" border="0" width="30" height="30"/>
								&nbsp;Delete Group
							</a>
						</li>
            -->				
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CGList">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_groups.png" border="0" width="30" height="30"/>
								&nbsp;List Groups
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CustomerImport">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>import.png" border="0" width="30" height="30"/>
								&nbsp;Import Customers
							</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li id="trainers" class="bt-side">
					<a href="#">Trainers<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerAdd">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Add Employee
							</a>
						</li>
					<!--	<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerEdit">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>edit_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Edit trainer
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerDel">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>delete_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Delete trainer
							</a>
						</li> -->
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerList">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_trainer.png" border="0" width="30" height="30"/>
								&nbsp;List Employee
							</a>
						</li>
<!--
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerPay">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>pay_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Pay Employee
							</a>
						</li>
-->
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="TrainerImport">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>import.png" border="0" width="30" height="30"/>
								&nbsp;Import Employee
							</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				
				<li id="accounts" class="bt-side">
					<a href="#">Accounts<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0);" class="menuAL toggle"  id="Fee">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>fee-icon-2.gif" border="0" width="30" height="30"/>
								&nbsp;Fee
							</a>
						</li>
			<!--			<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>aerobics.png" border="0" width="30" height="30"/>
								&nbsp;Aerobics fee
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>dance.png" border="0" width="30" height="30"/>
								&nbsp;Dance fee
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>yoga.png" border="0" width="30" height="30"/>
								&nbsp;Yoga fee
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>zumba.png" border="0" width="30" height="30"/>
								&nbsp;Zumba fee
							</a>
						</li> -->
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="PackageFee">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>packages.png" border="0" width="30" height="30"/>
								&nbsp;Package fee
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="StaffPay">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>pay_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Staff payments
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="ClubExpenses">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>expenses.png" border="0" width="30" height="30"/>
								&nbsp;Club expenses
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="DueBalance">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>due.png" border="0" width="30" height="30"/>
								&nbsp;Due/Balance
							</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li id="manage" class="bt-side">
					<a href="#">Manage<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="MarkAtt">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>attendance.png" border="0" width="30" height="30"/>
								&nbsp;Mark attendance
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="AddFacility">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_facility2.png" border="0" width="30" height="30"/>
								&nbsp;Add Facility
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="AddOffer">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_offers.png" border="0" width="30" height="30"/>
								&nbsp;Add Offer
							</a>
						</li>
					<!--
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="EditOffer">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>edit_offers.png" border="0" width="30" height="30"/>
								&nbsp;Edit offer
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="DeleteOffer">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>delete_offers.png" border="0" width="30" height="30"/>
								&nbsp;Delete offer
							</a>
						</li>
                -->					
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="ListOffer">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_offers.png" border="0" width="30" height="30"/>
								&nbsp;List offers
							</a>
						</li>
             				
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="AddPackage">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_packages.png" border="0" width="30" height="30"/>
								&nbsp;Add package
							</a>
						</li>
				<!--	
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="EditPackage">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>edit_packages.png" border="0" width="30" height="30"/>
								&nbsp;Edit package
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="DeletePackage">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>delete_packages.png" border="0" width="30" height="30"/>
								&nbsp;Delete package
							</a>
						</li>
             -->			
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="ListPackage">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_packages.png" border="0" width="30" height="30"/>
								&nbsp;List packages
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
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>accounts.png" border="0" width="30" height="30"/>
								&nbsp;Accounts
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="StRegistrations">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>registration.png" border="0" width="30" height="30"/>
								&nbsp;Registrations
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="StCustomers">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>stats.png" border="0" width="30" height="30"/>
								&nbsp;Customers
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="StEmployee">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>trainer.png" border="0" width="30" height="30"/>
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
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>gym_collection.png" border="0" width="30" height="30"/>
								&nbsp;Club
							</a>
						</li>
						<!-- <li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>aerobics_collection.png" border="0" width="30" height="30"/>
								&nbsp;Aerobics
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>dance_collection.png" border="0" width="30" height="30"/>
								&nbsp;Dance
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>yoga_collection.png" border="0" width="30" height="30"/>
								&nbsp;Yoga
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>zumba_collection.png" border="0" width="30" height="30"/>
								&nbsp;Zumba
							</a>
						</li> -->
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RPackage">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>package_collection.png" border="0" width="30" height="30"/>
								&nbsp;Package
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RRegistrations">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>registration.png" border="0" width="30" height="30"/>
								&nbsp;Registrations
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RPayments">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>pay_trainer.png" border="0" width="30" height="30"/>
								&nbsp;Payments
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RExpenses">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>expenses.png" border="0" width="30" height="30"/>
								&nbsp;Expenses
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RBalanceSheet">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>profit_loss.png" border="0" width="30" height="30"/>
								&nbsp;Balance Sheet
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RCustomers">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>customer_attendance.png" border="0" width="30" height="30"/>
								&nbsp;Customers
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="REmployee">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>trainer_attendance.png" border="0" width="30" height="30"/>
								&nbsp;Employee
							</a>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="RReceipts">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>receipts.png" border="0" width="30" height="30"/>
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
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>mobile_app.png" border="0" width="30" height="30"/>
								&nbsp;Mobile App
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="toggle" id="CRMEmail">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>email.png" border="0" width="30" height="30"/>
								&nbsp;Email Manager
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="toggle" id="CRMsms">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>sms.png" border="0" width="30" height="30"/>
								&nbsp;SMS manage
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CRMFeedback">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>feedback.png" border="0" width="30" height="30"/>
								&nbsp;Feedbacks
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="menuAL toggle" id="CRMExpiry">
								<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>demon.png" border="0" width="30" height="30"/>
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
