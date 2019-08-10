<?php
$temp = rtrim($_SERVER['DOCUMENT_ROOT'], "/");
$temp = explode("/", $temp);
$config_root = str_replace($temp[count($temp) - 1], "library/" . $temp[count($temp) - 1], $_SERVER['DOCUMENT_ROOT']) . "/";
define("CONFIG_ROOT", $config_root);
define("MODULE_1", "database.php");
define("MODULE_USER", "user.php");
define("MODULE_PRODUCT", "product.php");
define("MODULE_SALE", "sale.php");
define("MODULE_PURCHASE", "purchase.php");
define("MODULE_COLLECTION", "collection.php");
define("MODULE_PAYMENT", "payment.php");
define("MODULE_DUES", "dues.php");
define("MODULE_CRM", "crm.php");
define("MODULE_PROFILE", "profile.php");
define("MODULE_CLIENT", "client.php");
define("MODULE_ADMINCOLLECTION", "admincollection.php");
define("MODULE_ADMINDUE", "dueadmin.php");
define("MODULE_ADMINFOLLOWUP", "duefallowup.php");
define("MODULE_ORDER", "order.php");
define("MODULE_ALERT", "alerts.php");
define("MODULE_SETTING", "setting.php");
function GetImageExtension($imagetype)
	     {
	       if(empty($imagetype)) return false;
	       switch($imagetype)
	       {
	           case 'image/bmp': return '.bmp';
	           case 'image/gif': return '.gif';
	           case 'image/jpeg': return '.jpg';
	           case 'image/png': return '.png';
	           default: return false;
	       }
	    }
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
?>
