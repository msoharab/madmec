<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12" id="output">
		</div>
	</div>
</div>

<script src="<?php echo URL.ASSET_JSF; ?>address.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>PhotoUpload.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>user.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>requirement.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>quotation.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>cpo.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>projectplan.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>pcc.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>drawing.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>invoice.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>report.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>drawing.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>stock.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>mo.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>incomming.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>outgoing.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>pettycash.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>due.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>followup.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>setting.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>userprofile.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>admincollection.js" type="text/javascript"></script>
<script src="<?php echo URL.ASSET_JSF; ?>client.js" type="text/javascript"></script>
<script src="<?php echo URL.ASSET_JSF; ?>order.js" type="text/javascript"></script>
<script src="<?php echo URL.ASSET_JSF; ?>notify.js" type="text/javascript"></script>
<script src="<?php echo URL.ASSET_JSF; ?>admindue.js" type="text/javascript"></script>
<script src="<?php echo URL.ASSET_JSF; ?>adminfollowup.js" type="text/javascript"></script>
    <?php if($_SESSION["USER_LOGIN_DATA"]['user_type_id']=="9")
{ ?>
<script src="<?php echo URL.ASSET_JSF; ?>control.js"></script>
<?php 
}
else
{
    ?>
<script src="<?php echo URL.ASSET_JSF; ?>admincontrol.js" type="text/javascript"></script>
<?php
}
?>