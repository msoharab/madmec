<?php
class setting {
    protected $parameters = array();
		function __construct($parameters = false) {
			$this->parameters = $parameters;
		}
                public function fetchBillingDetails() {
                $query="SELECT * FROM `billing_details` WHERE `status_id`=4";
                $result=  executeQuery($query);
                $num=mysql_num_rows($result);
                if($num)
                {
                    $row=  mysql_fetch_assoc($result);
                    $jsondata=array(
                        "noofrecords" => $num,
                        "billlogo" =>$row['billlogo'],
                        "companyname" =>$row['companyname'],
                        "address" =>$row['address'],
                        "landline" =>$row['landline'],
                        "email" =>$row['email'],
                        "mobile" =>$row['mobile'],
                        "termsncondition" =>$row['termsncondition'],
                        "footermessage" =>$row['footermessage'],
                    );
                    return $jsondata;
                }
                else
                {
                  $jsondata=array(
                        "noofrecords" => $num,
                    );
                }
                }
                public function addBillingDetails() {
                    if($this->parameters['check']==0)
                    {
                        $query='INSERT INTO `billing_details`(`id`,`billlogo`,`companyname`,`address`,`landline`,`email`,`mobile`,`termsncondition`,`footermessage`,`status_id`)VALUES('
                              . 'null,'
                              . '"'.mysql_real_escape_string($this->parameters['logopath']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['companyname']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['companyaddress']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['companylandline']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['companyemail']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['companymobile']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['termsncondition']).'",'
                              . '"'.mysql_real_escape_string($this->parameters['footermsg']).'",'
                              . '4)';
                    }
                    else if(mysql_real_escape_string($this->parameters['logopath'])=="")
                    {
                        $query='UPDATE `billing_details` SET `companyname`="'.mysql_real_escape_string($this->parameters['companyname']).'",'
                                . '`address`="'.mysql_real_escape_string($this->parameters['companyaddress']).'",'
                                . '`landline`="'.mysql_real_escape_string($this->parameters['companylandline']).'",'
                                . '`email`="'.mysql_real_escape_string($this->parameters['companyemail']).'",'
                                . '`mobile`="'.mysql_real_escape_string($this->parameters['companymobile']).'",'
                                . '`termsncondition`="'.mysql_real_escape_string($this->parameters['termsncondition']).'",'
                                . '`footermessage`="'.mysql_real_escape_string($this->parameters['footermsg']).'"'
                                . ' WHERE `status_id`=4';
                    }
                    else
                    {
                        $query='UPDATE `billing_details` SET `companyname`="'.mysql_real_escape_string($this->parameters['companyname']).'",'
                                . '`address`="'.mysql_real_escape_string($this->parameters['companyaddress']).'",'
                                . '`landline`="'.mysql_real_escape_string($this->parameters['companylandline']).'",'
                                . '`email`="'.mysql_real_escape_string($this->parameters['companyemail']).'",'
                                . '`mobile`="'.mysql_real_escape_string($this->parameters['companymobile']).'",'
                                . '`termsncondition`="'.mysql_real_escape_string($this->parameters['termsncondition']).'",'
                                . '`footermessage`="'.mysql_real_escape_string($this->parameters['footermsg']).'",'
                                . '`billlogo`="'.mysql_real_escape_string($this->parameters['logopath']).'"'
                                . ' WHERE `status_id`=4';
                    }
                    $verify=  executeQuery($query);
                    if($verify)
                    {
//                        if(mysql_real_escape_string($this->parameters['logopath']) == "")
//                        {
//                            $_SESSION['BillingDetails']=array(
//                                                "BILL_LOGO" =>  $_SESSION['BillingDetails']['BILL_LOGO'],
//                                                "COMPANAY_NAME" =>mysql_real_escape_string($this->parameters['companyname']),
//                                                "COMPANY_ADDRESS" => mysql_real_escape_string($this->parameters['companyaddress']),
//                                                "COMPANY_LANDLINE" => mysql_real_escape_string($this->parameters['companylandline']),
//                                                "COMPANY_EMAIl"  => mysql_real_escape_string($this->parameters['companyemail']),
//                                                "COMPANY_MOBILE"  => mysql_real_escape_string($this->parameters['companymobile']),
//                                                "COMPANY_TC"  => mysql_real_escape_string($this->parameters['termsncondition']),
//                                                "COMPANY_FM"  => mysql_real_escape_string($this->parameters['footermsg']),
//                                                );
//                        }
//                        else
//                        {
//                            $_SESSION['BillingDetails']=array(
//                                                "BILL_LOGO" =>  mysql_real_escape_string($this->parameters['logopath']),
//                                                "COMPANAY_NAME" => mysql_real_escape_string($this->parameters['companyname']),
//                                                "COMPANY_ADDRESS" => mysql_real_escape_string($this->parameters['companyaddress']),
//                                                "COMPANY_LANDLINE" => mysql_real_escape_string($this->parameters['companylandline']),
//                                                "COMPANY_EMAIl"  => mysql_real_escape_string($this->parameters['companyemail']),
//                                                "COMPANY_MOBILE"  => mysql_real_escape_string($this->parameters['companymobile']),
//                                                "COMPANY_TC"  => mysql_real_escape_string($this->parameters['termsncondition']),
//                                                "COMPANY_FM"  => mysql_real_escape_string($this->parameters['footermsg']),
//                                                );
//                        }
                    }
                    return $verify;
                }
        }
