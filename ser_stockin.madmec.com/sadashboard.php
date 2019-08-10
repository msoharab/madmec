<?php
include_once("init.php");
if($_SESSION['usertype']!= "3")
{
    header("Location:dashboard.php");
}
$_SESSION['storeid']='';
$_SESSION['storename']='';

    
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
<script src="js/lib/jquery.min.js"></script>
</head>
<body>


<!-- MAIN CONTENT -->
<div id="content">
    <br/><br/><br/>
    <div class="side-content1 fr">

			<div class="content-module">
                              <div class="content-module-heading cf">
		
					<h3 class="fl">Please select the Store</h3>
					<span class="fr expand-collapse-text">Click to collapse</span>
				</div>
                            <br/>
                            <div class="content-module-main cf">
                                <div style="position:absolute;border:  dashed #003399 2px; margin-left: 8%; margin-right: 10%; margin-top:15px; margin-bottom: 10px;width: 80%; height: auto; padding: 15px   15px  15px  15px; float:none; min-width: 135px;">
                             <?php
                              $sql="SELECT * FROM store_details";
                              $result=  mysql_query($sql);
                              if(mysql_num_rows($result))
                              {
                                  while ($row = mysql_fetch_array($result)) {
                                     ?>
                            <div class="content-module-main cf hovstor" style="border-radius: 50%;border:1px #003399 solid; float:left; width:175px; height:140px; background-color: #AA99DE; color:#665F6F6;font-weight: bold;margin:1%; word-break: break-all; cursor: pointer; box-shadow: #AA99DE 2px 3px 4px 5px;" align="center" onclick="window.location.href='selectstore.php?storeid=<?php echo $row['id'].','.$row['name'] ?>';">
                                <h1 style="padding:12px;  text-align: center;"> <?php echo $row['name'].'<hr style="opacity:0.2; padding:4px;" />'.$row['address']; ?></h1>
                            </div>
                            <?php
                                  }  
                              }
                              
                              ?>
                                </div>
                            </div>
                              
                            
                        </div>
    </div>
	
            </div>
        <div>
     
        </div>

<!-- FOOTER -->
<div id="footer">
</div> <!-- end footer -->
</body>
<script>
    $(document).ready(function(){
        $('.hovstor').bind('mouseenter',function(){
            console.log('hi');
            $(this).css('opacity','0.5');
        });
        $('.hovstor').bind('mouseleave',function(){
            $(this).css('opacity','1');
        });
    });
 </script>
</html>