<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12" id="output">
		</div>
	</div>
</div>
<?php
	if($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]=="Admin"){
?>
<script src="<?php echo URL.ASSET_JSF; ?>control.js"></script>
<?php
}
else{
?>
<script src="<?php echo URL.ASSET_JSF; ?>admincontrol.js"></script>
<?php
}
?>
<script src="<?php echo URL.ASSET_JSF; ?>address.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>PhotoUpload.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>user.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>collection.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>payment.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>purchase.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>dues.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>admincollection.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>profile.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>order.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>notify.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>client.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>admindue.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>adminfollowup.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>billlist.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>sale.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>alert.js"></script>
<script src="<?php echo URL.ASSET_JSF; ?>setting.js"></script>