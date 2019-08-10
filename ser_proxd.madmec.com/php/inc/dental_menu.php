<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
?>
<li>
	<a id="pat_nav" href="<?php echo URL.PHP.DENTAL; ?>patient.php">
            <img src="<?php echo URL.ASSET_IMG.'icon_group.png';?>" height="50" width="50"/> Patient 
        </a>
</li>
<li>
	<a id="app_nav" href="<?php echo URL.PHP.DENTAL; ?>appointment.php">
            <img src="<?php echo URL.ASSET_IMG.'appointment.png';?>" height="50" width="50"/> Appointment 
        </a>
</li>
                    