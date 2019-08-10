<?php

class app {
protected $parameters = array();
		function __construct($para = false) {
			$this->parameters = $para;
		}
                public function generateBill() {
                    if($this->parameters['drivercheck']==0)
                    {
                        executeQuery(" SET AUTOCOMMIT=0;");
                        executeQuery("START TRANSACTION;");;
                        $driverquery='INSERT INTO `user_profile`(`id`,`user_name`,`cell_number`,`regdno`,`user_type_id`)VALUES(null,'
                                . '"'.  mysql_real_escape_string($this->parameters['drivername']).'",'
                                . '"'.  mysql_real_escape_string($this->parameters['drivermobile']).'",'
                                . '"'.  mysql_real_escape_string($this->parameters['regdno']).'",3'
                                . ');';
                        executeQuery($driverquery);
                        $driverid=  mysql_insert_id();
                        $payduequery='INSERT INTO `payment_due`(`id`,`driver_id`,`remainingamount`,`lastpaid`,`amountpaid`,`status_id`)'
                                . 'VALUES(null,'
                                . '"'.  mysql_real_escape_string($driverid).'",0,now(),0,4'
                                . ')';
                        executeQuery($payduequery);
                    }
                    else
                    {
                        $driverquery='UPDATE `user_profile` SET `user_name`="'.  mysql_real_escape_string($this->parameters['drivername']).'",'
                                . '`cell_number`="'.  mysql_real_escape_string($this->parameters['drivermobile']).'",'
                                . '`regdno`="'.  mysql_real_escape_string($this->parameters['regdno']).'" WHERE id="'.  mysql_real_escape_string($this->parameters['driverid']).'";'
                                . '';
                        executeQuery($driverquery);
                        $driverid= mysql_real_escape_string($this->parameters['driverid']) ;
                    }
                    if($this->parameters['passcheck']==0)
                    {
                        $passengerquery='INSERT INTO `user_profile`(`id`,`user_name`,`cell_number`,`addressline`,`user_type_id`)VALUES(null,'
                                . '"'.  mysql_real_escape_string($this->parameters['passengername']).'",'
                                . '"'.  mysql_real_escape_string($this->parameters['passengermobile']).'",'
                                . '"'.  mysql_real_escape_string($this->parameters['passngeraddress']).'",4'
                                . ');';
                        executeQuery($passengerquery);
                        $passid=  mysql_insert_id();
                    }
                    else
                    {
                        $passengerquery='UPDATE `user_profile` SET `user_name`="'.  mysql_real_escape_string($this->parameters['passengername']).'",'
                                . '`cell_number`="'.  mysql_real_escape_string($this->parameters['passengermobile']).'",'
                                . '`addressline`="'.  mysql_real_escape_string($this->parameters['passngeraddress']).'" WHERE id="'.  mysql_real_escape_string($this->parameters['passid']).'";'
                                . '';
                        executeQuery($passengerquery);
                        $passid= mysql_real_escape_string($this->parameters['passid']) ;
                    }
                        $query='INSERT INTO `reciept`(`id`,`source`,`destination`,`lattitude`,`longitude`,`driver_id`,`passenger_id`,`current_stn`,`distance`,`totalamount`,`recieptloc`,`status_id`)VALUES(null,'
                        . '"'.  mysql_real_escape_string($this->parameters['source']).'",'
                        . '"'.  mysql_real_escape_string($this->parameters['destination']).'",'
                        . '"10.2525",'
                        . '"10.2525",'
                        . '"'.  mysql_real_escape_string($driverid).'",'
                        . '"'.  mysql_real_escape_string($passid).'",'
                        . '"1",'
                        . '"'.  mysql_real_escape_string($this->parameters['distance']).'",'
                        . '"'.  mysql_real_escape_string($this->parameters['amount']).'","recieptloction",4'
                        . ')';   
                $res=  executeQuery($query);
                $drivermsg='Booking Detals: Psg Name :'.$this->parameters['passengername'].' Destn : '.$this->parameters['destination'];
                $passengermsg='Auto Details :  Regd.no : '.$this->parameters['regdno'].' Driver Name : '.$this->parameters['drivername'].' Mobile: '.$this->parameters['drivermobile'].'  Distance : '.$this->parameters['distance'].' Amount : Rs.'.$this->parameters['amount'].'/-';
                $restPara = array(
                            "user" 		=> 'madmec',
                            "password"          => 'madmec',
                            "mobiles"           => $this->parameters['drivermobile'],
                            "sms" 		=> $drivermsg,
                            "senderid" 		=> 'MADMEC',
                            "version" 		=> 3,
                            "accountusagetypeid" => 1
                    );
                    $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                    $response1 = file_get_contents($url);
                    $restPara = array(
                            "user" 		=> 'madmec',
                            "password"          => 'madmec',
                            "mobiles"           => $this->parameters['passengermobile'],
                            "sms" 		=> $passengermsg,
                            "senderid" 		=> 'MADMEC',
                            "version" 		=> 3,
                            "accountusagetypeid" => 1
                    );
                    $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                    $response2 = file_get_contents($url);
                    $drivernoofmsg=  (int)(strlen($drivermsg)/160)+1;
                    $passengernoofmsg=  (int)(strlen($passengermsg)/160)+1;
                    if($response1 && $response2){
                        $query = 'INSERT INTO `crm_sms`(`id`,
                                                            `from_pk`,
                                                            `to_pk`,
                                                            `to_mobile`,
                                                            `text`,
                                                            `msg_type`,
                                                            `date`,
                                                            `status_id`) VALUES
                                                    (NULL,1,1,
                                                    \''.mysql_real_escape_string($this->parameters['drivermobile']).'\',
                                                    \''.mysql_real_escape_string($drivermsg).'\',
                                                    \''.mysql_real_escape_string($drivernoofmsg).'\',    
                                                    NOW(),
                                                    14);';
                        executeQuery($query);
                        $query = 'INSERT INTO `crm_sms`(`id`,
                                                            `from_pk`,
                                                            `to_pk`,
                                                            `to_mobile`,
                                                            `text`,
                                                            `msg_type`,
                                                            `date`,
                                                            `status_id`) VALUES
                                                    (NULL,1,1,
                                                    \''.mysql_real_escape_string($this->parameters['passengermobile']).'\',
                                                    \''.mysql_real_escape_string($passengermsg).'\',
                                                    \''.mysql_real_escape_string($passengernoofmsg).'\', 
                                                    NOW(),
                                                    14);';
                        executeQuery($query);
                    }
                if($res)
                {
                    /* PDF Bill Generation */
//                    $reciept=new pdfbillgeneration($this->parameters);
//                   $reciept->generateAutoReciept();
//                    $_SESSION['pdfbillgeneration']=array(
//                        "passengername" => $this->parameters['passengername'],
//                        "source" => $this->parameters['source'],
//                        "destination" => $this->parameters['destination'],
//                        "regdno" => $this->parameters['regdno'],
//                        "drivername" => $this->parameters['drivername'],
//                        "drivermobile" =>  $this->parameters['drivermobile'],
//                        "distance" => $this->parameters['distance'],
//                        "amount" => $this->parameters['amount'],
//                        "bookid" =>  mysql_insert_id(),
//                        
//                    );
                 $query='UPDATE `payment_due` SET `remainingamount`=remainingamount+"'.mysql_real_escape_string($this->parameters['amount']).'"'
                         . 'WHERE `driver_id`="'.  mysql_real_escape_string($driverid).'"'; 
                 if(executeQuery($query));
                 {
                     executeQuery("COMMIT");
                 }
                 
                }
                return $res;
                }
                public function fetchRegdNumbers() {
                    $driverdata=array();
                    $passengerdata=array();
                    $passid=array();
                    $driverid=array();
                    $dueamount=  array();
                    $lastpaid=array();
                    $amountpaid=array();
                    $drivername=array();
                    $drivermobiles=array();
                    $regdno=array();
                    $passengernames=array();
                    $passaddress=array();
                    $passmobiles=array();
                 $query='SELECT up.`id`,
                            up.`regdno`,
                            up.`user_name`,
                            pdue.`amountpaid`,
                            pdue.`remainingamount` AS dueamount,
                            pdue.`lastpaid`,
                            up.`cell_number` 
                            FROM `user_profile` up
                            LEFT JOIN `payment_due` pdue
                            ON pdue.`driver_id`=up.`id`
                            WHERE `user_type_id`=3; ';
                 $result=  executeQuery($query);
                 if(mysql_num_rows($result))
                 {
                     while($row=  mysql_fetch_assoc($result))
                     {
                         $driverdata[]=$row;
                     }
                     for($i=0;$i<sizeof($driverdata);$i++)
                     {
                       $drivermobiles[$i]=$driverdata[$i]['cell_number'];  
                       $drivername[$i]=$driverdata[$i]['user_name'];
                       $regdno[$i]=$driverdata[$i]['regdno'];
                       $driverid[$i]=$driverdata[$i]['id'];
                       $dueamount[$i]=$driverdata[$i]['dueamount'];
                       $amountpaid[$i]=$driverdata[$i]['amountpaid'];
                       $lastpaid[$i]=$driverdata[$i]['lastpaid'];
                     }
                     
                 }
                 else
                 {
                       $drivermobiles[]='';  
                       $drivername[]='';
                       $regdno[]='';  
                       $driverid[]='';
                 }
                 $query1='SELECT `id`,`addressline`,`user_name`,`cell_number` FROM `user_profile` WHERE `user_type_id`=4'; 
                 $result1=  executeQuery($query1);
                 if(mysql_num_rows($result1))
                 {
                     while($row1=  mysql_fetch_assoc($result1))
                     {
                         $passengerdata[]=$row1;
                     }
                     for($i=0;$i<sizeof($passengerdata);$i++)
                     {
                       $passmobiles[$i]=$passengerdata[$i]['cell_number'];  
                       $passengernames[$i]=$passengerdata[$i]['user_name'];
                       $passaddress[$i]=$passengerdata[$i]['addressline'];
                       $passid[$i]=$passengerdata[$i]['id'];
                     }
                 }
                 else
                 {
                       $passmobiles[]='';  
                       $passengernames[]='';
                       $passaddress[]='';  
                       $passid[]='';
                 }
                 $jsondata=array(
                    "regdno" => $regdno,
                    "drivernames" => $drivername,
                    "drivermobiles" => $drivermobiles,
                    "passmobile" =>  $passmobiles,
                    "passnames" => $passengernames,
                    "passaddress" => $passaddress,
                     "passid" => $passid,
                     "driverid" => $driverid,
                     "dueamount" => $dueamount,
                     "amountpaid" => $amountpaid,
                     "lastpaid" => $lastpaid
                 );
                 return $jsondata;
                 
                }
}
