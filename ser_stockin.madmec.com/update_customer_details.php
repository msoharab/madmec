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
	<script>
/*$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});*/
$(document).ready(function() {

	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {
			name: {
				required: true,
				minlength: 3,
				maxlength: 200
			},
			address: {
				minlength: 3,
				maxlength: 500
			},
			contact1: {
				minlength: 3,
				maxlength: 20
			},
			contact2: {
				minlength: 3,
				maxlength: 20
			}
		},
		messages: {
			name: {
				required: "Please enter a Customer Name",
				minlength: "Customer must consist of at least 3 characters"
			},
			address: {
				minlength: "Customer Address must be at least 3 characters long",
				maxlength: "Customer Address must be at least 3 characters long"
			}
		}
	});

});
	</script>
</head>
<body>
	<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->

<!-- HEADER -->
<?php require_once ('./header.php'); ?>
<!-- end header -->

<!-- MAIN CONTENT -->
<div id="content">

	<div class="page-full-width cf">
			<div class="side-menu fl">
	
			<h3>Customers Management</h3>
			<ul>
				<li><a href="add_customer.php">Add Customer</a></li>
				<li><a href="view_customers.php">View Customers</a></li>
			</ul>
	
		</div> <!-- end side-menu -->

		<div class="side-content fr">

			<div class="content-module">
	
				<div class="content-module-heading cf">
		
					<h3 class="fl">Add Customer</h3>
					<span class="fr expand-collapse-text">Click to collapse</span>
					<span class="fr expand-collapse-text initial-expand">Click to expand</span>
		
				</div> <!-- end content-module-heading -->
		
					<div class="content-module-main cf">
			<form name="form1" method="post" id="form1" action="">
                  <p><strong>Add Customer Details </strong> - Add New ( Control +A)</p>
                  <table class="form"  border="0" cellspacing="0" cellpadding="0">
			  <?php
			if(isset($_POST['id']))
            {

		$id=mysql_real_escape_string($_POST['id']);
		$name=trim(mysql_real_escape_string($_POST['name']));
		$address=trim(mysql_real_escape_string($_POST['address']));
		$contact1=trim(mysql_real_escape_string($_POST['contact1']));
		$contact2=trim(mysql_real_escape_string($_POST['contact2']));


	
		if($db->query("UPDATE customer_details  SET customer_name='$name',customer_address='$address',customer_contact1='$contact1',customer_contact2='$contact2' where id=$id AND store_id=$ttstoreid"))
		{
                        $data=" $name  Customer Details Updated" ;
			$msg='<p style=color:#153450;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
                                            ?>
                                                    
 <script  src="dist/js/jquery.ui.draggable.js"></script>
<script src="dist/js/jquery.alerts.js"></script>
<script src="dist/js/jquery.js"></script>
<link rel="stylesheet"  href="dist/js/jquery.alerts.css" >
                                                  
                                            <script type="text/javascript">

				jAlert('<?php echo  $msg; ?>');
		
</script>
                                                        <?php
                        }
		else
		echo "<br><font color=red size=+1 >Problem in Updation !</font>" ;


		}
	
			?>
			<?php 
			if(isset($_GET['sid']))
			$id=$_GET['sid'];

			$line = $db->queryUniqueObject("SELECT * FROM customer_details WHERE id=$id AND store_id=$ttstoreid");
			?>
				<form name="form1" method="post" id="form1" action="">
                   <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">  
                    <tr>
				<td>Name</td>
                      <td><input name="name" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->customer_name; ?> "/></td>
                    <td>Contact 1 </td>
                      <td><input name="contact1"  type="text" id="buyingrate" maxlength="20"   class="round default-width-input" 
				  value="<?php echo $line->customer_contact1; ?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td><textarea name="address"  cols="15" class="round full-width-textarea"><?php echo $line->customer_address; ?>
				  </textarea></td>
                   
                     <td>Contact 2 </td>
                      <td><input name="contact2"  type="text" id="sellingrate" maxlength="20"  class="round default-width-input" 
				  value="<?php echo $line->customer_contact2; ?>" /></td>
                    </tr>
                 
                   
                    <tr>
                      <td>
				 &nbsp;
				  </td>
                      <td>
                        <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
					(Control + S)</td>
			  <td align="right"><input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td>	
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