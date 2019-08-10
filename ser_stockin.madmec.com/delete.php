<?php
include_once "init.php"; 
// Use session variable on this page. This function must put on the top of page.
if(!isset($_SESSION['username']) || $_SESSION['usertype'] !='admin'){ // if session variable "username" does not exist.
header("location:index.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to index.php
}
else
{

	error_reporting (E_ALL ^ E_NOTICE);
	if(isset($_REQUEST['id']) && isset($_REQUEST['table']))
	{
	echo $id=$_REQUEST['id'];
	$tablename=$_REQUEST['table'];
	$return=$_REQUEST['return'];

	if($tablename=="stock_entries")
	{	
				$difference=$db->queryUniqueValue("SELECT quantity FROM stock_entries WHERE id=$id AND store_id=$ttstoreid");
		
				$name=$db->queryUniqueValue("SELECT stock_name FROM stock_entries WHERE id=$id AND store_id=$ttstoreid");
				$result=$db->query("SELECT * FROM stock_entries where id > $id AND store_id=$ttstoreid");
				while ($line2 = $db->fetchNextObject($result)) {
				$osd=$line2->opening_stock - $difference;
				$csd=$line2->closing_stock - $difference;
				$cid=$line2->id;
				$db->execute("UPDATE stock_entries SET opening_stock=".$osd.",closing_stock=".$csd." WHERE id=$cid AND store_id=$ttstoreid");
 			
				}
				$total = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name' AND store_id=$ttstoreid");
				$total = $total - $difference;
				$db->execute("UPDATE stock_avail SET quantity=$total WHERE name='$name' AND store_id=$ttstoreid");
	}
	if($tablename=="stock_sales")
	{			$difference=$db->queryUniqueValue("SELECT quantity FROM stock_sales WHERE id=$id AND store_id=$ttstoreid");
				$sid=$db->queryUniqueValue("SELECT transactionid FROM stock_sales WHERE id=$id AND store_id=$ttstoreid");
				$id=$db->queryUniqueValue("SELECT id FROM stock_entries WHERE salesid='$sid' AND store_id=$ttstoreid");
				$name=$db->queryUniqueValue("SELECT stock_name FROM stock_entries WHERE id=$id AND store_id=$ttstoreid");
				$result=$db->query("SELECT * FROM stock_entries where id > $id AND store_id=$ttstoreid");
				while ($line2 = $db->fetchNextObject($result)) {
				$osd=$line2->opening_stock + $difference;
				$csd=$line2->closing_stock + $difference;
				$cid=$line2->id;
				$db->execute("UPDATE stock_entries SET opening_stock=".$osd.",closing_stock=".$csd." WHERE id=$cid AND store_id=$ttstoreid");
 			
				}
				echo "sale $name";
				$total = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name' AND store_id=$ttstoreid");
				$total = $total + $difference;
				$db->execute("UPDATE stock_avail SET quantity=$total WHERE name='$name' AND store_id=$ttstoreid");
				$db->execute("DELETE FROM $tablename WHERE id=$id AND store_id=$ttstoreid");
	}
	$id=$_REQUEST['id'];

	$db->execute("DELETE FROM $tablename WHERE id=$id AND store_id=$ttstoreid");

	header("location:$return?msg=Record Deleted Successfully!&id=$id");
	}
	if(isset($_REQUEST['table']) && isset($_REQUEST['checklist']))
	{
            $data=$_REQUEST['checklist'];
            $tablename=$_POST['table'];
            $return =$_REQUEST['return'];
           for($i=0;$i<count($data);$i++){
              $db->execute("DELETE FROM $tablename WHERE id=$data[$i] AND store_id=$ttstoreid"); 
           }
	header("location:$return?msg=Record Deleted Successfully!");
}
echo $_REQUEST['return'];
if(isset($_REQUEST['return'])){
    header("location:$return");
}
}
?>