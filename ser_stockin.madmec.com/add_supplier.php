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
        <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- jQuery & JS files -->
<?php include_once("tpl/common_js.php"); ?>
<script src="js/script.js"></script>  
        <script src="js/date_pic/jquery.date_input.js"></script>  
        <script src="lib/auto/js/jquery.autocomplete.js "></script>  
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
				required: "Please enter a supplier Name",
				minlength: "Supplier must consist of at least 3 characters"
			},
			address: {
				minlength: "Supplier Address must be at least 3 characters long",
				maxlength: "Supplier Address must be at least 3 characters long"
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
	
			<h3>supplier Management</h3>
			<ul>
				<li><a href="add_supplier.php">Add Supplier</a></li>
				<li><a href="view_supplier.php">View Supplier</a></li>
			</ul>
			                                                     
		</div> <!-- end side-menu -->

		<div class="side-content fr">

			<div class="content-module">
	
				<div class="content-module-heading cf">
		
					<h3 class="fl">Add supplier</h3>
					<span class="fr expand-collapse-text">Click to collapse</span>
					<span class="fr expand-collapse-text initial-expand">Click to expand</span>
		
				</div> <!-- end content-module-heading -->
		
					<div class="content-module-main cf">
	
				
				<?php
				//Gump is libarary for Validatoin
		
				if(isset($_POST['name'])){
				$_POST = $gump->sanitize($_POST);
				$gump->validation_rules(array(
					'name'    	  => 'required|max_len,100|min_len,3',
					'address'     => 'max_len,200',
					'contact1'    => 'alpha_numeric|max_len,20',
					'contact2'    => 'alpha_numeric|max_len,20'
				));
	
				$gump->filter_rules(array(
					'name'    	  => 'trim|sanitize_string|mysql_escape',
					'address'     => 'trim|sanitize_string|mysql_escape',
					'contact1'    => 'trim|sanitize_string|mysql_escape',
					'contact2'    => 'trim|sanitize_string|mysql_escape'
				));
	
				$validated_data = $gump->run($_POST);
				$name 		= "";
				$address 	= "";
				$contact1	= "";
				$contact2 	= "";		
					if($validated_data === false) {
						echo $gump->get_readable_errors(true);
				} else {
			
			
						$name=mysql_real_escape_string($_POST['name']);
						$address=mysql_real_escape_string($_POST['address']);
						$contact1=mysql_real_escape_string($_POST['contact1']);
						$contact2=mysql_real_escape_string($_POST['contact2']);
			
					$count = $db->countOf("supplier_details", "supplier_name='$name'");
	if($count==1)
		{
                                     $data='Dublicat Entry. Please Verify';
                                            $msg='<p style=color:red;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
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
		{
	
		if($db->query("insert into supplier_details values(NULL,'$name','$address','$contact1','$contact2',0,$ttstoreid,4)"))
		{
                         $msg="$name  Supplier Details Added" ;
                         ?>
                         <script type="text/javascript">
                        window.location.href="add_supplier.php?msg=<?php echo $msg?>";
                        </script>
                      <?php  }
		else
		echo "<br><font color=red size=+1 >Problem in Adding !</font>" ;

		}


		}
				
						}
			
			//Gump is libarary for Validatoin
                                         if(isset($_GET['msg'])){
                                             $data=$_GET['msg'];
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
                                         }
			?>
	
<form name="form1" method="post" id="form1" action="" autocomplete="off">
                  
                  <p><strong>Add Supplier Details </strong> - Add New ( Control +u)</p>
                  <table class="form"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="man">*</span>Name:</td>
                      <td><input name="name"placeholder="ENTER YOUR FULL NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $name; ?>" /></td>
                       <td>Contact 1 </td>
                      <td><input name="contact1" placeholder="ENTER YOUR ADDRESS contact1"type="text" id="buyingrate" maxlength="20"   class="round default-width-input" 
				  value="<?php echo $contact1; ?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td><textarea name="address" placeholder="ENTER YOUR ADDRESS"cols="8" class="round full-width-textarea"><?php echo $address; ?></textarea></td>
                        <td>Contact 2 </td>
                      <td><input name="contact2"placeholder="ENTER YOUR contact2" type="text" id="sellingrate" maxlength="20"  class="round default-width-input" 
				  value="<?php echo $contact2; ?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                    
                    <tr>
                      <td>
				 &nbsp;
				  </td>
                      <td>
                        <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
					(Control + S)
				  
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