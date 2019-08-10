<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title id="title">
            <?php echo GYMNAME; ?>
        </title>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.9.1.min.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.expander.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.form.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.media.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.metadata.v2.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-migrate-1.1.0.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jQueryRotateCompressed.2.2.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-ui.min.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.longclick.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.purl.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.mousewheel.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>config.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>script.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>script2.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>jpegcam/webcam.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.Jcrop.js" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery.calendar-widget.js" language="javascript"></script>
        <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>theme.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo URL . ASSET_CSS . ASSET_JQF; ?>jquery-ui.1.10.4.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>datatables.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>JQuery/jquery.Jcrop.css" type="text/css" />
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
    </head>
    <body>
        <div id="menuminimize">
            <span>Menu</span>
        </div>
        <div id="menu_header">
            <div id="adm" class="mhead">Main 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'menu.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>home.png" border="0" width="20" height="20" />
                        <span>Home</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'admin / main_page_admin.php'; ?>';" class="mhead_list">
                        <img src="<?php echo ADMIN_ANON_IMAGE; ?>" border="0" width="20" height="20" />
                        <span>Profile</span>
                    </div>
                    <div onclick="window.open(" <?php echo URL . "helpdesk/"; ?> class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>help.png" border="0" width="20" height="20" />
                        <span>Help</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'logout.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>logout.png" border="0" width="20" height="20" />
                        <span>Logout</span>
                    </div>
                </div></div>
            <div id="enquiry" class="mhead">Enquiry 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / enquiry.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>enquiry.png" border="0" width="20" height="20" />
                        <span>Add Enquiry</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / list_today_enquiries.php'; ?>';"
                         class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list.png" border="0" width="20" height="20" />
                        <span>List current</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / list_pending_enquiries.php'; ?>';"
                         class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list.png" border="0" width="20" height="20" />
                        <span>List pending</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / list_expired_enquiries.php'; ?>';"
                         class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list.png" border="0" width="20" height="20" />
                        <span>List expired</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / list_enquiries.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list.png" border="0" width="20" height="20" />
                        <span>List All</span>
                    </div>
                </div></div>
            <div id="customers" class="mhead">Customers 
                <div class="mhead_list_box">
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'user / add_user.php'; ?>';">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>add_user.png" border="0" width="20" height="20" />
                        <span>Add Customer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_edit_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>edit_user.png" border="0" width="20" height="20" />
                        <span>Edit customer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_delete_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>delete_user.png" border="0" width="20" height="20" />
                        <span>Delete customer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_search_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>search_user.png" border="0" width="20" height="20" />
                        <span>Search customers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list_users.png" border="0" width="20" height="20" />
                        <span>List Customers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / add_group_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>add_group.png" border="0" width="20" height="20" />
                        <span>Add Group</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_edit_groups.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>edit_group.png" border="0" width="20" height="20" />
                        <span>Edit group</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_delete_groups.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>delete_group.png" border="0" width="20" height="20" />
                        <span>Delete group</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_search_groups.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>search_group.png" border="0" width="20" height="20" />
                        <span>Search groups</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / list_groups.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list_groups.png" border="0" width="20" height="20" />
                        <span>List groups</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / import_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>import.png" border="0" width="20" height="20" />
                        <span>Import customers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'user / export_user.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>export.png" border="0" width="20" height="20" />
                        <span>Export customers</span>
                    </div>
                </div></div>
            <div id="trainers" class="mhead">Trainers 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / add_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>add_trainer.png" border="0" width="20" height="20" />
                        <span>Add trainer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / list_edit_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>edit_trainer.png" border="0" width="20" height="20" />
                        <span>Edit trainer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / list_delete_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>delete_trainer.png" border="0" width="20" height="20" />
                        <span>Delete trainer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / list_search_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>search_trainer.png" border="0" width="20" height="20" />
                        <span>Search trainers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / list_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list_trainer.png" border="0" width="20" height="20" />
                        <span>List trainers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / pay_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>pay_trainer.png" border="0" width="20" height="20" />
                        <span>Pay trainer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / import_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>import.png" border="0" width="20" height="20" />
                        <span>Import trainers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'trainer / export_trainer.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>export.png" border="0" width="20" height="20" />
                        <span>Export trainers</span>
                    </div>
                </div></div>
            <div id="accounts" class="mhead">Accounts 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / gym.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>gym.png" border="0" width="20" height="20" />
                        <span>Gym fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / aerobics.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>aerobics.png" border="0" width="20" height="20" />
                        <span>Aerobics fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / dance.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>dance.png" border="0" width="20" height="20" />
                        <span>Dance fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / yoga.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>yoga.png" border="0" width="20" height="20" />
                        <span>Yoga fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / zumba.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>zumba.png" border="0" width="20" height="20" />
                        <span>Zumba fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / packages.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>packages.png" border="0" width="20" height="20" />
                        <span>Package fee</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / payments.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>pay_trainer.png" border="0" width="20" height="20" />
                        <span>Staff Payments</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / expenses.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>expenses.png" border="0" width="20" height="20" />
                        <span>Club Expenses</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'accounts / due.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>due.png" border="0" width="20" height="20" />
                        <span>Due / Balance</span>
                    </div>
                </div></div>
            <div id="manage" class="mhead">Manage 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / verify.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>attendance.png" border="0" width="20" height="20" />
                        <span>Verify Email Id</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / attendance.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>attendance.png" border="0" width="20" height="20" />
                        <span>Mark Attendance</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / add_offers.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>add_offers.png" border="0" width="20" height="20" />
                        <span>Add Offer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_edit_offers.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>edit_offers.png" border="0" width="20" height="20" />
                        <span>Edit offer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_delete_offers.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>delete_offers.png" border="0" width="20" height="20" />
                        <span>Delete offer</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_offers.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list_offers.png" border="0" width="20" height="20" />
                        <span>List Offers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / add_packages.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>add_packages.png" border="0" width="20" height="20" />
                        <span>Add Package</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_edit_packages.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>edit_packages.png" border="0" width="20" height="20" />
                        <span>Edit package</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_delete_packages.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>delete_packages.png" border="0" width="20" height="20" />
                        <span>Delete package</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'manage / list_packages.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>list_packages.png" border="0" width="20" height="20" />
                        <span>List Packages</span>
                    </div>
                </div></div>
            <div id="stats" class="mhead">Stats 
                <div class="mhead_list_box">
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'stats / accounts_stats.php'; ?>';">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>accounts.png" border="0" width="20" height="20"
                             alt="Accounts Statistics" />
                        <span>Accounts</span>
                    </div>
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'stats / reg_stats.php'; ?>';">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>registration.png" border="0" width="20" height="20"
                             alt="Registrations" />
                        <span>Registrations</span>
                    </div>
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'stats / customer_stats.php'; ?>';">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>stats.png" border="0" width="20" height="20"
                             alt="Customer Statistics" />
                        <span>Customers</span>
                    </div>
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'stats / trainer_stats.php'; ?>';">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>trainer.png" border="0" width="20" height="20"
                             alt="Trainer Statistics" />
                        <span>Trainers</span>
                    </div>
                </div></div>
            <div id="reports" class="mhead">Reports 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / gym_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>gym_collection.png" border="0" width="20" height="20" />
                        <span>Gym</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / aerobics_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>aerobics_collection.png" border="0" width="20" height="20" />
                        <span>Aerobics</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / dance_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>dance_collection.png" border="0" width="20" height="20" />
                        <span>Dance</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / yoga_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>yoga_collection.png" border="0" width="20" height="20" />
                        <span>Yoga</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / zumba_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>zumba_collection.png" border="0" width="20" height="20" />
                        <span>Zumba</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / package_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>package_collection.png" border="0" width="20" height="20" />
                        <span>Package</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / reg_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>registration.png" border="0" width="20" height="20" />
                        <span>Registrations</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / payments_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>pay_trainer.png" border="0" width="20" height="20" />
                        <span>Payments</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / expenses_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>expenses.png" border="0" width="20" height="20" />
                        <span>Expenses</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / balance_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>profit_loss.png" border="0" width="20" height="20" />
                        <span>Balance Sheet</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / customer_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>customer_attendance.png" border="0" width="20" height="20" />
                        <span>Customers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / trainer_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>trainer_attendance.png" border="0" width="20" height="20" />
                        <span>Trainers</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / history_reports.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>history.png" border="0" width="20" height="20" />
                        <span>History</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'reports / recp.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>receipts.png" border="0" width="20" height="20" />
                        <span>Receipts</span>
                    </div>
                </div></div>
            <div id="crm" class="mhead">CRM 
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'crm / app.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>mobile_app.png" border="0" width="20" height="20" />
                        <span>Mobile App</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'crm / email.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>email.png" border="0" width="20" height="20" />
                        <span>Email Manager</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'crm / sms.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>sms.png" border="0" width="20" height="20" />
                        <span>SMS manager</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'crm / feedback.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>feedback.png" border="0" width="20" height="20" />
                        <span>Feedbacks</span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'crm / demon.php'; ?>';" class="mhead_list">
                        <img src="<?php echo URL . ASSET_IMG . ICON_THEME2; ?>demon.png" border="0" width="20" height="20" />
                        <span>Expiry Intimation</span>
                    </div>
                </div></div>
            <div id="alert" class="mhead">Alert 
                <span id="alert_count">( 0 )</span>
                <div class="mhead_list_box">
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'enquiry / list_pending_enquiries.php'; ?>';"
                         class="mhead_list">
                        <span>Follow-ups 
                            <span id="fol_count">( 0 )</span></span>
                    </div>
                    <div class="mhead_list" onclick="window.location.href = '<?php echo URL.ADMIN.'stats / customer_stats.php'; ?>';">
                        <span>Expiry date 
                            <span id="exp_count">( 0 )</span></span>
                    </div>
                    <div onclick="window.location.href = '<?php echo URL.ADMIN.'stats / no_show.php'; ?>';" class="mhead_list">
                        <span>No show 
                            <span id="track_count">( 0 )</span></span>
                    </div>
                </div></div>
        </div>
        <p>&nbsp;</p>
        <script language="javascript" charset="UTF-8">
    $(document).ready(function () {
    	$('#menuminimize').css({
    		left : '0px',
    		top :
    		'0px',
    		position : 'fixed',
    		displan : 'none',
    		width : '100%',
    		cursor : 'pointer',
    		displan : 'none',
    		backgroundColor : '#FFFFF;'
    	});
    	$('#menuminimize span').css({
    		cursor : 'pointer',
    		backgroundColor : '#FFFFF;'
    	});
    	$('.mhead').bind('click', function
    		(event) {
    		var obj = $(this).children('.mhead_list_box');
    		var top = $(this).css('top');
    		var innerwidth = $(window).innerWidth();
    		var innerheight = $(window).innerHeight();
    		var availwidth = window.screen.availWidth;
    		var availheight =
    			window.screen.availHeight;
    		$('.mhead_list_box').each(function () {
    			var ob = $(this).children('.mhead_list');
    			ob.css({
    				width :
    				'160px',
    			});
    			$(this).css({
    				top : top + 'px',
    				zIndex : '250'
    			});
    			var minwid = $('#menu_header').css('min-width');
    			if (minwid !=
    				'1000px') {
    				$(this).css({
    					left : (Number(minwid.replace("px", "")) + 5) + 'px',
    					/* left:'2px',*/
    					top : '25px',
    					position :
    					'fixed'
    				});
    			}
    			if ($(this).is(obj))
    				obj.toggle(800);
    			else
    				$(this).fadeOut(500);
    		});
    	});
    	$(window).bind('resize load', function
    		(event) {
    		/* console.log($(window).innerWidth());*/
    		var innerwidth = $(window).innerWidth();
    		var innerheight =
    			$(window).innerHeight();
    		var availwidth = window.screen.availWidth;
    		var availheight = window.screen.availHeight;
    		if (innerwidth
    			 & lt; 1000) {
    			$('#menuminimize span').css({
    				fontSize : '28px',
    			});
    			$('#menu_header').css({
    				height : 'auto',
    				width : '160px',
    				minWidth : '160px',
    				position : 'fixed',
    				top : '40px',
    				display : 'none',
    				border : 'solid 1px'
    			});
    			$('.mhead').each(function () {
    				$(this).css({
    					height : 'auto',
    					width : '160px',
    					display : 'table-row',
    					border : 'solid 1px',
    					borderBottom : 'solid 1px'
    				});
    			});
    		} else {
    			$('#menu_header').removeAttr('style');
    			$('.mhead').each(function () {
    				$(this).removeAttr('style');
    			});
    			$('.mhead_list_box').each(function () {
    				$(this).removeAttr('style');
    			});
    			$('#menuminimize span').css({
    				fontSize : '14px',
    			});
    			/* $('#menuminimize').hide();*/
    		}
    	});
    	$('#menuminimize span').bind('click', function () {
    		$('#menu_header').toggle(500);
    	});
    	$('#center_panel').bind('click focus', function () {
    		$('.mhead_list_box').each(function () {
    			$(this).fadeOut(600);
    		});
    	});
    });
    </script >
