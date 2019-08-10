<?php
class menu3 {
    protected $parameters = array();
    function __construct($para = false) {
        $this->parameters = $para;
    }
    //Fetch List of Gym's For adding Offers
    public function fetchGyms() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT gp.`id`,
                    gp.`gym_name`
                    FROM `gym_profile` gp
                    LEFT JOIN `userprofile_gymprofile` upgp
                    ON upgp.`gym_id`=gp.`id`
                    WHERE upgp.`status`=11 AND gp.`status`=4
                    AND upgp.`user_pk`= '.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<option value="' . $fetchdata[$i]['id'] . '">' . $fetchdata[$i]['gym_name'] . '</option>';
            }
            $jsondata = array(
                "status" => "successs",
                "data" => $data,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
                "query" => $query,
                "id"  => mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID'])
            );
            return $jsondata;
        }
    }
    //Fetch Duration For adding Offers
    public function fetchDuration() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT * FROM `offerduration` WHERE `status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<option value="' . $fetchdata[$i]['id'] . '">' . $fetchdata[$i]['duration'] . '</option>';
            }
            $jsondata = array(
                "status" => "successs",
                "data" => $data,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
            );
            return $jsondata;
        }
    }
    //Fetch List of Gym's For adding Offers
    public function fetchFacilities() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT * FROM `facility` WHERE `status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<option value="' . $fetchdata[$i]['id'] . '">' . $fetchdata[$i]['name'] . '</option>';
            }
            $jsondata = array(
                "status" => "successs",
                "data" => $data,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
            );
            return $jsondata;
        }
    }
    //Add Offer
    public function addOffers() {
        $query = 'INSERT INTO `offers`(`id`, `name`, `duration_id`, `num_of_days`, `facility_id`, `description`, `cost`, `min_members`, `gym_id`,  `status`) VALUES '
                . '(null,'
                . '"' . mysql_real_escape_string($this->parameters['name']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['duration']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['days']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['faciltiy']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['descb']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['prize']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['member']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['gymname']) . '",4)';
        $res = executeQuery($query);
        return $res;
    }
    //Fetch Offes
    public function fetchOffers() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT off.* ,
                    gp.`gym_name`,
                    ofd.`duration` AS offdur,
                    fac.`name` facilityname
                    FROM `offers` AS off
                    LEFT JOIN `gym_profile` gp ON gp.`id`=off.`gym_id`
                    LEFT JOIN `userprofile_gymprofile` upgp ON upgp.`gym_id`=gp.`id`
                    LEFT JOIN `offerduration` ofd ON ofd.`id`=off.`duration_id`
                    LEFT JOIN `facility` fac ON fac.`id`=off.`facility_id`
                    WHERE off.`status`=4
                    AND gp.`status`=4
                    AND upgp.`user_pk`=' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            $m = 0;
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ++$m . '</td><td>Offer Name : ' . $fetchdata[$i]['name'] . '<br/>'
                        . ' Duration : ' . $fetchdata[$i]['offdur'] . '<br/>'
                        . ' Days : ' . $fetchdata[$i]['num_of_days'] . '<br/>'
                        . ' Facility : ' . $fetchdata[$i]['facilityname'] . '<br/>'
                        . ' Prize : ' . $fetchdata[$i]['cost'] . '<br/>'
                        . ' Members : ' . $fetchdata[$i]['min_members'] . '<br/>'
                        . ' Gym Name : ' . $fetchdata[$i]['gym_name'] . '<br/>'
                        . ' Description : ' . $fetchdata[$i]['description'] . '<br/></td>'
                        . '</tr>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL
            );
            return $jsondata;
        }
    }
}
?>