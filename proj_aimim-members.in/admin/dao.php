<?php

class dao {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
        $link=MySQLconnect(DBHOST,DBUSER,DBPASS);
        $db_select = selectDB(DBNAME_ZERO,$link) == 1;
    }

    public function fetchMembers() {
          $query='SELECT up.*,ut.user_type FROM `user_profile` up'
                  . ' LEFT JOIN `user_type` ut ON ut.id=up.user_type_id '
                  . ' WHERE up.`status_id`=1';
          $result=  executeQuery($query);
          if(mysql_num_rows($result))
          {
              $fetchdata=array();
              $data ='';
              while($row=  mysql_fetch_assoc($result))
              {
                  $fetchdata[]=$row;
              }
              $m=0;
              for($i=0;$i<sizeof($fetchdata);$i++)
              {
                  $data .='<tr><td>'.++$m.'</td><td>'.$fetchdata[$i]['user_name'].'</td><td>'.$fetchdata[$i]['cell_number'].'</td><td>'.$fetchdata[$i]['email'].'</td><td>'.$fetchdata[$i]['user_type'].'</td>'
                          . '<td>'.$fetchdata[$i]['addressline'].'<br/>'.$fetchdata[$i]['city'].'<br/>'.$fetchdata[$i]['province'].'<br/></td>'
                          . '<td>'.$fetchdata[$i]['zipcode'].'</td><td>'.$fetchdata[$i]['country'].'</td>'
                          . '</tr>';
              }
              $jsondata=array(
              "status" => "success",
               "data" => $data,
              );
              return $jsondata;
          }
          else
          {
              $jsondata=array(
              "status" => "failure",
               "data" => NULL,
              );
              return $jsondata;
          }

    }

    public function addadminparam() {
            $query = "INSERT INTO `user_profile`
                            ( `user_name`, `cell_code`, `cell_number`, `email`,  `user_type_id`, `status_id`, `date_of_join`, `dob`, `gender`, `addressline`,  `city`, `province`, `country`, `zipcode`)
                            VALUES
                            ('".mysql_real_escape_string($this->parameters['name'])."','+91','".mysql_real_escape_string($this->parameters['mobile'])."','".mysql_real_escape_string($this->parameters['email'])."','".  mysql_real_escape_string($this->parameters['usertype'])."','1',NOW(),'".mysql_real_escape_string($this->parameters['dob'])."','".mysql_real_escape_string($this->parameters['gender'])."','".mysql_real_escape_string($this->parameters['address'])."','".mysql_real_escape_string($this->parameters['city'])."','".mysql_real_escape_string($this->parameters['province'])."','India','".mysql_real_escape_string($this->parameters['zipcode'])."');";
            $result=  executeQuery($query);
            return $result;
    }

    public function fetchUserType() {
        $query='SELECT * FROM `user_type` WHERE `status_id`=4';
          $result=  executeQuery($query);
          if(mysql_num_rows($result))
          {
              $fetchdata=array();
              $data ='';
              while($row=  mysql_fetch_assoc($result))
              {
                  $fetchdata[]=$row;
              }
              $m=0;
              for($i=0;$i<sizeof($fetchdata);$i++)
              {
                  $data .='<option value="'.$fetchdata[$i]['id'].'">'.$fetchdata[$i]['user_type'].'</option>'
                          . '</tr>';
              }
              $jsondata=array(
              "status" => "success",
               "data" => $data,
              );
              return $jsondata;
          }
          else
          {
              $jsondata=array(
              "status" => "failure",
               "data" => NULL,
              );
              return $jsondata;
          }

    }

    public function sendMessage()
    {
        $query='';
        if($this->parameters['usertype'] == "all")
        {
            $query="SELECT * FROM `user_profile` WHERE `status_id`=1";
        }
        else
        {
           $query="SELECT * FROM `user_profile` WHERE `status_id`=1 AND user_type_id='".  mysql_real_escape_string($this->parameters['usertype'])."'";
        }
        $result=  executeQuery($query);
        if(mysql_num_rows($result))
        {
            $fetchdata=array();
            while($row=  mysql_fetch_assoc($result))
            {
                $fetchdata[]=$row;
            }
            $m=0;
            $mobiles='';
            $noofmsg=0;
            $msglen=(int)(strlen($this->parameters['message'])/160)+1;
            for($i=0;$i<sizeof($fetchdata);$i++)
              {
                $m++;
                $noofmsg++;
                if($m == 299 || $i==(sizeof($fetchdata) - 1))
                {
                   $mobiles .=$fetchdata[$i]['cell_number'];
                   $restPara = array(
                            "user" 		=> 'madmec',
                            "password"          => 'madmec',
                            "mobiles"           => $mobiles,
                            "sms" 		=> $this->parameters['message'],
                            "senderid" 		=> 'MADMEC',
                            "version" 		=> 3,
                            "accountusagetypeid" => 1
                    );
                    $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                    $response2 = file_get_contents($url);
                     $m=0;
                    $mobiles='';
                }
                else
                {
                $mobiles .=$fetchdata[$i]['cell_number'].',';
                }

                }
                $totalmsgs=$noofmsg*$msglen;
                if($response2)
                {
                    $msgquery='INSERT INTO `sms_descb`(`id`,`message`,`user_type`,`time`,`noofmsg`,`status_id`)VALUES(NULL,'
                            . '"'.  mysql_real_escape_string($this->parameters['message']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['usertype']).'",now(),'
                            . '"'.  $totalmsgs.'",1'
                            . ');';
                    executeQuery($msgquery);
                    return true;
                }
                else
                {
                    return false;
                }

        }
        else
        {
            return false;
        }
    }

}
