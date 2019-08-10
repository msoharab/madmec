<?php
class  adminfollowup
{
   protected $parameters = array();
		function __construct($parameters = false) {
			$this->parameters = $parameters;
                        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
                        selectDB(DBNAME_MASTER,$link);
		} 
                public function FetchCurrentFollowUp() {
                
                    $followdata=array();
                    $data='';
                    $query='SELECT 
                            foll.followup_date,
                            dd.due_amount,
                            up.owner_name,
                            up.business_name,
                            up.user_name,
                            up.cell_code,
                            up.cell_number,
                            up.email
                            FROM follow_ups foll
                            LEFT JOIN due dd
                            ON dd.id=foll.due_id
                            LEFT JOIN user_profile up
                            ON up.id=dd.user_pk
                            WHERE foll.status_id=4 AND dd.status_id=4
                            AND foll.followup_date=CURRENT_DATE';  
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while ($row = mysql_fetch_assoc($result)) {
                          $followdata[]=$row;  
                        }
                        $m=1;
                        for($i=0;$i<sizeof($followdata);$i++)
                        {
                            $data .='<tr><td>'.$m++.'</td><td>'.$followdata[$i]['business_name'].'</td><td>'.$followdata[$i]['owner_name'].'</td><td>'.$followdata[$i]['user_name'].'</td><td>'.$followdata[$i]['cell_code'].' - '.$followdata[$i]['cell_number'].'</td>'
                                    . '<td>'.$followdata[$i]['email'].'</td><td>'.$followdata[$i]['followup_date'].'</td><td>'.$followdata[$i]['due_amount'].'</td>';
                        }
                        $jsondata=array(
                            "status" => "success",
                            "data"  => $data,
                        ); 
                        return $jsondata;
                    }
                    else
                    {
                        $jsondata=array(
                            "status" => "failure",
                            "data"  => NULL,
                        ); 
                        return $jsondata;
                    }
                }  
                public function FetchPendingFollowUp() {
                   $followdata=array();
                    $data='';
                    $query='SELECT 
                            foll.followup_date,
                            dd.due_amount,
                            up.owner_name,
                            up.business_name,
                            up.user_name,
                            up.cell_code,
                            up.cell_number,
                            up.email
                            FROM follow_ups foll
                            LEFT JOIN due dd
                            ON dd.id=foll.due_id
                            LEFT JOIN user_profile up
                            ON up.id=dd.user_pk
                            WHERE foll.status_id=4 AND dd.status_id=4
                            AND foll.followup_date>CURRENT_DATE';  
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while ($row = mysql_fetch_assoc($result)) {
                          $followdata[]=$row;  
                        }
                        $m=1;
                        for($i=0;$i<sizeof($followdata);$i++)
                        {
                            $data .='<tr><td>'.$m++.'</td><td>'.$followdata[$i]['business_name'].'</td><td>'.$followdata[$i]['owner_name'].'</td><td>'.$followdata[$i]['user_name'].'</td><td>'.$followdata[$i]['cell_code'].' - '.$followdata[$i]['cell_number'].'</td>'
                                    . '<td>'.$followdata[$i]['email'].'</td><td>'.$followdata[$i]['followup_date'].'</td><td>'.$followdata[$i]['due_amount'].'</td>';
                        }
                        $jsondata=array(
                            "status" => "success",
                            "data"  => $data,
                        ); 
                        return $jsondata;
                    }
                    else
                    {
                        $jsondata=array(
                            "status" => "failure",
                            "data"  => NULL,
                        ); 
                        return $jsondata;
                    }  
                }
                public function FetchExpiredFollowUp() {
                     $followdata=array();
                    $data='';
                    $query='SELECT 
                            foll.followup_date,
                            dd.due_amount,
                            up.owner_name,
                            up.business_name,
                            up.user_name,
                            up.cell_code,
                            up.cell_number,
                            up.email
                            FROM follow_ups foll
                            LEFT JOIN due dd
                            ON dd.id=foll.due_id
                            LEFT JOIN user_profile up
                            ON up.id=dd.user_pk
                            WHERE foll.status_id=4 AND dd.status_id=4
                            AND foll.followup_date < CURRENT_DATE';  
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while ($row = mysql_fetch_assoc($result)) {
                          $followdata[]=$row;  
                        }
                        $m=1;
                        for($i=0;$i<sizeof($followdata);$i++)
                        {
                            $data .='<tr><td>'.$m++.'</td><td>'.$followdata[$i]['business_name'].'</td><td>'.$followdata[$i]['owner_name'].'</td><td>'.$followdata[$i]['user_name'].'</td><td>'.$followdata[$i]['cell_code'].' - '.$followdata[$i]['cell_number'].'</td>'
                                    . '<td>'.$followdata[$i]['email'].'</td><td>'.$followdata[$i]['followup_date'].'</td><td>'.$followdata[$i]['due_amount'].'</td>';
                        }
                        $jsondata=array(
                            "status" => "success",
                            "data"  => $data,
                        ); 
                        return $jsondata;
                    }
                    else
                    {
                        $jsondata=array(
                            "status" => "failure",
                            "data"  => NULL,
                        ); 
                        return $jsondata;
                    }
                    
                }
}

