<?php
include_once("init.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Stock Management System</title>

<!-- Stylesheets -->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
<link rel="stylesheet" href="css/style.css">

<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- jQuery & JS files -->
<?php include_once("tpl/common_js.php"); ?>
<script src="js/script.js"></script>  
</head>
<body>
	<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->
<?php include_once("analyticstracking.php") ?>
	<!-- HEADER -->
<?php include_once("./header.php") ?>

<!-- MAIN CONTENT -->
<div id="content">

	<div class="page-full-width cf">
			<div class="side-menu fl">
	
			<h3>Quick Links</h3>
			<ul>
				<li><a href="add_sales.php">Add Sales</a></li>
				<li><a href="add_purchase.php">Add Purchase</a></li>
				<li><a href="add_supplier.php">Add Supplier</a></li>
				<li><a href="add_customer.php">Add Customer</a></li>
				<li><a href="view_report.php">Report</a></li>
			</ul>
                                
                                 
		</div> <!-- end side-menu -->
                        
		<div class="side-content fr">

			<div class="content-module">
	
				<div class="content-module-heading cf">
		
					<h3 class="fl">Statistics</h3>
					<span class="fr expand-collapse-text">Click to collapse</span>
					<span class="fr expand-collapse-text initial-expand">Click to expand</span>
		
				</div> <!-- end content-module-heading -->
		
					<div class="content-module-main cf">
	
				
							<table style="width:350px; float:left;" border="0" cellpadding="0" cellspacing="0">
							  <tr>
								<td width="250" align="left">&nbsp;</td>
								<td width="150" align="left">&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">Total Number of Products</td>
								<td align="left"><?php echo  $count = $db->countOfAll("stock_avail");?>&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">&nbsp;</td>
								<td align="left">&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">Total Sales Transactions </td>
								<td align="left"><?php echo  $count = $db->countOfAll("stock_sales");?></td>
							  </tr>
							  <tr>
								<td align="left">&nbsp;</td>
								<td align="left">&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">Total number of Suppliers </td>
								<td align="left"><?php echo $count = $db->countOfAll("supplier_details");?></td>
							  </tr>
							  <tr>
								<td align="left">&nbsp;</td>
								<td align="left">&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">Total Number of Customers </td>
								<td align="left"><?php echo $count = $db->countOfAll("customer_details");?></td>
							  </tr>
							  <tr>
								<td align="left">&nbsp;</td>
								<td align="left">&nbsp;</td>
							  </tr>
							  <tr>
								<td align="left">&nbsp;</td>
								<td align="left">&nbsp;</td>
							  </tr>
					  </table>
	
			<table style="width:600px; margin-left:50px; float:left;" border="0" cellspacing="0" cellpadding="0">
			  <tr>
                                      <td>&nbsp;</td>
				<td width="250" align="left">Home (Ctrl+0) </td>
				<td width="150" align="left">Add Purchase(Ctrl+1)</td>
			
                                        
			  </tr>
			  <tr><td>&nbsp;</td>
                                      	<td width="250" align="left">Add Stock(Ctrl+2)</td>
				<td align="left">Add Sale(Ctrl+3)</td>
		
			  </tr>
			  <tr><td>&nbsp;</td>
                                      	<td align="left">Add Category (Ctrl+4 ) </td>
				<td align="left">Add Supplier (Ctrl+5 )</td>
		
			  </tr>
			  <tr><td>&nbsp;</td>
				<td align="left">Add Customer (Ctrl+6)</td>
				<td align="left">View Stocks (Ctrl+7)</td>
		
			  </tr>
			  <tr><td>&nbsp;</td>
                                      <td align="left">View Sales(Ctrl+8)</td>
				<td align="left">View Purchase (Ctrl+9) </td>
		
			  </tr>
			  <tr><td>&nbsp;</td>
                                      <td align="left">Add New (Ctrl+a)</td>
				<td align="left">Save( Ctrl+s ) </td>
		
			  </tr>
	
			</table>
					<!--<ul class="temporary-button-showcase">
						<li><a href="#" class="button round blue image-right ic-add text-upper">Add</a></li>
						<li><a href="#" class="button round blue image-right ic-edit text-upper">Edit</a></li>
						<li><a href="#" class="button round blue image-right ic-delete text-upper">Delete</a></li>
						<li><a href="#" class="button round blue image-right ic-download text-upper">Download</a></li>
						<li><a href="#" class="button round blue image-right ic-upload text-upper">Upload</a></li>
						<li><a href="#" class="button round blue image-right ic-favorite text-upper">Favorite</a></li>
						<li><a href="#" class="button round blue image-right ic-print text-upper">Print</a></li>
						<li><a href="#" class="button round blue image-right ic-refresh text-upper">Refresh</a></li>
						<li><a href="#" class="button round blue image-right ic-search text-upper">Search</a></li>
					</ul>-->
	
				</div> <!-- end content-module-main -->
			
			</div> <!-- end content-module -->
	
		    

	</div> <!-- end full-width -->
		
                </div>
            </div>
        <div>
     
        </div>

<!-- FOOTER -->
<div id="footer">
</div> <!-- end footer -->
</body>
</html>