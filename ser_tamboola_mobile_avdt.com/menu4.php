<?php
class menu4 {
    protected $parameters = array();
    function __construct($para = false) {
        $this->parameters = $para;
    }
    public function fetchPackagesTypes() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT * FROM `package_name` WHERE `status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<option value="' . $fetchdata[$i]['id'] . '">' . $fetchdata[$i]['package_name'] . '</option>';
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
    public function addPackage() {
        $query = 'INSERT INTO `packages`(`id`,`gym_id`, `package_type_id`, `number_of_sessions`, `cost`,`packagename`, `status`) VALUES ('
                . 'null,'
                . '"' . mysql_real_escape_string($this->parameters['gymname']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['packtype']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['sessions']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['amount']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['packagename']) . '",'
                . '4)';
        $result = executeQuery($query);
        return $result;
    }
    //Fech Existing Packages
    public function fetchExistingPackages() {
        $fetchdata = array();
        $data = '';
        $query = 'SELECT pck.* ,
                pckname.`package_name` AS packagenamee,
                gp.`gym_name` AS gymname
                FROM `packages` pck 
                LEFT JOIN `package_name` pckname
                ON pckname.`id`=pck.`package_type_id`
                LEFT JOIN `gym_profile` gp
                ON gp.`id`=pck.`gym_id`
                LEFT JOIN `userprofile_gymprofile` upgp
                ON upgp.`gym_id`=pck.`gym_id`
                WHERE pck.`status`=4 AND upgp.`status`=11 AND gp.`status`=4
                AND upgp.`user_pk`=' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            $m = 0;
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ++$m . '</td><td>Gym Name  : ' . $fetchdata[$i]['gymname'] . '<br/>'
                        . ' Package Name : ' . $fetchdata[$i]['packagename'] . '<br/>'
                        . ' Sessions : ' . $fetchdata[$i]['number_of_sessions'] . '<br/>'
                        . ' Type : ' . $fetchdata[$i]['packagenamee'] . '<br/>'
                        . ' Amount : ' . $fetchdata[$i]['cost'] . '<br/>'
                        . '</td>'
                        . '</tr>';
            }
            $jsondata = array(
                "status" => "success",
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
}