<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Club/Gym Management system.</title>
        
        <script src="<?php echo URL.ASSET_JSF; ?>jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php echo URL.ASSET_JSF; ?>script.js" type="text/javascript"></script>
        <link href="<?php echo URL.ASSET_CSS; ?>style.css" rel="stylesheet" type="text/css"/>
    </head>
	<body id="body" >
    	<div id="header_panel">
        	<div id="content">
  
                <div id="option" >
                    <table>
                        <tr>
                        	<td width="570">
                            	<img src="assets/images/madmec_logo.png">
                            </td>
                            <td>
                                <div class="box" onClick="javascript:to_home();">
                                    <a href="index.php">HOME</a>
                                </div>
                            </td>
                            <td>|</td>
                            <td>
                                <div class="box" onClick="javascript:to_booking();">
                                    <a href="customers.php">OUR CUSTOMER</a>
                                </div>
                            </td>
                            <td>|</td>
                            <td>
                                <div class="box" onClick="javascript:to_gallery();">
                                    <a href="prizing.php" >PRIZING</a>
                                </div>
                            </td>
                            <td>|</td>
                            <td>
                                <div class="box" onClick="javascript:to_services();">
                                    <a href="help.php">HELP DESK</a>
                                </div>
                            </td>
                            <!--<td>|</td>
                            
                            <td>
                                <div class="box" onClick="javascript:to_contact();">
                                    <a href="javascript:void(0);">CONTACT US</a>
                                </div>
                            </td>-->
                        </tr>
                    </table>
                </div>
            </div>
        </div>