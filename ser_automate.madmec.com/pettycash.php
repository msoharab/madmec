<?php
class pettycash {
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function addpettycash()
                {
                        executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
                        $query="SELECT `availablecash` FROM `pettycash` where id=1";
                        $availdata=  executeQuery($query);
                        $row=  mysql_fetch_assoc($availdata);
                        $avalbal=$row['availablecash']+mysql_real_escape_string($this->parameters["pettyamount"]);
			$query = 'INSERT INTO  `pettycash_deposit` (`id`,
							`pcash`,
							`doa`,
							`remark`,
                                                        `Avaliablebal`,
							`status_id` )  VALUES(
						NULL,
						\''.mysql_real_escape_string($this->parameters["pettyamount"]).'\',
                                                    CURRENT_TIMESTAMP,
						\''.mysql_real_escape_string($this->parameters["pettyremark"]).'\',
                                                  \''.$avalbal.'\',  
						4);';
			if(executeQuery($query)){
                        $query='UPDATE `pettycash` SET `availablecash` = `availablecash` + '.mysql_real_escape_string($this->parameters["pettyamount"]);
                        if(executeQuery($query))
                            {
                        executeQuery("COMMIT");
                            }
			}
                       
                    
                }
                public function fetchpettycashhistory()
                {
                    $paymenthistory=array();
                    $query='SELECT 
                        pcash,doa,remark,
                        Avaliablebalance,
                        trans_type
                        FROM 
                        ( 
                        SELECT 
                        `pcash`, 
                        `doa`,
                        `remark`,
                        `Avaliablebal` Avaliablebalance,
                        "deposite" AS trans_type 
                         FROM 
                        `pettycash_deposit` a 
                        UNION ALL  
                        SELECT  
                        `wcash` AS pcash,
                        `dow` AS timee, 
                        (SELECT `user_name` FROM `user_profile` WHERE `id`=`user_pk`) AS remark,
                        `Avaliablebal` AS Avaliablebalance,
                        "withdraw" AS trans_type  
                        FROM  
                        `pettycash_withdraw` b  
                            ) t1 ORDER BY doa DESC';
                    $tddata='';
                    $res=  executeQuery($query);
                        if(mysql_num_rows($res)>0)
                              {
                            while($row = mysql_fetch_assoc($res))
                                {
                            $paymenthistory[] = $row;
				}
                                   
                                   }
                        if(is_array($paymenthistory))
                        $num = sizeof($paymenthistory);
                        if($num){
                        $j=1;
                        for($i=0;$i<$num;$i++){
                       $tddata .='<tr><td>'.$j.'</td><td>'.$paymenthistory[$i]["doa"].'</td><td>'.$paymenthistory[$i]["pcash"].'</td><td>'.$paymenthistory[$i]["trans_type"].'</td><td>'.$paymenthistory[$i]["Avaliablebalance"].'</td><td>'.$paymenthistory[$i]["remark"].'</td></tr>';
                          ++$j;  
                        }
                        $header='<div class="panel panel-warning">
                                <div class="panel-heading"> <strong>Petty Cash History</strong>&nbsp; </div>
                                <div class="panel-body"> <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-pettycash">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date_Time</th>
                                            <th>Amount</th>
                                            <th>Txn Type</th>
                                            <th>Avaliable Balance</th>
                                            <th>Remark/Payee</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        $footer='</tbody></table></div></div></div>';
                        return $header.$tddata.$footer;
                        }
                    
                    
                            
                    
                }
   
    }
