<?php
class addcustomer{
	protected $parameters = array();
	function __construct($para	=	false){
		$this->parameters=$para;	
	}	 
	function returnListofPeoples(){
        $listofPeoples = NULL;
		$query = 'SELECT ph1.ver1,ad.`id` AS pk,
		                 ad.`user_name` AS name,
		                 ad.`email_id` AS email,
		                 ad.`cell_number` AS cell,
		           CASE WHEN ad.`photo_id` IS NULL
		           THEN \''.ADMIN_ANON_IMAGE.'\'
		           ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph1.`ver3`)
		           END AS photos
		           FROM `user_profile` AS ad
		           LEFT JOIN `photo` AS ph1 ON ad.`photo_id` = ph1.`id`;';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i=1;
			$listofPeoples = array();
			while($row = mysql_fetch_assoc($res)){
				$listofPeoples[$i]['pk'] = $row['pk'];
				$listofPeoples[$i]['name'] = $row['name'];
				$listofPeoples[$i]['email'] = $row['email'];
				$listofPeoples[$i]['cell'] = $row['cell'];
				$listofPeoples[$i]['photos'] = $row['photos'];
				$i++;
			}
		}
		$_SESSION['listofPeoples'] = $listofPeoples;
		     //$value["item"]=array($listofPeoples);       
         echo json_encode($listofPeoples);  
         //print_r($listofPeoples);  
        
     }
     function customer_sex() {
         $result = false;
      $i=1;
		$query='SELECT gd.* 
		        FROM `gender` as gd,
		             `status` as st 
		        WHERE gd.`status`= st.`id` AND 
		              st.`statu_name`="Show" AND st.`status`=1';
		 $result=executeQuery($query);              
         echo '<span><select name="cust_sex" id="cust_sex" class="form-control">
               <option value="NULL" id="NULL">Select sex</option>';   
     	    
      	while($row=mysql_fetch_assoc($result))
      	 {
            echo '<option value='.$row["id"].' id='.$row["name"].'_'.$row["id"].$i.'>'.$row["gender_name"].'</option>';      	 
            $i++;      	 
      	 }
      	 echo '</select></span><p class="help-block">Press enter or go button to move to next field.</p>';     
     }
}	
?>	