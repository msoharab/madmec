<?php
class payment{
	protected $parameters = array();
	function __construct($para	=	false){
		$this->parameters=$para;	
	}	 
	function LoadModeOfPayment(){
      $result = false;
      $i=1;
		$query='SELECT mop.* 
		        FROM `mode_of_payment` as mop,
		             `status` as st 
		        WHERE mop.`status`= st.`id` AND 
		              st.`statu_name`="Show" AND st.`status`=1';
		$result=executeQuery($query);              
         echo '<select name="mod_pay" id="mod_pay_select_01" class="form-control">
               <option value="NULL" id="NULL">Select mode of payment</option>';   
     	    
      	while($row=mysql_fetch_assoc($result))
      	 {
            echo '<option value='.$row["id"].' id='.$row["name"].'_'.$row["id"].$i.'>'.$row["name"].'</option>';      	 
            $i++;      	 
      	 }
      	 echo '</select>';
	}
}	
?>	