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
         <link rel="stylesheet" href="js/date_pic/date_input.css">

<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- jQuery & JS files -->
<?php include_once("tpl/common_js.php"); ?>
         <script src="js/date_pic/jquery.date_input.js"></script>  
<script src="js/script.js"></script>  
	<script>
/*$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});*/
$(document).ready(function() {
$('#test1').jdPicker();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {
			name: {
				required: true,
				minlength: 3,
				maxlength: 200
			},
	
			cost: {
                                        required: true
		
			},
			new_payment: {
                                        required: true
		
			},
			sell: {
                                        required: true
		
			}
		},
		messages: {
			name: {
				required: "Please enter a Stock Name",
				minlength: "Stock must consist of at least 3 characters"
			},
			cost: {
				required: "Please enter a cost Price"
			},
			new_payment: {
				required: "Please enter a New Payment Amount"
			},
			sell: {
				required: "Please enter a Sell Price"
			}
		}
	});

});
function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
        return false
    }
    }
    function change_balance(){
        if(parseFloat(document.getElementById('new_payment').value) > parseFloat(document.getElementById('balance').value)){
            document.getElementById('new_payment').value=parseFloat(document.getElementById('balance').value);
        }
    }
</script>
</head>
<body>
	<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->

<!-- HEADER -->
<div id="header-with-tabs">

	<div class="page-full-width cf">

		<ul id="tabs" class="fl">
                                <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
			<li><a href="view_sales.php" class="sales-tab">Sales</a></li>
			<li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
			<li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
			<li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
			<li><a href="view_product.php" class="stock-tab">Stocks / Products</a></li>
			<li><a href="view_payments.php" class="active-tab payment-tab">Payments / Outstandings</a></li>
			<li><a href="view_report.php" class="report-tab">Reports</a></li>
		</ul> <!-- end tabs -->

		<!-- Change this image to your own company's logo -->
		<!-- The logo will automatically be resized to 30px height. -->
		<a href="#" id="company-branding-small" class="fr"><img src="<?php if(isset($_SESSION['logo'])) { echo "upload/".$_SESSION['logo'];}else{ echo "upload/logo.png"; } ?>" alt="MadMec" /></a>

	</div> <!-- end full-width -->
	</div> <!-- end header -->

<!-- MAIN CONTENT -->
<div id="content">

	<div class="page-full-width cf">
			<div class="side-menu fl">
	
			<h3>Payment</h3>
			<ul>
				<li><a href="view_payments.php">Payments</a></li>
				<li><a href="view_out_standing.php">Out standings</a></li>                                      
			</ul>
                        </div>                                                               
                    <!-- end side-menu -->

		<div class="side-content fr">

			<div class="content-module">
	
				<div class="content-module-heading cf">
		
					<h3 class="fl">Update Payment</h3>
					<span class="fr expand-collapse-text">Click to collapse</span>
					<span class="fr expand-collapse-text initial-expand">Click to expand</span>
		
				</div> <!-- end content-module-heading -->
		
					<div class="content-module-main cf">
			<form name="form1" method="post" id="form1" action="">
                
                  <table class="form"  border="0" cellspacing="0" cellpadding="0">
			  <?php
			if(isset($_POST['id']) and isset($_POST['new_payment'])){
$id=mysql_real_escape_string($_POST['id']);
		$balance=mysql_real_escape_string($_POST['balance']);
		$payment=mysql_real_escape_string($_POST['paid']);
		$customer=mysql_real_escape_string($_POST['customer']);
		$subtotal=mysql_real_escape_string($_POST['total']);
		$newpayment=mysql_real_escape_string($_POST['new_payment']);
                        if($newpayment==""){
                        $newpayment=00;
                        }
		$selected_date=$_POST['date'];
	  	$selected_date=strtotime( $selected_date );
		$mysqldate = date( 'Y-m-d', $selected_date );
		$due=$mysqldate;
		$balance= (int) $balance - (int) $newpayment;
		$payment= (int) $payment + (int) $newpayment;
		$max = $db->maxOfAll("id", "transactions");
		$receiptid="RCPT".$max;
		if($db->query("UPDATE stock_sales SET balance=$balance,payment=$payment,due='$due' where transactionid='$id'"))
		{
		$db->query("INSERT INTO transactions(type,customer,payment,balance,rid,due,subtotal,receiptid) values('sales','$customer',$newpayment,$balance,'$id','$due',$subtotal,'$receiptid')");
		$max = $db->maxOfAll("id", "transactions");
		
                         $data=" $id  Customer Details Updated" ;
			                                            $msg='<p style=color:#153450;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
                                            ?>
                                                    
 <script  src="dist/js/jquery.ui.draggable.js"></script>
<script src="dist/js/jquery.alerts.js"></script>
<script src="dist/js/jquery.js"></script>
<link rel="stylesheet"  href="dist/js/jquery.alerts.css" >
                                                  
                                            <script type="text/javascript">

				jAlert('<?php echo  $msg; ?>', 'MADMEC');
		
</script>
                                                        <?php
		echo "<script>window.open('payment_receipt_print.php?sid=$max','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
		}
		else
		echo "<br><font color=red size=+1 >Problem in Updation !</font>" ;


		}
	
			?>
			<?php 
			if(isset($_GET['sid']))
			$id=$_GET['sid'];

			$line = $db->queryUniqueObject("SELECT * FROM stock_sales WHERE transactionid='$id'");
			?>
	<form name="form1" method="post" id="form1" action="">
                    
                   <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">  
                   <tr><td>&nbsp;</td>
                       <td>Sales ID</td>
                       <td><input name="stock_id" type="text" readonly="readonly" readonly="readonly" id="stockid" maxlength="200"  class="round default-width-input" value="<?php echo $line->transactionid ; ?> "/>
                      </td>
                   <td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td>
				<td>Customer</td>
                      <td><input name="customer" type="text" id="customer" maxlength="200" readonly="readonly" class="round default-width-input" value="<?php echo $line->customer_id  ; ?> "/></td>
                   <td>Total </td>
                      <td><input name="total"  type="text" id="tatal" maxlength="20" readonly="readonly"  class="round default-width-input" 
				  value="<?php echo $line->subtotal ; ?>" /></td>
                    </tr>
                    
                    <tr><td>&nbsp;</td>
                             <td>Paid </td>
                      <td><input name="paid"  type="text" id="paid" maxlength="20" readonly="readonly"  class="round default-width-input" 
                                 value="<?php echo $line->payment ; ?>" onkeypress="return numbersonly(event)" /></td>
                    <td>Balance </td>
                    <td><input name="balance"  type="text" id="balance" readonly="readonly" maxlength="20"  class="round default-width-input" 
                                 value="<?php echo $line->balance ; ?>" onkeypress="return numbersonly(event)" /></td>
                    </tr>
                    <tr>
                        <td></td>
                             <td>New Date </td>
                      <td><input name="date"  type="text" id="test1" maxlength="20"  class="round default-width-input" 
                                 value="<?php echo date("Y/m/d") ?>" /></td>
                    <td>New Payment </td>
                    <td><input name="new_payment" id="new_payment" type="text"  onkeypress="return numbersonly(event)"  maxlength="20" onkeyup="change_balance()" class="round default-width-input" 
				 /></td>
                    </tr>
                   
                      
                    </tr>
                   
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                        <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
					(Control + S)</td>
                        <td align="right"><input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> 
                        </td>
		<td>&nbsp;</td>		
                    </tr>
                  </table>
                </form>
		
				</div> <!-- end content-module-main -->
			
			</div> <!-- end content-module -->


	</div> <!-- end full-width -->

</div> <!-- end content -->

<!-- FOOTER -->
<div id="footer">
	<!--<p>Any Queries email to <a href="mailto:info@madmec.com?subject=Stock%20Management%20System">info@madmec.com</a>.</p>-->

</div> <!-- end footer -->
</body>
</html>