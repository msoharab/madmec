<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12" id="allOutput">
        </div>
    </div>
</div>
<?php
if($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]=="Admin"){
	echo '<script src="<?php echo URL.ASSET_JSF; ?>control.js"></script>';
}
else{
	echo '<script src="<?php echo URL.ASSET_JSF; ?>superadmin.js"></script>';
}
?>
<script src="<?php echo URL.ASSET_JSF; ?>address.js"></script>
