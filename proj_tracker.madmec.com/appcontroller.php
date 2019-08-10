<?php
class app {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }
    public function saveUserDetails() {
        $pass = generateRandomString();
        $driverquery = 'INSERT INTO `user_profile` (`email`,`regdno`,`user_name`,`password`,`apassword`,`authenticatkey`,`cell_number`,`user_type_id`)
                    VALUES(
                    "' . mysql_real_escape_string($this->parameters['driveremail']) . '",
                    "' . mysql_real_escape_string($this->parameters['regdno']) . '",
                    "' . mysql_real_escape_string($this->parameters['drivername']) . '",
                    "' . mysql_real_escape_string($pass) . '",
                    "' . mysql_real_escape_string(md5($pass)) . '",
                    "' . mysql_real_escape_string(md5(microtime())) . '",
                    "' . mysql_real_escape_string($this->parameters['drivermobile']) . '",
                    "' . mysql_real_escape_string($this->parameters['usertype']) . '"
                    );';
        $res1 = executeQuery($driverquery);
        $driverid = mysql_result(0, executeQuery('SELECT LAST_INSERT_ID();'));
        $drivermsg = 'App Login Detals: ID :' . $this->parameters['driveremail'] . ', Password : ' . $pass;
        $restPara = array(
            "user" => 'madmec',
            "password" => 'madmec',
            "mobiles" => $this->parameters['drivermobile'],
            "sms" => $drivermsg,
            "senderid" => 'MADMEC',
            "version" => 3,
            "accountusagetypeid" => 1
        );
        $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
        $response1 = file_get_contents($url);
        if ($response1) {
            $query = 'INSERT INTO `crm_sms`(`id`,
                        `from_pk`,
                        `to_pk`,
                        `to_mobile`,
                        `text`,
                        `msg_type`,
                        `date`,
                        `status_id`) VALUES
                (NULL,1,1,
                \'' . mysql_real_escape_string($this->parameters['drivermobile']) . '\',
                \'' . mysql_real_escape_string($drivermsg) . '\',
                \'' . mysql_real_escape_string($drivernoofmsg) . '\',    
                NOW(),
                14);';
            executeQuery($query);
        }
        return $res;
    }
    public function saveLocations() {
        for ($i = 0; $i < sizeof($this->parameters['loc']); $i++) {
            $driverquery = 'INSERT INTO `locations` (`lat`,`lng`)
            VALUES(
            "' . mysql_real_escape_string($this->parameters['loc'][$i]['lat']) . '",
            "' . mysql_real_escape_string($this->parameters['loc'][$i]['lng']) . '"
            );';
            executeQuery($driverquery);
        }
    }
    public function updateLocation() {
        $flag = true;
        $ret = array(
            "STATUS" => 'success',
            "action" => 'saveLocations',
        );
        $id = isset($_POST['dataTracker']['USER_ID']) ? $_POST['dataTracker']['USER_ID'] : 0;
        for ($i = 0; $i < sizeof($this->parameters['loc']); $i++) {
            $driverquery = 'UPDATE `user_profile` SET `lat` = 
                "' . mysql_real_escape_string($this->parameters['loc'][$i]['lat']) . '",`lng`  = 
                "' . mysql_real_escape_string($this->parameters['loc'][$i]['lng']) . '" WHERE `id` = 
                "' . mysql_real_escape_string($id) . '";';
            $res = executeQuery($driverquery);
            if (!$res) {
                $ret["STATUS"] = 'error';
                $ret["action"] = 'saveLocations';
                $flag = false;
                break;
            }
        }
        return $ret;
    }
    public function getLocations() {
        $latlng = array();
        $driverquery = 'SELECT `lat`,`lng` FROM `locations` ;';
        $res = executeQuery($driverquery);
        while ($row = mysql_fetch_assoc($res)) {
            array_push($latlng, $row);
        }
        return (array) $latlng;
    }
    public function getUsers() {
        $users = array();
        $driverquery = 'SELECT * FROM `user_profile`  WHERE `login`=1 AND `user_type_id` IN (3,4);';
        $res = executeQuery($driverquery);
        while ($row = mysql_fetch_assoc($res)) {
            array_push($users, $row);
        }
        return (array) $users;
    }
}