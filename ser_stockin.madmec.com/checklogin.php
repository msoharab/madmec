<?php
session_start();
include("lib/db.class.php");
include_once "config.php";  
$db = new DB($config['database'], $config['host'], $config['username'], $config['password']);
//$tbl_name="stock_user"; // Table name
// username and password sent from form 
if(isset($_POST) ){
    $myusername=(isset($_REQUEST['username'])) ? mysql_real_escape_string(stripslashes($_REQUEST['username'])): ''; 
    $mypassword= (isset($_REQUEST['password'])) ? mysql_real_escape_string(stripslashes($_REQUEST['password'])) : '';
    $sql="SELECT suu.*,sdel.name AS storename
    FROM stock_user suu
    LEFT JOIN store_details sdel
    ON sdel.id=suu.store_id
    WHERE suu.username='$myusername' and suu.password='$mypassword'" ;
    $result=mysql_query($sql);
    // Mysql_num_row is counting table row
    $count=mysql_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count==1){
    // Register $myusername, $mypassword and redirect to file "dashboard.php"
    $row = mysql_fetch_row($result);
    $_SESSION['id']=$row[0];
    $_SESSION['username']=$row[2];
    $_SESSION['usertype']=$row[4];
    $_SESSION['storeid']=$row[1];
    $_SESSION['storename']=$row[7];
            if($row[4] == "2")
            {

            ?>
                <script type="text/javascript">
                    window.location.href="dashboard.php";
                </script>
                <?php

            }
            else if($row[4] == "3")
            {
            $_SESSION['storeid']='';
            $_SESSION['storename']='';

                ?>
                <script type="text/javascript">
                    window.location.href="sadashboard.php";
                </script>
                <?php
            }
            else 
            {
            die("Not Valid User Type. Check with your application administartor");
            }
            unset($_POST);
        }
    else if(isset($_SESSION['username'])){
          if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "2")
            {

            ?>
                <script type="text/javascript">
                    window.location.href="dashboard.php";
                </script>
                <?php

            }
            else if(isset($_SESSION['usertype'])  && $_SESSION['usertype'] == "3")
            {
            $_SESSION['storeid']='';
            $_SESSION['storename']='';

                ?>
                <script type="text/javascript">
                    window.location.href="sadashboard.php";
                </script>
                <?php
            }
            else 
            {
                //do nothing
            }    
        
    }
    
}
else{
        header("location:index.php?msg=Login%20To%20access%20system&type=error");
 }
?>