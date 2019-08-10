<?php
if($_SESSION['storeid']=='')
{
    ?>
<script type="text/javascript">
    window.location.href="sadashboard.php";
</script>
<?php
}

?>
<div id="header-with-tabs">

	<div class="page-full-width cf">

		<ul id="tabs" class="fl">
                    <?php
                    if($_SESSION['usertype']==3)
                    {
                        ?>
                    <li><a href="sadashboard.php" class="home-tab">HOME</a></li>
                    <?php
                    }
                    
                    ?>
                    
			<li><a href="dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
			<li><a href="view_sales.php" class="sales-tab">Sales</a></li>
			<li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
			<li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
			<li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
			<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
			<li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
			<li><a href="view_report.php" class="report-tab">Reports</a></li>
		</ul> <!-- end tabs -->

		<!-- Change this image to your own company's logo -->
		<!-- The logo will automatically be resized to 30px height. -->
                         <?php $line = $db->queryUniqueObject("SELECT * FROM store_details WHERE `id`='".$_SESSION['storeid']."'");
		$_SESSION['logo']=$line->log; 
		 ?>
                        <!--<a href="#" id="company-branding-small" class="fr"><img src="<?php if(isset($_SESSION['logo'])) { echo "upload/".$_SESSION['logo'];}else{ echo "upload/logo.png"; } ?>" alt="MadMec" /></a>-->
                <h2 style="text-align: right;font-size: 20px">WELCOME to, <?php  echo $_SESSION['storename']  ?></h2>
	</div> <!-- end full-width -->
	</div> <!-- end header -->

