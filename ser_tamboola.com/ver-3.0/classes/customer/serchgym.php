<?php

class serchgym {
     protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }
    public function fetchListOfGyms() {
        $query='SELECT gp.*,
                CASE WHEN a.`istatus` IS NULL OR a.`istatus`=""
                THEN
                "no"
                WHEN a.`istatus`=6
                THEN "no"
                ELSE
                "yes"
                END
                AS reqstatus
                FROM `gym_profile` gp
                LEFT JOIN userprofile_gymprofile upgp
                ON upgp.gym_id=gp.id
                LEFT JOIN
                (SELECT
                cr.status AS istatus,
                cr.gym_id AS creqgymid
                FROM customer_request cr
                WHERE cr.user_pk="'.mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'"
                AND cr.status !=6
                ) AS a
                ON a.creqgymid=gp.id
                WHERE  gp.status=4
                AND upgp.status=11
                AND gp.id NOT IN(SELECT gym_id FROM userprofile_gymprofile WHERE user_pk="'.mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'")
                GROUP BY gp.gym_name
                ORDER BY gp.gym_name';
        $result=  executeQuery($query);
        $fetchdata=array();
        $data=array();
        $gymids=array();
        if(mysql_num_rows($result))
        {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[]=$row;
            }
            for($i=0;$i<sizeof($fetchdata);$i++)
            {
                $data[$i]=$fetchdata[$i]['gym_name'].'--'.$fetchdata[$i]['gym_type'].'--'.$fetchdata[$i]['addressline'].'--'.$fetchdata[$i]['town'].'--'.$fetchdata[$i]['city'].'--'.$fetchdata[$i]['district'].'--'.$fetchdata[$i]['province'].'--'.$fetchdata[$i]['zipcode'];
                $gymids[$i]=$fetchdata[$i]['id'];
            }
            $jsondata=array(
                "status" => "success",
                "data" => $data,
                "gymids" => $gymids,
                "gymdata" => $fetchdata,
            );
            return $jsondata;
        }
    }
    public function sendRequest() {
           $query="SELECT * FROM `customer_request` WHERE (`status`=4 OR `status`=14) AND `gym_id`='".  mysql_real_escape_string($this->parameters['gymid'])."' AND `user_pk`='".  mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID'])."';";
           $result=  executeQuery($query);
           if(mysql_num_rows($result))
           {
               return 2;
           }
           else
           {
               $query='INSERT INTO `customer_request`(`id`,`user_pk`,`gym_id`,`status`)VALUES(NULL,'
                       . '"'.  mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']).'",'
                       . '"'.  mysql_real_escape_string($this->parameters['gymid']).'",14'
                       . ')';
               if(executeQuery($query))
               {
                  return 1;
               }
               else
               {
                   return 0;
               }
           }
    }
}
