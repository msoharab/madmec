<?php
class menu2 {
    protected $parameters = array();
    function __construct($para = false) {
        $this->parameters = $para;
    }
    // Add gym
    function addGYMProfile() {
        // gym_profile ('show','hide','delete');
        // userprofile_gym_profile ('active','inactive','delete')
        // email and cell number ('delete','undelete')
        $undelte = getStatusId("undelete");
        $active = getStatusId("active");
        $show = getStatusId("show");
        $gym_pk = 0;
        $type = '';
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $db_host = mysql_real_escape_string($this->parameters["db_host"]);
        $db_user = mysql_real_escape_string($this->parameters["db_user"]);
        $db_name = mysql_real_escape_string($this->parameters["db_name"]);
        $db_pass = mysql_real_escape_string($this->parameters["db_pass"]);
        if (mysql_real_escape_string($this->parameters["type"]) == "main")
            $type = "main";
        else if (mysql_real_escape_string($this->parameters["type"]) == "branch")
            $type = "branch";
        /* Photo */
        $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
				NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query)) {
            /* Profile */
            $query1 = 'INSERT INTO  `gym_profile` (`id`,
					`gym_name`,
					`gym_type`,
					`db_host`,
					`db_username`,
					`db_password`,
					`short_logo`,
					`header_logo`,
					`postal_code`,
					`telephone`,
					`directory`,
					`currency_code`,
					`reg_fee`,
					`service_tax`,
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
					`gmaphtml`,
					`status`)
				VALUES(
					NULL,
					\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					\'' . $type . '\',
					\'' . mysql_real_escape_string($db_host) . '\',
					\'' . mysql_real_escape_string($db_user) . '\',
					\'' . mysql_real_escape_string($db_pass) . '\',
					NULL,
					NULL,
					\'' . mysql_real_escape_string($this->parameters["pcode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["tphone"]) . '\',
					NULL,
					NULL,
					\'' . mysql_real_escape_string($this->parameters["fee"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["tax"]) . '\',
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
					NULL,
					NULL,
					NULL,
					NULL,
					\'' . mysql_real_escape_string($show) . '\')';
            if (executeQuery($query1)) {
                $gym_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                /* emails */
                if (is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1) {
                    $query = 'INSERT INTO  `gym_email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["email"]); $i++) {
                        if ($i == sizeof($this->parameters["email"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									  \'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
									  \'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									  \'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
									  \'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `gym_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["email"][0]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($gym_pk) . '\'');
                }
                /* cell_numbers */
                if (is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1) {
                    $query = 'INSERT INTO  `gym_cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status`) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["cellnumbers"]); $i++) {
                        if ($i == sizeof($this->parameters["cellnumbers"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									\'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									\'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `gym_profile` SET `cell_code`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]) . '\',
										`cell_number`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($gym_pk) . '\'');
                }
                $directory_user = createdirectories(substr(md5(microtime()), 0, 6) . '_gym_' . $gym_pk);
                $db_name.=$gym_pk;
                executeQuery('UPDATE `gym_profile` SET `directory` = \'' . $directory_user . '\' WHERE `id`=\'' . mysql_real_escape_string($gym_pk) . '\';');
                executeQuery('UPDATE `gym_profile` SET `db_name`  = \'' . mysql_real_escape_string($db_name) . '\' WHERE `id`=\'' . mysql_real_escape_string($gym_pk) . '\';');
                executeQuery('INSERT INTO `userprofile_gymprofile` VALUES (NULL,\'' . mysql_real_escape_string($this->parameters["userpk"]) . '\',\'' . mysql_real_escape_string($gym_pk) . '\',\'' . mysql_real_escape_string($active) . '\');');
                $flag = true;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    //Fetch ListofGYms
    public function fetchListOfGyms() {
        $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
        $db_select = selectDB(DBNAME_ZERO, $link);
        $fetchdata = array();
        $data = '';
        $query = 'SELECT gp.* ,
                    b.cellcode AS cellcodes,
                    b.cellnumber AS cellnumbers,
                    c.email AS emails
                    FROM userprofile_gymprofile upgp
                    LEFT JOIN gym_profile gp
                    ON gp.id=upgp.gym_id
                    LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(gcell.`id`,"☻☻♥♥☻☻") AS cell_pk,
                            GROUP_CONCAT(gcell.`cell_number`,"☻☻♥♥☻☻") AS cellnumber,
                            GROUP_CONCAT(gcell.`cell_code`,"☻☻♥♥☻☻") AS cellcode,
                            gcell.`user_pk`
                    FROM `gym_cell_numbers` AS gcell
                    GROUP BY (gcell.`user_pk`)
                    ORDER BY (gcell.`user_pk`)
                    )  AS b ON gp.`id` = b.`user_pk`
                    LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS em_pk,
                            GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
                            em.`user_pk`
                    FROM `email_ids` AS em
                    GROUP BY (em.`user_pk`)
                    ORDER BY (em.`user_pk`)
                    )  AS c ON gp.`id` = c.`user_pk`
                    WHERE  upgp.status=11 AND gp.status=4 AND upgp.user_pk= '. mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            $m = 1;
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . $m++ . '</td><td> Gym Name :' . $fetchdata[$i]["gym_name"] . '<br/> Address : ' . $fetchdata[$i]["addressline"] . '<br/>' . $fetchdata[$i]["town"] . '<br/>' . $fetchdata[$i]["city"] . '<br/>' . $fetchdata[$i]["district"] . '<br/>' . $fetchdata[$i]["province"] . '<br/>' . $fetchdata[$i]["country"] . '<br/> Zipcode : ' . $fetchdata[$i]["zipcode"] . '<br/>Mobile : ' . $fetchdata[$i]["cell_code"] . '-' . '' . $fetchdata[$i]["cell_number"] . '<br/>Email : ' . $fetchdata[$i]["email"] . '</td></tr>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => $data
            );
            return $jsondata;
        }
    }
}
?>