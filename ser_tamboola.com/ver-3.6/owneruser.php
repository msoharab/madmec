<?php

class owneruser {

    protected $parameters = array();

    public function __construct($para = false) {
        $this->parameters = $para;
    }

    public function clientAdminRequest() {
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES('
                . 'NULL,NULL,NULL,NULL,NULL,NULL);';
        $status1 = executeQuery($query1);
        $picid = mysql_insert_id();
        $query2 = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`photo_id`,`password`,`apassword`,`cell_number`,`dob`,`gender`,`status`)Values(null,'
                . '"' . mysql_real_escape_string($this->parameters['details']['name']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['details']['email']) . '",'
                . '"' . mysql_real_escape_string($picid) . '",'
                . '"' . mysql_real_escape_string(generateRandomString()) . '",'
                . '"' . mysql_real_escape_string(md5(generateRandomString())) . '",'
                . '"' . mysql_real_escape_string($this->parameters['details']['mobile']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['details']['dob']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['details']['gender']) . '",'
                . '11'
                . ')';
        $status2 = executeQuery($query2);
        $user_pk = mysql_insert_id();
        $query3 = 'INSERT INTO `userprofile_type`
							 (`id`,
							  `user_pk`,
							  `usertype_id`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',
                                                            \'' . mysql_real_escape_string($this->parameters['details']['usertype']) . '\',
							  4)';
        $status3 = executeQuery($query3);
        $query4 = 'INSERT INTO `email_ids`
							 (`id`,
							  `user_pk`,
							  `email`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',
                                                           \'' . mysql_real_escape_string($this->parameters['details']['email']) . '\',
							  17)';
        $status4 = executeQuery($query4);
        $query5 = 'INSERT INTO `cell_numbers`
							 (`id`,
							  `user_pk`,
                                                          `cell_code`,
							  `cell_number`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',+91,
                                                           \'' . mysql_real_escape_string($this->parameters['details']['mobile']) . '\',
							  17)';
        $status5 = executeQuery($query5);
        $query6 = 'INSERT INTO `owneruser`(`id`, `owner_pk`, `admin_pk`, `status`) VALUES (NULL,'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '",'
                . '"' . mysql_real_escape_string($user_pk) . '",'
                . '4)';
        $status6 = executeQuery($query6);
        $docqr = 'INSERT INTO `user_documents`(`id`,
					`user_pk`,
					`document_type`,
					`document_number`,
					`status`)
					VALUES(
					NULL,
					\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters['details']["doctype"]) . '\',
					\'' . mysql_real_escape_string($this->parameters['details']["docvalue"]) . '\',4);';
        executeQuery($docqr);
        $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_' . $user_pk);
        executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
        if ($status1 && $status2 && $status3 && $status4 && $status5 && $status6) {
            executeQuery("COMMIT");
            $cell_number = mysql_result(executeQuery('SELECT `cell_number` FROM `user_profile` WHERE `id` = "' . $user_pk . '";'), 0);
            $email_id = mysql_result(executeQuery('SELECT `email_id` FROM `user_profile` WHERE `id` = "' . $user_pk . '";'), 0);
            $password = mysql_result(executeQuery('SELECT `password` FROM `user_profile` WHERE `id` = "' . $user_pk . '";'), 0);
            $msg = 'Hi ' . $this->parameters['details']["name"]
                    . ' Website :- http://www.tamboola.com'
                    . ' Your Login Id :- ' . $email_id
                    . ' Your Password :- ' . $password . ' your account successfully created. for queries call [7676 06 3644] [7676 46 3644]';
            if ($cell_number != '' && !empty($cell_number)) {
                $restPara = array(
                    "user" => 'madmec',
                    "password" => 'madmec',
                    "mobiles" => $cell_number,
                    "sms" => $msg,
                    "senderid" => 'MADMEC',
                    "version" => 3,
                    "accountusagetypeid" => 1
                );
                $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                if (!preg_match('/error/', $response)) {
                    $query = "INSERT INTO `sms_record`
						( `user_pk`, `number`,  `msg`, `status`, `date`)
						VALUES
						(
						'" . mysql_real_escape_string($user_pk) . "',
						'" . mysql_real_escape_string($cell_number) . "',
						'" . mysql_real_escape_string($msg) . "',
						default,
						NOW()
						);";
                    executeQuery($query);
                }
            }
            $jsondata["STATUS"] = "success";
        } else {
            $jsondata["STATUS"] = "failure";
            executeQuery("ROLLBACK");
        }
        echo $jsondata["STATUS"];
    }

    public function checkEmail() {
        $query = "SELECT `email_id` FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($_POST['email']) . "';";
        $result = executeQuery($query);
        return mysql_num_rows($result);
    }

    public function displayAllGymsOfOwner() {
        $gymdata = array();
        $gymid = array();
        $query = 'SELECT gp.* FROM gym_profile gp
                LEFT JOIN userprofile_gymprofile upgp
                ON upgp.gym_id=gp.id
                WHERE gp.status=4 AND upgp.user_pk=' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata1[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $gymdata[$i] = $fetchdata1[$i]['gym_name'] . ' -- ' . $fetchdata1[$i]['gym_type'] . ' -- ' . $fetchdata1[$i]['addressline'] . ' -- ' . $fetchdata1[$i]['town'] . ' -- ' . $fetchdata1[$i]['city'] . ' -- ' . $fetchdata1[$i]['district'] . ' -- ' . $fetchdata1[$i]['province'];
                $gymid[$i] = $fetchdata1[$i]['id'];
            }
        }
        $jsondata = array(
            "gymdata" => $gymdata,
            "gymids" => $gymid,
        );
        return $jsondata;
        exit(0);
    }

    public function displayAllAdminsOfOwner() {
        $gymdata = array();
        $gymid = array();
        $query = 'SELECT up.*
                    FROM `user_profile` up
                    LEFT JOIN `userprofile_type` upt
                    ON upt.`user_pk`=up.`id`
                    LEFT JOIN owneruser ou
                    ON ou.admin_pk=up.id
                    WHERE up.`status`=11
                    AND upt.`usertype_id`=3
                    AND upt.`status`=4 AND ou.owner_pk=' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata1[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $gymdata[$i] = $fetchdata1[$i]['user_name'] . ' -- ' . $fetchdata1[$i]['cell_number'] . ' -- ' . $fetchdata1[$i]['email_id'];
                $gymid[$i] = $fetchdata1[$i]['id'];
            }
        }
        $jsondata = array(
            "gymdata" => $gymdata,
            "gymids" => $gymid,
        );
        return $jsondata;
        exit(0);
    }

    public function addUserToGym() {
        $query = 'SELECT * FROM `userprofile_gymprofile` WHERE `user_pk`="' . mysql_real_escape_string($this->parameters['det']['userid']) . '"  '
                . 'AND `gym_id`= "' . mysql_real_escape_string($this->parameters['det']['gymid']) . '" AND `status`=11';
        $result = executeQuery($query);
        $query1 = 'SELECT * FROM `userprofile_gymprofile` WHERE `user_pk`="' . mysql_real_escape_string($this->parameters['det']['userid']) . '"  '
                . 'AND `gym_id`= "' . mysql_real_escape_string($this->parameters['det']['gymid']) . '" AND `status`=14';
        $result1 = executeQuery($query1);
        if (mysql_num_rows($result)) {
            $jsondata = array(
                "status" => "alreadyexist",
            );
            return $jsondata;
        } else if (mysql_num_rows($result1)) {
            $jsondata = array(
                "status" => "pending",
            );
            return $jsondata;
        } else {
            $query = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`)VALUES(NULL,'
                    . '"' . mysql_real_escape_string($this->parameters['det']['userid']) . '",'
                    . '"' . mysql_real_escape_string($this->parameters['det']['gymid']) . '",'
                    . '11)';
            executeQuery($query);
            $jsondata = array(
                "status" => "success",
            );
            return $jsondata;
        }
    }

}
