<?php

class marketingmanager {
    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }
    public function fetchMM() {
        $query='SELECT * FROM user_profile
                WHERE user_type_id IN (SELECT id FROM `user_type` WHERE `user_type`="Marketing Company" OR `user_type`="Marketing Manager")
                AND status_id=1';
            $jsondata=array(
                "label" => NULL,
                "mid" => NULL,
                "flag" => false
            );
        $result=  executeQuery($query);
        if(mysql_num_rows($result))
        {
            $fetchdata=array();
            $data=array();
            while($row=  mysql_fetch_assoc($result))
            {
                $fetchdata[]=$row;
            }
            for($i=0;$i<sizeof($fetchdata);$i++)
            {
                $data["det"][$i]=$fetchdata[$i]['id'].'--'.$fetchdata[$i]['user_name'].'--'.$fetchdata[$i]['crname'].'--'.$fetchdata[$i]['email'].'--'.$fetchdata[$i]['cell_number'];
                $data["mid"][$i]=$fetchdata[$i]['id'];
            }
            $jsondata=array(
                "label" => $data["det"],
                "value" => $data["mid"],
                "flag" => true
            );
            return $jsondata;
        }
        else
        {
            return NULL;
        }

    }
    public function addMarketinLocation() {
        $query='INSERT INTO  `marketin_loc` (`id`,
							`mid`,
							`status_id`,
							`addressline`,
							`town`,
							`city`,
							`district`,
							`province`,
							`province_code`,
							`country`,
							`country_code`,
							`zipcode`,
							`website`,
							`latitude`,
							`longitude`,
							`timezone`,
							`gmaphtml` )  VALUES(
						NULL,
						\'' . mysql_real_escape_string($this->parameters["markid"]) . '\',
						1,
						\'' . mysql_real_escape_string($this->parameters["addrsline"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["st_loc"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["city_town"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["district"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["province"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["provinceCode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["country"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["countryCode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["zipcode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["website"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["lat"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["lon"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["timezone"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["gmaphtml"]) . '\');';
        $res=  executeQuery($query);
         return $res;

    }
    public function fetchLocWiseMM($mid) {
        $data=array();
        $fdata='';
        $query='SELECT * FROM marketin_loc WHERE status_id=1 AND `mid`="'.  mysql_real_escape_string($mid).'"' ;
        $result=  executeQuery($query);
        if(mysql_num_rows($result))
        {
            while($row=  mysql_fetch_assoc($result))
            {
                $data[]=$row;
            }
            $m=0;
            for($i=0;$i<sizeof($data);$i++)
            {
                $fdata .='<tr><td>'.++$m.'</td>'
                        . '<td>'.$data[$i]['addressline'].'</td>
                            <td>'.$data[$i]['town'].'</td>
                                <td>'.$data[$i]['city'].'</td>
                                    <td>'.$data[$i]['district'].'</td>'
                        . '<td>'.$data[$i]['province'].'</td>'
                        . '<td>'.$data[$i]['country'].'</td>'
                        . '<td>'.$data[$i]['zipcode'].'</td>'
                         .'   </tr>';
            }
            $jsondata =array(
                "status"  => "success",
                "data" => $fdata
            );
            return $jsondata;
        }
        else
        {
            $jsondata =array(
                "status"  => "failure",
                "data" => NULL
            );
            return $jsondata;
        }
    }
}
