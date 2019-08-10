<?php

class sms {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function fetchListOfCity() {
        $listofcitys = array();
        $data = array();
        $query = 'SELECT * FROM `city`;';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            while ($row = mysql_fetch_assoc($res)) {
                $listofgyms[] = $row;
            }
        }
        $len = sizeof($listofgyms);
        if ($len) {
            $htm = '';
            for ($i = 0; $i < $len; $i++) {
                $data[$i] = $listofgyms[$i]['city'];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
            );
            echo json_encode($jsondata);
            exit(0);
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
            );
            echo json_encode($jsondata);
        }
    }

    public function listOfGyms() {
        $listofgyms = array();
        $htm = '';
        $query = 'SELECT * FROM data_unique WHERE (contact1 NOT LIKE "+(91)-%-%" AND  contact1 NOT LIKE "2%" AND  contact1 NOT LIKE "3%"
                    AND  contact1 NOT LIKE "4%"
                    AND  contact1 NOT LIKE "5%"
                    AND  contact1 NOT LIKE "6%")
                    AND  contact1 !=""
                    AND  `city`="' . $this->parameters["city"] . '";';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            while ($row = mysql_fetch_assoc($res)) {
                $listofgyms[] = array(
                    "id" => $row["id"],
                    "fname" => $row["fname"],
                    "lname" => $row["lname"],
                    "contact1" => $row["contact1"],
                    "established" => $row["established"],
                    "address" => $row["address"],
                    "city" => $row["city"]
                );
            }
        }
        $len = sizeof($listofgyms);
        if ($len) {

            for ($i = 0; $i < $len; $i++) {
                $htm .= '<tr><td>' . ($i + 1) . '</td><td>' . $listofgyms[$i]["lname"] . '</td><td>' . $listofgyms[$i]["contact1"] . '</td><td>' . $listofgyms[$i]["established"] . '</td><td>' . $listofgyms[$i]["address"] . '</td><td>' . $listofgyms[$i]["city"] . '</td>'
                        . '<td><input type="checkbox" name="checkbox1"  class="checkbox1" value="'.$listofgyms[$i]["id"].'"></td>'
                        . '</tr>';
                $ids[]=$listofgyms[$i]["id"];
                $temp1=  explode('-', $listofgyms[$i]["contact1"]);
                if(is_array($temp1) && sizeof($temp1) > 1)
                {
                 $contacts[]=$temp1[1];
                }
                else
                 $contacts[]=$listofgyms[$i]["contact1"];
            }
            $jsondata = array(
                "status" => "success",
                "noofrec" => $len,
                "data" => $htm .'<script>$(".checkbox1").click(function () {

                        if ($(".checkbox1").length == $(".checkbox1:checked").length) {
                            $("#selectall").attr("checked", "checked");
                        } else {
                            $("#selectall").removeAttr("checked");
                        }

                    });</script>',
                "ids"  => $ids,
                "contacts"  => $contacts
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "noofrec" => 0,
                "data" => $htm,
            );
            return $jsondata;
        }
    }

   function sendSMS() {
      $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
         if(is_array($this->parameters['ids'] ) && sizeof($this->parameters['ids']) >0)
         {
             $m=0;
            $mobiles='';
            $noofmsg=0;
            $msglen=(int)(strlen($this->parameters['message'])/160)+1;
             for($i=0;$i<sizeof($this->parameters['ids']);$i++)
             {
                 $m++;
                $noofmsg++;
                if($m == 299 || $i==(sizeof($this->parameters['ids']) - 1))
                {
                   $mobiles .=$this->parameters['ids'][$i];
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
                $mobiles .=$this->parameters['ids'][$i].',';
                }
             }
             $totalmsgs=$noofmsg*$msglen;
                if($response2)
                {
                    $msgquery='INSERT INTO `sms_descb`(`id`,`message`,`time`,`noofmsg`,`status_id`)VALUES(NULL,'
                            . '"'.  mysql_real_escape_string($this->parameters['message']).'",now(),'
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
        }
    }
    }

}
?>