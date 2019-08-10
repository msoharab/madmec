<?php
class Home_Model extends BaseModel {

    private $para, $logindata, $UserId, $GymId, $GymData;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
    public function AddGym() {
        $jsondata = array(
            "gymtype" => $this->postBaseData["gymtype"],
            "gymname" => $this->postBaseData["gymname"],
            "regisfee" => $this->postBaseData["regisfee"],
            "servtax" => $this->postBaseData["servtax"],
            "telecode" => $this->postBaseData["telecode"],
            "telephone" => $this->postBaseData["telephone"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "district" => $this->postBaseData["district"],
            "city" => $this->postBaseData["city"],
            "street" => $this->postBaseData["street"],
            "addressline" => $this->postBaseData["addressline"],
            "zipcode" => $this->postBaseData["zipcode"],
            "gmapurl" => $this->postBaseData["gmapurl"],
            "website" => $this->postBaseData["website"],
            "emails" => (array) json_decode($this->postBaseData["emails"]),
            "cellnumner" => (array) json_decode($this->postBaseData["cellnumner"]),
            "db_host" => $this->config["DBHOST"],
            "db_user" => $this->config["DBUSER"],
            "db_name" => 'tamboola_' . $this->generateRandomString(),
            "db_pass" => $this->config["DBPASS"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* Gym Logo */
        $query0 = 'INSERT INTO `gym_photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $short_logo = $this->db->lastInsertId();
        array_push($jsondata["picids"], $short_logo);
        /* Gym Header */
        $query0 = 'INSERT INTO `gym_photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $header_logo = $this->db->lastInsertId();
        array_push($jsondata["picids"], $header_logo);
        /* Gym Image */
        $query0 = 'INSERT INTO `gym_photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $photo_id = $this->db->lastInsertId();
        array_push($jsondata["picids"], $photo_id);
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
                    `gmaphtml`,
                    `status`,
                    `db_name`,
                    `photo_id`)Values('
                . ':id1,
                    :id2,
                    :id3,
                    :id4,
                    :id5,
                    :id6,
                    :id7,
                    :id8,
                    :id9,
                    :id10,
                    :id11,
                    :id12,
                    :id13,
                    :id14,
                    :id15,
                    :id16,
                    :id17,
                    :id18,
                    :id19,
                    :id20,
                    :id21,
                    :id22,
                    :id23,
                    :id24,
                    :id25,
                    :id26,
                    :id27,
                    :id28)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["gymname"]),
            ":id3" => mysql_real_escape_string($jsondata["gymtype"]),
            ":id4" => mysql_real_escape_string($jsondata["db_host"]),
            ":id5" => mysql_real_escape_string($jsondata["db_user"]),
            ":id6" => mysql_real_escape_string($jsondata["db_pass"]),
            ":id7" => mysql_real_escape_string($short_logo),
            ":id8" => mysql_real_escape_string($header_logo),
            ":id9" => mysql_real_escape_string($jsondata["telecode"]),
            ":id10" => mysql_real_escape_string($jsondata["telephone"]),
            ":id11" => NULL,
            ":id12" => NULL,
            ":id13" => mysql_real_escape_string($jsondata["regisfee"]),
            ":id14" => mysql_real_escape_string($jsondata["servtax"]),
            ":id15" => mysql_real_escape_string($jsondata["addressline"]),
            ":id16" => mysql_real_escape_string($jsondata["street"]),
            ":id17" => mysql_real_escape_string($jsondata["city"]),
            ":id18" => mysql_real_escape_string($jsondata["district"]),
            ":id19" => mysql_real_escape_string($jsondata["state"]),
            ":id20" => NULL,
            ":id21" => mysql_real_escape_string($jsondata["country"]),
            ":id22" => NULL,
            ":id23" => mysql_real_escape_string($jsondata["zipcode"]),
            ":id24" => mysql_real_escape_string($jsondata["website"]),
            ":id25" => mysql_real_escape_string($jsondata["gmapurl"]),
            ":id26" => mysql_real_escape_string($jsondata["stat"]),
            ":id27" => mysql_real_escape_string($jsondata["db_name"]),
            ":id28" => mysql_real_escape_string($photo_id),
        ));
        $gym_pk = $this->db->lastInsertId();
        $data = array();
        if (count($jsondata["emails"]["mail"]) > 0) {
            for ($i = 0; $i < count($jsondata["emails"]["mail"]); $i++) {
                $data[] = array(
                    "user_pk" => $gym_pk,
                    "email" => $jsondata["emails"]["mail"][$i],
                );
            }
            $datafields = array("`gym_id`", "`email`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $query2 = 'INSERT INTO `gym_email_ids` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute($insert_values);
        }
        $data = array();
        if (count($jsondata["cellnumner"]["num"]) > 0) {
            for ($i = 0; $i < count($jsondata["cellnumner"]["num"]); $i++) {
                $data[] = array(
                    "gym_id" => $gym_pk,
                    "cell_code" => $jsondata["cellnumner"]["cod"][$i],
                    "cell_number" => $jsondata["cellnumner"]["num"][$i],
                );
            }
            $datafields = array("`gym_id`", "`cell_code`", "`cell_number`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $query3 = 'INSERT INTO `gym_cell_numbers` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute($insert_values);
        }
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_gym_' . $gym_pk);
        $query4 = 'UPDATE `gym_profile` SET `directory` = :id1 WHERE `id`= :id2;';
        $stm4 = $this->db->prepare($query4);
        $res4 = $stm4->execute(array(
            ":id1" => $directory,
            ":id2" => $gym_pk
        ));
        $query5 = 'INSERT INTO `user_profile_gym_profile` VALUES (NULL,\'' . mysql_real_escape_string($this->UserId) . '\',\'' . mysql_real_escape_string($gym_pk) . '\',\'4\');';
        $stm5 = $this->db->prepare($query5);
        $res5 = $stm5->execute();
        $dbname = mysql_real_escape_string($jsondata["db_name"]);
        $query6 = 'CALL slaveDbCreate("' . $dbname . '");';
        $stm6 = $this->db->prepare($query6);
        $res6 = $stm6->execute();
        if ($res1 && $res4 && $res5 && $res6) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["imgstatus"] = "success";
            $jsondata["id"] = $gym_pk;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ListGym() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        $searchqr = ' AND (ad.`gym_name`    LIKE :col1
                        OR ad.`gym_type`    LIKE :col2
                        OR ue.`email`   LIKE :col3
                        OR ad.`telephone`   LIKE :col4
                        OR ucn.`cell_number`    LIKE :col5
                        OR ad.`reg_fee`     LIKE :col6
                        OR ad.`addressline`     LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`gym_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`gym_type` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ue.`email` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`telephone` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ucn.`cell_number` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`reg_fee` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`addressline` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS gymid,
            ad.`gym_name` AS gymname,
            ad.`gym_type` AS gymtype,
            ue.`email` AS gymemail,
            ad.`telephone` AS gymphone,
            ucn.`cell_number` AS gymcell,
            ad.`reg_fee` AS gymregfee,
            ad.`addressline` AS gymaddr
            FROM `gym_profile` AS ad
         LEFT JOIN `gym_email_ids` AS ue ON ue.`gym_id` = ad.`id`
         LEFT JOIN `gym_cell_numbers` AS ucn ON ucn.`gym_id` = ad.`id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ue.`status` = 4
        AND ucn.`status` = 4' . $searchqr . ' GROUP BY (ad.`id`) ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col5', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col6', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col7', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Gym Name" => ucfirst($result[$i]["gymname"]),
                        "Gym Type" => $result[$i]["gymtype"],
                        "Email" => $result[$i]["gymemail"],
                        "Telephone" => $result[$i]["gymphone"],
                        "Cell Number" => $result[$i]["gymcell"],
                        "Registration Fee" => $result[$i]["gymregfee"],
                        "Address" => $result[$i]["gymaddr"],
                        "View" => '<a href="' . $this->config["URL"] . $this->config["CTRL_35"] . 'ViewGym/' . base64_encode($result[$i]["gymid"]) . '" target="_self" class="btn btn-block btn-info">View<a>',
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_35"] . 'EditGym/' . base64_encode($result[$i]["gymid"]) . '" target="_self" class="btn btn-block btn-warning">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_35"] . 'DeleteGym/' . base64_encode($result[$i]["gymid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
                    ));
                }
                $listusers["draw"] = $this->postBaseData["draw"];
                $listusers["recordsTotal"] = $num_posts;
                $listusers["recordsFiltered"] = $num_posts;
                $listusers["data"] = $data;
                /* Chop Array */
                $initial = isset($this->postBaseData["start"]) ? (integer) $this->postBaseData["start"] : 0;
                $final = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"] + $initial) : (10 + $initial);
                $length = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"]) : 10;
                $listusers["data"] = array_slice($data, $initial, $this->postBaseData["length"]);
            }
        }
        return $listusers;
    }
    public function GymSearch() {
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'usrCheck',
            "status" => 'error'
        );
        $searchqr = ' AND (ad.`gym_name`    LIKE :col1
                        OR ad.`gym_type`    LIKE :col2
                        OR ue.`email`   LIKE :col3
                        OR ad.`telephone`   LIKE :col4
                        OR ucn.`cell_number`    LIKE :col5
                        OR ad.`reg_fee`     LIKE :col6
                        OR (SELECT CONCAT(ad.`addressline`, ad.`town`, ad.`city`, ad.`district`, ad.`province` , ad.`country` , ad.`zipcode`) AS addrs)     LIKE :col7)';
        $query = 'SELECT
            ad.`id` AS gymid,
            ad.`gym_name` AS gymname,
            ad.`gym_type` AS gymtype,
            ue.`email` AS gymemail,
            ad.`telephone` AS gymphone,
            ucn.`cell_number` AS gymcell,
            ad.`reg_fee` AS gymregfee,
            ad.`addressline` AS gymaddr,
            /*Facilities*/
            (SELECT 0) AS facilities,
            /*Offers*/
            (SELECT 0) AS offers,
            /*Packages*/
            (SELECT 0) AS packages,
            CASE WHEN ad.`short_logo` IS NULL OR ad.`short_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS short_logo,
            CASE WHEN ad.`header_logo` IS NULL OR ad.`header_logo`  = "" OR ph2.`ver3` IS NULL OR ph2.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph2.`ver2`)
            END AS header_logo,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph3.`ver3` IS NULL OR ph3.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph3.`ver3`)
            END AS photo
        FROM `gym_profile` AS ad
         LEFT JOIN `gym_email_ids` AS ue ON ue.`gym_id` = ad.`id`
         LEFT JOIN `gym_cell_numbers` AS ucn ON ucn.`gym_id` = ad.`id`
         LEFT JOIN `gym_photo` AS ph1 ON ad.`short_logo` = ph1.`id`
         LEFT JOIN `gym_photo` AS ph2 ON ad.`header_logo` = ph2.`id`
         LEFT JOIN `gym_photo` AS ph3 ON ad.`photo_id` = ph3.`id`
         INNER JOIN `user_profile_gym_profile` AS up_gp ON (ad.`id` = up_gp.`gym_id`)
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ue.`status` = 4
        AND up_gp.`status` = 4
        AND up_gp.`user_pk` = ' . mysql_real_escape_string($this->UserId) . '
        ' . $searchqr . ' GROUP BY (ad.`id`)  ORDER BY (ad.`id`) DESC';
        $stm = $this->db->prepare($query);
        if (isset($this->postBaseData["q"]))
            $keyword = "%" . mysql_real_escape_string($this->postBaseData["q"]) . "%";
        else
            $keyword = "%%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col5', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col6', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col7', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["gymname"]; $i++) {
            $result[$i]["gymregfee"] = $result[$i]["gymregfee"] ? (integer) $result[$i]["gymregfee"] : 0;
            $result[$i]["facilities"] = $result[$i]["facilities"] ? (integer) $result[$i]["facilities"] : 0;
            $result[$i]["offers"] = $result[$i]["offers"] ? (integer) $result[$i]["offers"] : 0;
            $result[$i]["packages"] = $result[$i]["packages"] ? (integer) $result[$i]["packages"] : 0;
            array_push($data["items"], array(
                "index" => ($i + 1),
                "text" => $result[$i]["gymname"],
                //"id" => (integer) $result[$i]["pk"],
                "id" => $this->config["URL"] . $this->config["CTRL_35"] . 'SetGym/' . $result[$i]["gymid"],
                "name" => $result[$i]["gymname"],
                "avatar_url" => $result[$i]["short_logo"],
                "email" => $result[$i]["gymemail"],
                "cell" => $result[$i]["gymcell"],
                "ch_count" => (integer) $result[$i]["gymregfee"],
                "p_count" => (integer) $result[$i]["facilities"],
                "pc_count" => (integer) $result[$i]["offers"],
                "pcr_count" => (integer) $result[$i]["packages"],
            ));
        }
        return $data;
    }
    public function UserSearch() {
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'usrCheck',
            "status" => 'error'
        );
        $searchqr = '  AND (ad.`user_name`    LIKE :col1
                        OR ad.`email_id`    LIKE :col2
                        OR ad.`cell_number`    LIKE :col3
                        OR ut.`usertype_id`     LIKE :col4)';
        $query = 'SELECT
            ad.`id` AS usrid,
            ad.`user_name` AS usrname,
            ad.`email_id` AS usremail,
            ad.`cell_number` AS usrcell,
            ut.`usertype_id` AS usrtype
        FROM `user_profile` AS ad
        LEFT JOIN `userprofile_type` AS ut ON ut.`user_pk` = ad.`id`
        WHERE ut.`usertype_id` = 1
        AND (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ut.`status` = 4
        ' . $searchqr . ' GROUP BY (ad.`id`)  ORDER BY (ad.`id`) DESC';
        $stm = $this->db->prepare($query);
        if (isset($this->postBaseData["q"]))
            $keyword = "%" . mysql_real_escape_string($this->postBaseData["q"]) . "%";
        else
            $keyword = "%%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        return $data;
    }
    public function GymPanelView() {
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'usrCheck',
            "status" => 'error'
        );
        $query = 'SELECT
            ad.`id` AS gymid,
            ad.`gym_name` AS gymname,
            ad.`gym_type` AS gymtype,
            ue.`email` AS gymemail,
            ad.`telephone` AS gymphone,
            ucn.`cell_number` AS gymcell,
            ad.`reg_fee` AS gymregfee,
            ad.`addressline` AS gymaddr,
            /*Facilities*/
            (SELECT 0) AS facilities,
            /*Offers*/
            (SELECT 0) AS offers,
            /*Packages*/
            (SELECT 0) AS packages,
            CASE WHEN ad.`short_logo` IS NULL OR ad.`short_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS short_logo,
            CASE WHEN ad.`header_logo` IS NULL OR ad.`header_logo`  = "" OR ph2.`ver3` IS NULL OR ph2.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph2.`ver2`)
            END AS header_logo,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph3.`ver3` IS NULL OR ph3.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph3.`ver3`)
            END AS photo
        FROM `gym_profile` AS ad
         LEFT JOIN `gym_email_ids` AS ue ON ue.`gym_id` = ad.`id`
         LEFT JOIN `gym_cell_numbers` AS ucn ON ucn.`gym_id` = ad.`id`
         LEFT JOIN `gym_photo` AS ph1 ON ad.`short_logo` = ph1.`id`
         LEFT JOIN `gym_photo` AS ph2 ON ad.`header_logo` = ph2.`id`
         LEFT JOIN `gym_photo` AS ph3 ON ad.`photo_id` = ph3.`id`
         INNER JOIN `user_profile_gym_profile` AS up_gp ON (ad.`id` = up_gp.`gym_id`)
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND (ad.`status` = 4 AND ue.`status` = 4 AND up_gp.`status` = 4 AND up_gp.`user_pk` = "' . mysql_real_escape_string($this->UserId) . '" )
        GROUP BY (ad.`id`)  ORDER BY (ad.`id`) DESC';
        //var_dump($query);
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["gymname"]; $i++) {
            $result[$i]["gymregfee"] = $result[$i]["gymregfee"] ? (integer) $result[$i]["gymregfee"] : 0;
            $result[$i]["facilities"] = $result[$i]["facilities"] ? (integer) $result[$i]["facilities"] : 0;
            $result[$i]["offers"] = $result[$i]["offers"] ? (integer) $result[$i]["offers"] : 0;
            $result[$i]["packages"] = $result[$i]["packages"] ? (integer) $result[$i]["packages"] : 0;
            array_push($data["items"], array(
                "index" => ($i + 1),
                "text" => $result[$i]["gymname"],
                //"id" => (integer) $result[$i]["pk"],
                "id" => $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["gymid"]),
                "name" => $result[$i]["gymname"],
                "avatar_url" => $result[$i]["short_logo"],
                "email" => $result[$i]["gymemail"],
                "cell" => $result[$i]["gymcell"],
                "ch_count" => (integer) $result[$i]["gymregfee"],
                "p_count" => (integer) $result[$i]["facilities"],
                "pc_count" => (integer) $result[$i]["offers"],
                "pcr_count" => (integer) $result[$i]["packages"],
            ));
        }
        return $data;
    }
    public function EditGym() {
        $res1 = NULL;
        $res2 = NULL;
        $res3 = NULL;
        $jsondata = array(
            "id" => base64_decode($this->postBaseData["gymid"]),
            "gymtype" => $this->postBaseData["gymtype"],
            "gymname" => $this->postBaseData["gymname"],
            "regisfee" => $this->postBaseData["regisfee"],
            "servtax" => $this->postBaseData["servtax"],
            "telecode" => $this->postBaseData["telecode"],
            "telephone" => $this->postBaseData["telephone"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "district" => $this->postBaseData["district"],
            "city" => $this->postBaseData["city"],
            "street" => $this->postBaseData["street"],
            "addressline" => $this->postBaseData["addressline"],
            "zipcode" => $this->postBaseData["zipcode"],
            "gmapurl" => $this->postBaseData["gmapurl"],
            "website" => $this->postBaseData["website"],
            "emails" => (array) json_decode($this->postBaseData["emails"]),
            "cellnumner" => (array) json_decode($this->postBaseData["cellnumner"]),
            "db_host" => $this->config["DBHOST"],
            "db_user" => $this->config["DBUSER"],
            "db_name" => 'tamboola_' . $this->generateRandomString(),
            "db_pass" => $this->config["DBPASS"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $query1 = 'UPDATE `gym_profile` SET
                                            `gym_name`=:id1,
                                            `gym_type`=:id2,
                                            `db_host`=:id3,
                                            `db_username`=:id4,
                                            `db_password`=:id5,
                                            `postal_code`=:id6,
                                            `telephone`=:id7,
                                            `reg_fee`=:id8,
                                            `service_tax`=:id9,
                                            `addressline`=:id10,
                                            `town`=:id11,
                                            `city`=:id12,
                                            `district`=:id13,
                                            `province`=:id14,
                                            `country`=:id15,
                                            `zipcode`=:id16,
                                            `website`=:id17,
                                            `status`=:id18
                                             WHERE `id`=:id';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id" => mysql_real_escape_string($jsondata["id"]),
            ":id1" => mysql_real_escape_string($jsondata["gymname"]),
            ":id2" => mysql_real_escape_string($jsondata["gymtype"]),
            // ":id3" => mysql_real_escape_string($jsondata["db_host"]),
            //":id4" => mysql_real_escape_string($jsondata["db_user"]),
            //":id5" => mysql_real_escape_string($jsondata["db_pass"]),
            ":id6" => mysql_real_escape_string($jsondata["telecode"]),
            ":id7" => mysql_real_escape_string($jsondata["telephone"]),
            ":id8" => mysql_real_escape_string($jsondata["regisfee"]),
            ":id9" => mysql_real_escape_string($jsondata["servtax"]),
            ":id10" => mysql_real_escape_string($jsondata["addressline"]),
            ":id11" => mysql_real_escape_string($jsondata["street"]),
            ":id12" => mysql_real_escape_string($jsondata["city"]),
            ":id13" => mysql_real_escape_string($jsondata["district"]),
            ":id14" => mysql_real_escape_string($jsondata["state"]),
            ":id15" => mysql_real_escape_string($jsondata["country"]),
            ":id16" => mysql_real_escape_string($jsondata["zipcode"]),
            ":id17" => mysql_real_escape_string($jsondata["website"]),
            ":id18" => mysql_real_escape_string($jsondata["stat"]),
        ));
        if (count($jsondata["emails"]["mail"]) > 0) {
            for ($i = 0; $i < count($jsondata["emails"]["mail"]); $i++) {
                $query2 = 'UPDATE `gym_email_ids` SET
                              `email`=:id1,
                              `status`=:id2
                               WHERE `id`=:id3';
                $stm2 = $this->db->prepare($query2);
                $res2 = $stm2->execute(array(
                    ":id1" => mysql_real_escape_string($jsondata["emails"]["mail"][$i]),
                    ":id2" => mysql_real_escape_string($jsondata["stat"]),
                    ":id3" => mysql_real_escape_string($jsondata["id"]),
                ));
            }
        }
        if (count($jsondata["cellnumner"]["num"]) > 0) {
            for ($i = 0; $i < count($jsondata["cellnumner"]["num"]); $i++) {
                $query3 = 'UPDATE `gym_cell_numbers` SET
                  `cell_code`=:id1,
                  `cell_number`=:id2,
                  `status`=:id3
                  WHERE `id`=:id';
                $stm3 = $this->db->prepare($query3);
                $res3 = $stm3->execute(array(
                    ":id1" => mysql_real_escape_string($jsondata["cellnumner"]["cod"][$i]),
                    ":id2" => mysql_real_escape_string($jsondata["cellnumner"]["num"][$i]),
                    ":id3" => mysql_real_escape_string($jsondata["stat"]),
                    ":id" => mysql_real_escape_string($jsondata["id"])
                ));
            }
        }
        if (isset($_SESSION["GYM_DETAILS"]) && !file_exists($this->config["DOC_ROOT"] . $_SESSION["GYM_DETAILS"]["gdir"])) {
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_gym_' . $id);
            $query4 = 'UPDATE `gym_profile` SET `directory` = :id1 WHERE `id`=:id2';
            $stm4 = $this->db->prepare($query4);
            $res4 = $stm4->execute(array(
                ":id1" => mysql_real_escape_string($directory),
                ":id2" => mysql_real_escape_string($jsondata["id"])
            ));
            $_SESSION["GYM_DETAILS"]["gdir"] = $directory;
        }
        if ($res1 && $res2 && $res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function DeleteGymDetails($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `gym_profile` SET
                         `status` = :stat
                          WHERE `id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
        ));
        if ($res) {
            $this->db->commit();
            $jsondata["status"] = "success";
            echo "<script>
                  alert('Successfully deleted');
                  window.history.back();
                  </script>";
            exit;
        } else {
            $jsondata["status"] = "error";
            echo '<script language="javascript">';
            echo 'alert("Not deleted")';
            echo '</script>';
        }
        return $jsondata;
    }
}
?>