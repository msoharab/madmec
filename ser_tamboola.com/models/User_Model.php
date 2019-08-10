<?php
class User_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
    public function AddUser() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "pass" => $this->generateRandomString(),
            "dob" => $this->postBaseData["dob"],
            "gender" => $this->postBaseData["gender"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "proof_id" => $this->postBaseData["proof_id"],
            "proof_type" => $this->postBaseData["proof_type"],
            "usertype" => $this->postBaseData["usertype"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $stm = $this->db->prepare('SELECT * FROM `users` WHERE `user_name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `users` WHERE `user_name`= :name AND `user_status_id`=:stat');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":stat" => 6
        ));
        $c = $stm->rowCount();
            if ($c > 0) {
            $stm2 = $this->db->prepare('UPDATE `users` SET `user_status_id`=:stat,
                    `user_updated_at` = :id1 WHERE `user_name`= :name');
            $res2 = $stm2->execute(array(
            ":stat" => ($jsondata["stat"]),
            ":id1" => date("Y-m-d H:i:s"),
            ":name" => ($jsondata["name"])
             ));
            $jsondata["status"] = "success";
            }
            else {
            $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            /* User profile pic */
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => NULL
            ));
            $picid = $this->db->lastInsertId();
            /* User proof pic */
            $query4 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm4 = $this->db->prepare($query4);
            $res4 = $stm4->execute(array(
                ":id" => NULL
            ));
            $proof_pic_id = $this->db->lastInsertId();
            $query4 = 'INSERT INTO  `users_proof` (
                    `users_proof_id`,
                    `users_proof_portal_proof_id`,
                    `users_proof_code`,
                    `users_proof_pic`)  VALUES('
                    . ':id1,
                      :id2,
                      :id3,
                      :id4);';
            $stm4 = $this->db->prepare($query4);
            $res4 = $stm4->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["proof_type"]),
                ":id3" => ($jsondata["proof_id"]),
                ":id4" => ($proof_pic_id)
            ));
            $proof_id = $this->db->lastInsertId();
            /* Users */
            $query2 = 'INSERT INTO `users`(
                        `user_pk`,
                        `user_name`,
                        `user_proof_id`,
                        `user_photo_id`,
                        `user_password`,
                        `user_apassword`,
                        `user_authenticatkey`,
                        `user_dob`,
                        `user_gender`,
                        `user_type_id`,
                        `user_addressline`,
                        `user_street_loc`,
                        `user_city`,
                        `user_district`,
                        `user_province`,
                        `user_country`,
                        `user_zipcode`,
                        `user_status_id`)Values(
                         :id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        MD5(:id6),
                        MD5(:id7),
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
                        :id18)';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["name"]),
                ":id3" => ($proof_id),
                ":id4" => ($picid),
                ":id5" => ($jsondata["pass"]),
                ":id6" => ($jsondata["pass"]),
                ":id7" => (time()),
                ":id8" => ($jsondata["dob"]),
                ":id9" => ($jsondata["gender"]),
                ":id10" => ($jsondata["usertype"]),
                ":id11" => ($jsondata["addline"]),
                ":id12" => ($jsondata["stloc"]),
                ":id13" => ($jsondata["city"]),
                ":id14" => ($jsondata["distct"]),
                ":id15" => ($jsondata["state"]),
                ":id16" => ($jsondata["country"]),
                ":id17" => ($jsondata["zipc"]),
                ":id18" => ($jsondata["stat"])
            ));
            $user_pk = $this->db->lastInsertId();
            if (($jsondata["email"]) != null) {
                $query8 = 'INSERT INTO `users_email_ids`(
                    `users_email_ids_id`,
                    `users_email_ids_user_pk`,
                    `users_email_ids_email`)Values('
                        . ':id1,
                        :id2,
                        :id3)';
                $stm8 = $this->db->prepare($query8);
                $res8 = $stm8->execute(array(
                    ":id1" => NULL,
                    ":id2" => $user_pk,
                    ":id3" => ($jsondata["email"])
                ));
            }
            $q = 'SELECT * FROM `portal_countries` WHERE `portal_countries_Country`=:country';
            $s = $this->db->prepare($q);
            $r = $s->execute(array(
                ":country" => ($jsondata["country"])
            ));
            $r = $s->execute();
            if ($r) {
                $result = $s->fetchAll();
                $data["data"] = $result;
            }
            $query6 = 'INSERT INTO `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_user_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                    . ':id1,
                    :id2,
                    :id3,
                    :id4)';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => NULL,
                ":id2" => $user_pk,
                ":id3" => $result[0]["portal_countries_Phone"],
                ":id4" => ($jsondata["mobile1"])
            ));
            if (($jsondata["mobile2"]) != null) {
                $query7 = 'INSERT INTO `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_user_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                        . ':id1,
                    :id2,
                    :id3,
                    :id4)';
                $stm7 = $this->db->prepare($query7);
                $res7 = $stm7->execute(array(
                    ":id1" => NULL,
                    ":id2" => $user_pk,
                    ":id3" => $result[0]["portal_countries_Phone"],
                    ":id4" => ($jsondata["mobile2"])
                ));
            }
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query3 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `user_pk`=:id2';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => ($directory),
                ":id2" => $user_pk
            ));
            if (isset($this->postBaseFile['file'])) {
                $verImages = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'],
                    "file_size" => $this->postBaseFile['file']['size'],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'],
                    "file_type" => $this->postBaseFile['file']['type'],
                    "directory" => $directory,
                    "target" => 'profile',
                    "picid" => (integer) $proof_pic_id,
                ));
                if ($verImages["status"] == "error") {
                    $pic_flag = false;
                }
            }
            /* User Money */
            $query5 = 'INSERT INTO  `users_money` (`users_money_user_pk`)  VALUES(:id);';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id" => ($user_pk)
            ));
            $money_id = $this->db->lastInsertId();
            if ($res1 && $res2 && $res3 && $res4 && $pic_flag && $res5 && $res6) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddUserCompany($id = false) {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "pass1" => $this->postBaseData["pass1"],
            "pass2" => $this->postBaseData["pass2"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "utype" => $this->postBaseData["utype"],
            "stat" => 1,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `user_name` FROM `users` WHERE `user_name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            /* User profile pic */
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => ($id)
            ));
            $picid = $this->db->lastInsertId();
            /* Users */
            $query2 = 'UPDATE `users`(
                        `user_pk`,
                        `user_name`,
                        `user_photo_id`,
                        `user_password`,
                        `user_apassword`,
                        `user_authenticatkey`,
                        `user_type_id`,
                        `user_status_id`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        MD5(:id5),
                        MD5(:id6),
                        :id7,
                        :id8)';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => ($id),
                ":id2" => ($jsondata["name"]),
                ":id3" => ($picid),
                ":id4" => ($jsondata["pass1"]),
                ":id5" => ($jsondata["pass2"]),
                ":id6" => (time()),
                ":id7" => ($jsondata["utype"]),
                ":id8" => ($jsondata["stat"])
            ));
            $user_pk = ($id);
            if (($jsondata["email"]) != null) {
                $query4 = 'UPDATE `users_email_ids`(
                    `users_email_ids_id`,
                    `users_email_ids_user_pk`,
                    `users_email_ids_email`)Values('
                        . ':id1,
                        :id2,
                        :id3)';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => ($id),
                    ":id2" => $user_pk,
                    ":id3" => ($jsondata["email"])
                ));
            }
            $query6 = 'UPDATE `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_user_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                    . ':id1,
                    :id2,
                    :id3,
                    :id4)';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => ($id),
                ":id2" => $user_pk,
                ":id3" => NULL,
                ":id4" => ($jsondata["mobile1"])
            ));
            if (($jsondata["mobile2"]) != null) {
                $query7 = 'UPDATE `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_user_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                        . ':id1,
                    :id2,
                    :id3,
                    :id4)';
                $stm7 = $this->db->prepare($query7);
                $res7 = $stm7->execute(array(
                    ":id1" => ($id),
                    ":id2" => $user_pk,
                    ":id3" => NULL,
                    ":id4" => ($jsondata["mobile2"])
                ));
            }
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query3 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `user_pk`=:id2';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => ($directory),
                ":id2" => $user_pk
            ));
            /* User Money */
            $query5 = 'UPDATE  `users_money` (`users_money_user_pk`)  VALUES(:id);';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id" => ($user_pk)
            ));
            $money_id = $this->db->lastInsertId();
            /* company */
            $query7 = 'INSERT INTO `users_company`(
                  `users_company_id`,
                  `users_company_user_pk`,
                  `users_company_company_id`)Values('
                    . ':id1,
                    :id2,
                    :id3)';
            $stm7 = $this->db->prepare($query7);
            $res7 = $stm7->execute(array(
                ":id1" => NULL,
                ":id2" => $user_pk,
                ":id3" => $_SESSION["DEFAULT_COMPANY"]
            ));
            if ($res1 && $res2 && $res3 && $res5 && $res6 && $res7) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function ListUserPersonal() {
//        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        $searchqr = ' AND (ad.`user_name`           LIKE :col1
                        OR ue.`users_email_ids_email`          LIKE :col2
                        OR ucn.`users_cell_numbers_cell_number`    LIKE :col3
                        OR up. `users_proof_code`     LIKE :col4
                        OR pp.`portal_proof_name`      LIKE :col5
                        OR t2.`type`     LIKE :col6)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`user_pk` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ue.`users_email_ids_email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ucn.`users_cell_numbers_cell_number` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY up. `users_proof_code` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY pp.`portal_proof_name` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t2.`type` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`user_pk` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`user_pk` AS replyererid,
            ad.`user_name` AS replyername,
            ue.`users_email_ids_email` AS replyeremail,
            ucn.`users_cell_numbers_cell_number` AS replyercell,
            up.`users_proof_code` AS pid,
            pp.`portal_proof_name` AS ptype,
            IF(up.`users_proof_pic` IS NOT NULL OR up.`users_proof_pic` != NULL,   (SELECT
                    CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                    END AS pic
                FROM `portal_photo` AS ph1
                WHERE up.`users_proof_pic` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS ppic,
            t2.`type`
            FROM `users` AS ad
         LEFT JOIN `users_email_ids` AS ue ON ad.`user_pk` = ue.`users_email_ids_user_pk`
         LEFT JOIN `users_cell_numbers` AS ucn ON ad.`user_pk` = ucn.`users_cell_numbers_user_pk`
        LEFT JOIN `users_type` AS t2 ON ad.`user_type_id` = t2.`users_type_id`
        LEFT JOIN `users_proof` AS up ON ad.`user_proof_id` = up.`users_proof_id`
        LEFT JOIN `portal_proof` AS pp ON up.`users_proof_portal_proof_id` = pp.`portal_proof_id`
        WHERE (ad.`user_pk` != NULL
        OR ad.`user_pk` IS NOT NULL)
        AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk`)
        AND ad.`user_status_id` = 4
        AND ad.`user_type_id` IN (3,4,5,6) ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col5', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col6', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Name" => ucfirst($result[$i]["replyername"]),
                        "Email" => $result[$i]["replyeremail"],
                        "Mobile" => $result[$i]["replyercell"],
                        "Proof ID" => $result[$i]["pid"],
                        "Proof Type" => $result[$i]["ptype"],
                        "Proof Picture" => '<a href="' . $result[$i]["ppic"] . '" target="_new" class="btn btn-block btn-warning">View<a>',
                        "User Type" => $result[$i]["type"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_15"] . 'UserEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_15"] . 'DeleteUser/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function EditUserPersonal() {
        $jsondata = array(
            "user_id" => base64_decode($this->postBaseData["user_id"]),
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "pass" => $this->generateRandomString(),
            "dob" => $this->postBaseData["dob"],
            "gender" => $this->postBaseData["gender"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "proof_id" => $this->postBaseData["proof_id"],
            "proof_type" => $this->postBaseData["proof_type"],
            "usertype" => $this->postBaseData["usertype"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $d = date("Y-m-d H:i:s");
        $stm = $this->db->prepare('SELECT `user_name` FROM `users` WHERE `user_name`= :name AND `user_pk`!=:id');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":id" => ($jsondata["user_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
        $this->db->beginTransaction();
        $q1 = 'SELECT ad.*,up.*,pp.* FROM `users` ad,`users_proof` up,`portal_photo` pp WHERE ad.`user_proof_id` = up.`users_proof_id` AND up.`users_proof_pic`=pp.`id` AND `user_pk`=:id';
        $s1 = $this->db->prepare($q1);
        $r1 = $s1->execute(array(
            ":id" => ($jsondata["user_id"])
        ));
        $r1 = $s1->execute();
        if ($r1) {
            $result1 = $s1->fetchAll();
            $data["data"] = $result1;
        }
        $proof_pic_id= $result1[0]["id"];
        $query9 = 'UPDATE `portal_photo` SET  `status_id`=:id1,
                    `portal_photo_updated_at`=:id2
                    WHERE `id`=:id3';
        $stm9 = $this->db->prepare($query9);
        $res9 = $stm9->execute(array(
            ":id1" => ($jsondata["stat"]),
            ":id2" => ($d),
            ":id3" => $result1[0]["user_photo_id"]
        ));
        /* User proof pic */
        $query = 'UPDATE `portal_photo` SET  `status_id`=:id1,
                    `portal_photo_updated_at`=:id2
                    WHERE `id`=:id3';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id1" => ($jsondata["stat"]),
            ":id2" => ($d),
            ":id3" => ($proof_pic_id)
        ));
        $query4 = 'UPDATE `users_proof` SET
                    `users_proof_portal_proof_id`=:id1,
                    `users_proof_code`=:id2,
                    `users_proof_updated_at`=:id3
                    WHERE `users_proof_id`=:id4';
        $stm4 = $this->db->prepare($query4);
        $res4 = $stm4->execute(array(
            ":id1" => ($jsondata["proof_type"]),
            ":id2" => ($jsondata["proof_id"]),
            ":id3" => ($d),
            ":id4" => $result1[0]["user_proof_id"]
        ));
        /* Users */
        $query1 = 'UPDATE `users` SET
                        `user_name`=:id2,
                        `user_password`=:id3,
                        `user_apassword`=MD5(:id4),
                        `user_authenticatkey`=MD5(:id5),
                        `user_dob`=:id6,
                        `user_gender`=:id7,
                        `user_type_id`=:id8,
                        `user_addressline`=:id9,
                        `user_street_loc`=:id10,
                        `user_city`=:id11,
                        `user_district`=:id12,
                        `user_province`=:id13,
                        `user_country`=:id14,
                        `user_zipcode`=:id15,
                        `user_status_id`=:id16
                        WHERE `user_pk`=:id1';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => ($jsondata["user_id"]),
            ":id2" => ($jsondata["name"]),
            ":id3" => ($jsondata["pass"]),
            ":id4" => ($jsondata["pass"]),
            ":id5" => (time()),
            ":id6" => ($jsondata["dob"]),
            ":id7" => ($jsondata["gender"]),
            ":id8" => ($jsondata["usertype"]),
            ":id9" => ($jsondata["addline"]),
            ":id10" => ($jsondata["stloc"]),
            ":id11" => ($jsondata["city"]),
            ":id12" => ($jsondata["distct"]),
            ":id13" => ($jsondata["state"]),
            ":id14" => ($jsondata["country"]),
            ":id15" => ($jsondata["zipc"]),
            ":id16" => ($jsondata["stat"])
        ));
        if (($jsondata["email"]) != null) {
            $query2 = 'UPDATE `users_email_ids` SET
                        `users_email_ids_email`=:id1,
                        `users_email_ids_updated_at`=:id2
                        WHERE `users_email_ids_user_pk`=:id3';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => ($jsondata["email"]),
                ":id2" => ($d),
                ":id3" => ($jsondata["user_id"])
            ));
        }
        $q = 'SELECT * FROM `portal_countries` WHERE `portal_countries_Country`=:country';
        $s = $this->db->prepare($q);
        $r = $s->execute(array(
            ":country" => ($jsondata["country"])
        ));
        $r = $s->execute();
        if ($r) {
            $result = $s->fetchAll();
            $data["data"] = $result;
        }
        $se = $this->db->prepare('SELECT * FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`=:id');
        $re = $se->execute(array(
            ":id" => ($jsondata["user_id"])
        ));
        $re = $se->execute();
        if ($re) {
            $result2 = $se->fetchAll();
            $data["data"] = $result2;
        }
        $c = $se->rowCount();
        $query3 = 'UPDATE `users_cell_numbers` SET
                  `users_cell_numbers_cell_code`=:id1,
                  `users_cell_numbers_cell_number`=:id2,
                  `users_cell_numbers_updated_at`=:id3
                  WHERE `users_cell_numbers_id`=:id4';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => $result[0]["portal_countries_Phone"],
            ":id2" => ($jsondata["mobile1"]),
            ":id3" => ($d),
            ":id4" => $result2[0]["users_cell_numbers_id"]
        ));
        if (($jsondata["mobile2"]) != null) {
            if ($c > 1) {
                $stm6 = $this->db->prepare('UPDATE `users_cell_numbers` SET
               `users_cell_numbers_cell_code`=:id2,
               `users_cell_numbers_cell_number`=:id3,
               `users_cell_numbers_updated_at`=:id4
               WHERE `users_cell_numbers_id`=:id1 AND `users_cell_numbers_user_pk`=:id5');
                $res6 = $stm6->execute(array(
                    ":id1" => $result2[1]["users_cell_numbers_id"],
                    ":id2" => $result[0]["portal_countries_Phone"],
                    ":id3" => ($jsondata["mobile2"]),
                    ":id4" => ($d),
                    ":id5" => ($jsondata["user_id"])
                ));
            } else {
                $stm6 = $this->db->prepare('INSERT INTO `users_cell_numbers`(
                    `users_cell_numbers_user_pk`,
                    `users_cell_numbers_cell_code`,
                    `users_cell_numbers_cell_number`) VALUES (
                    :id5,
                    :id2,
                    :id3)');
                $res6 = $stm6->execute(array(
                    ":id2" => $result[0]["portal_countries_Phone"],
                    ":id3" => ($jsondata["mobile2"]),
                    ":id5" => ($jsondata["user_id"])
                ));
            }
        }
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $jsondata["user_id"]);
        $query5 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `user_pk`=:id2';
        $stm5 = $this->db->prepare($query5);
        $res5 = $stm5->execute(array(
            ":id1" => ($directory),
            ":id2" => ($jsondata["user_id"])
        ));
        if (isset($this->postBaseFile['file'])) {
                $verImages = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'],
                    "file_size" => $this->postBaseFile['file']['size'],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'],
                    "file_type" => $this->postBaseFile['file']['type'],
                    "directory" => $directory,
                    "target" => 'profile',
                    "picid" => (integer) $proof_pic_id,
                ));
                if ($verImages["status"] == "error") {
                    $pic_flag = false;
                }
            }
        if ($res1 && $res3 && $pic_flag && $res5 && $res && $res9 && $res6 && $res4) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
    }
        return $jsondata;
    }
    public function AddBusinessDetails() {
        $jsondata = array(
            "user_pk" => $this->postBaseData["user_pk"],
            "bname" => $this->postBaseData["bname"],
            "doc" => $this->postBaseData["doc"],
            "oname" => $this->postBaseData["oname"],
            "websiet" => $this->postBaseData["websiet"],
            "acname" => $this->postBaseData["acname"],
            "acno" => $this->postBaseData["acno"],
            "acifsc" => $this->postBaseData["acifsc"],
            "bnkame" => $this->postBaseData["bnkame"],
            "bnkcode" => $this->postBaseData["bnkcode"],
            "bbrname" => $this->postBaseData["bbrname"],
            "bbrcode" => $this->postBaseData["bbrcode"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "bproof_id" => $this->postBaseData["bproof_id"],
            "bproof_type" => $this->postBaseData["bproof_type"],
            "adproof_id" => $this->postBaseData["adproof_id"],
            "adproof_type" => $this->postBaseData["adproof_type"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $directory = '';
        $this->db->beginTransaction();
        /* User business proof pic */
        $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
        $stm = $this->db->prepare($query1);
        $res1 = $stm->execute(array(
            ":id" => NULL
        ));
        $proof_pic_id1 = $this->db->lastInsertId();
        /* User address proof pic */
        $query2 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
        $stm = $this->db->prepare($query2);
        $res2 = $stm->execute(array(
            ":id" => NULL
        ));
        $proof_pic_id2 = $this->db->lastInsertId();
        $query6 = 'INSERT INTO  `users_proof` (
                    `users_proof_id`,
                    `users_proof_portal_proof_id`,
                    `users_proof_code`,
                    `users_proof_pic`)  VALUES('
                . ':id1,
                      :id2,
                      :id3,
                      :id4);';
        $stm6 = $this->db->prepare($query6);
        $res6 = $stm6->execute(array(
            ":id1" => NULL,
            ":id2" => ($jsondata["bproof_id"]),
            ":id3" => ($jsondata["bproof_id"]),
            ":id4" => ($proof_pic_id1)
        ));
        $proof_id1 = $this->db->lastInsertId();
        $query7 = 'INSERT INTO  `users_proof` (
                    `users_proof_id`,
                    `users_proof_portal_proof_id`,
                    `users_proof_code`,
                    `users_proof_pic`)  VALUES('
                . ':id1,
                      :id2,
                      :id3,
                      :id4);';
        $stm7 = $this->db->prepare($query7);
        $res7 = $stm7->execute(array(
            ":id1" => NULL,
            ":id2" => ($jsondata["adproof_type"]),
            ":id3" => ($jsondata["adproof_id"]),
            ":id4" => ($proof_pic_id2)
        ));
        $proof_id2 = $this->db->lastInsertId();
        /* User business details */
        $query3 = 'INSERT INTO  `users_business`(
                        `users_business_user_pk`,
                        `users_business_name`,
                        `users_business_oname`,
                        `users_business_established`,
                        `users_business_proof_id`,
                        `users_business_website`)Values('
                . ' :id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6)';
        $stm = $this->db->prepare($query3);
        $res3 = $stm->execute(array(
            ":id1" => ($jsondata["user_pk"]),
            ":id2" => ($jsondata["bname"]),
            ":id3" => ($jsondata["oname"]),
            ":id4" => ($jsondata["doc"]),
            ":id5" => ($proof_id1),
            ":id6" => ($jsondata["websiet"])
        ));
        $business_id = $this->db->lastInsertId();
        /* User business bank account details */
        $query4 = 'INSERT INTO  `users_bank_accounts` (
                        `users_bank_accounts_user_pk`,
                        `users_bank_accounts_name`,
                        `users_bank_accounts_code`,
                        `users_bank_accounts_ac_no`,
                        `users_bank_accounts_ac_name`,
                        `users_bank_accounts_IFSC`,
                        `users_bank_accounts_branch`,
                        `users_bank_accounts_branch_code`
                    )  VALUES('
                . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8
                    );';
        $stm = $this->db->prepare($query4);
        $res4 = $stm->execute(array(
            ":id1" => ($jsondata["user_pk"]),
            ":id2" => ($jsondata["bnkame"]),
            ":id3" => ($jsondata["bnkcode"]),
            ":id4" => ($jsondata["acname"]),
            ":id5" => ($jsondata["acno"]),
            ":id6" => ($jsondata["acifsc"]),
            ":id7" => ($jsondata["bbrname"]),
            ":id8" => ($jsondata["bbrcode"]),
        ));
        $business_bnk_id = $this->db->lastInsertId();
        /* User business address details */
        $query5 = 'INSERT INTO  `users_business_address` (
                        `users_business_address_users_business_id`,
                        `users_business_address_proof_id`,
                        `users_business_address_addressline`,
                        `users_business_address_town`,
                        `users_business_address_city`,
                        `users_business_address_district`,
                        `users_business_address_province`,
                        `users_business_address_country`
                    )  VALUES(
                        :id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8
                    );';
        $stm = $this->db->prepare($query5);
        $res5 = $stm->execute(array(
            ":id1" => ($business_id),
            ":id2" => ($proof_id2),
            ":id3" => ($jsondata["addline"]),
            ":id4" => ($jsondata["stloc"]),
            ":id5" => ($jsondata["city"]),
            ":id6" => ($jsondata["distct"]),
            ":id7" => ($jsondata["state"]),
            ":id8" => ($jsondata["country"]),
        ));
        $business_address_id = $this->db->lastInsertId();
        $stm = $this->db->prepare('SELECT
            t1.`user_directory`
            FROM `users` AS t1
            WHERE t1.`user_pk`= :email
            AND t1.`user_status_id` = :stat
            ');
        $res = $stm->execute(array(
            ":email" => ($jsondata["user_pk"]),
            ":stat" => 4,
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $directory = $stm->fetch();
        }
        if ($directory) {
            if (isset($this->postBaseFile['file'])) {
                $verImages1 = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'][0],
                    "file_size" => $this->postBaseFile['file']['size'][0],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'][0],
                    "file_type" => $this->postBaseFile['file']['type'][0],
                    "directory" => $this->logindata["user_directory"],
                    "target" => 'business',
                    "picid" => (integer) $proof_pic_id1,
                ));
                $verImages2 = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'][1],
                    "file_size" => $this->postBaseFile['file']['size'][1],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'][1],
                    "file_type" => $this->postBaseFile['file']['type'][1],
                    "directory" => $this->logindata["user_directory"],
                    "target" => 'business',
                    "picid" => (integer) $proof_pic_id2,
                ));
                if ($verImages1["status"] == "error" && $verImages2["status"] == "error") {
                    $pic_flag = false;
                }
            }
        }
        if ($res1 && $res2 && $res3 && $res4 && $res5 && $pic_flag && $res6 && $res7) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ListUserBusiness() {
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
        $searchqr = ' AND (ad.`users_business_name`         LIKE :col1
                        OR t1.`user_name`                   LIKE :col2
                        OR ad.`users_business_established`  LIKE :col3
                        OR ad.`users_business_stc`          LIKE :col4
                        OR ad.`users_business_tin`          LIKE :col5
                        OR ad.`users_business_website`      LIKE :col6
                        OR ad.`users_business_proof_id`     LIKE :col7
                        OR ad.`users_business_proof_type`   LIKE :col8
                        OR t2.`type`             LIKE :col9)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`users_business_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`users_business_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t1.`user_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`users_business_established` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`users_business_stc` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`users_business_tin` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`users_business_website` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`users_business_proof_id` ' . $dir;
                    break;
                case 9:
                    $orderqr = ' ORDER BY t2.`type` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`users_business_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`users_business_id` AS replyererid,
            ad.`users_business_name` AS replyername,
            t1.`user_name` AS owner,
            ad.`users_business_established` AS estd,
            ad.`users_business_stc` AS stc,
            ad.`users_business_tin` AS tin,
            ad.`users_business_website` AS website,
            ad.`users_business_proof_id` AS pid,
            ad.`users_business_proof_type` AS ptype,
            IF(ad.`users_business_proof_pic` IS NOT NULL OR ad.`users_business_proof_pic` != NULL,   (SELECT
                    CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                    END AS pic
                FROM `portal_photo` AS ph1
                WHERE ad.`users_business_proof_pic` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS ppic,
            t2.`type`
        FROM `users_business` AS ad
        LEFT JOIN `users` AS t1 ON ad.`users_business_user_pk` = t1.`user_pk`
        LEFT JOIN `users_type` AS t2 ON t2.`users_type_id` = t1.`user_type_id`
        WHERE (ad.`users_business_id` != NULL
        OR ad.`users_business_id` IS NOT NULL)
        AND ad.`users_business_status_id` = 4
        AND t1.`user_status_id` = 4
        AND t1.`user_type_id` IN (3,4,5,6,7) ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col5', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col6', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col7', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col8', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col9', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Name" => ucfirst($result[$i]["replyername"]),
                        "Owner" => $result[$i]["owner"],
                        "Established" => date("d-M-Y", strtotime($result[$i]["estd"])),
                        "STC" => $result[$i]["stc"],
                        "TIN" => $result[$i]["tin"],
                        "Website" => '<a href="' . $result[$i]["website"] . '" target="_new" class="btn btn-block btn-warning">Visit<a>',
                        "Proof ID" => $result[$i]["pid"],
                        "Proof Type" => $result[$i]["ptype"],
                        "Proof Picture" => '<a href="' . $result[$i]["ppic"] . '" target="_new" class="btn btn-block btn-warning">View<a>',
                        "User Type" => $result[$i]["type"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_15"] . 'UserBusinessEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
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
    public function UserRequestNew() {
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
        if (isset($this->postBaseData["columns"])) {
            //$this->postBaseData["columns"][]["data"]
            //$this->postBaseData["columns"][]["name"] = ''
            //$this->postBaseData["columns"][]["orderable"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["regex"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["value"] = ''
            //$this->postBaseData["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->postBaseData["search"])) {
            $searchqr = ' AND (ad.`user_name`       LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ue.`users_email_ids_email`          LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ucn.`users_cell_numbers_cell_number`    LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR t2.`type`     LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ad.`user_doj`            LIKE "%' . $this->postBaseData["search"]["value"] . '%")';
        }
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`user_pk` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ue.`users_email_ids_email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ucn.`users_cell_numbers_cell_number` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`user_doj` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t2.`type` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`user_pk` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`user_pk` AS replyererid,
            ad.`user_name` AS replyername,
            ue.`users_email_ids_email` AS replyeremail,
            ucn.`users_cell_numbers_cell_number` AS replyercell,
            t2.`type`,
            ad.`user_doj` AS doj,
            IF(ad.`user_status_id` = 1, "Accept","Reject") AS action,
            IF(ad.`user_status_id` = 1,  "btn-success","btn-danger") AS btn,
            IF(ad.`user_status_id` = 1, 4,42) AS actionid
        FROM `users` AS ad
        LEFT JOIN `users_email_ids` AS ue ON ad.`user_pk`=ue.`users_email_ids_user_pk`
        LEFT JOIN `users_cell_numbers` AS ucn ON ad.`user_pk`=ucn.`users_cell_numbers_user_pk`
        LEFT JOIN `users_type` AS t2 ON t2.`users_type_id` = ad.`user_type_id`
        WHERE (ad.`user_pk` != NULL
        OR ad.`user_pk` IS NOT NULL)
        AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk`)
        AND ad.`user_status_id` = 1
        AND ad.`user_type_id` IN (3,4,5,6,7) ' . $searchqr . ' ' . $orderqr . ' ;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    //$result[$i]["users_gender_id"]
                    array_push($data, array(
                        "Id" => $i + 1,
                        "Name" => ucfirst($result[$i]["replyername"]),
                        "Email" => $result[$i]["replyeremail"],
                        "Cell" => $result[$i]["replyercell"],
                        "Registered Date" => date("d-M-Y", strtotime($result[$i]["doj"])),
                        "User Type" => $result[$i]["type"],
                        "Action" => '<button class="btn ' . $result[$i]["btn"] . '" id="listuser_' . $result[$i]["replyererid"] . '" name="' . $result[$i]["replyererid"] . '">' . $result[$i]["action"] . '</button>',
                        "uid" => $result[$i]["replyererid"],
                        "btnid" => '#listuser_' . $result[$i]["replyererid"],
                        "actionid" => $result[$i]["actionid"],
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
    public function UserRequestAccepted() {
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
        if (isset($this->postBaseData["columns"])) {
            //$this->postBaseData["columns"][]["data"]
            //$this->postBaseData["columns"][]["name"] = ''
            //$this->postBaseData["columns"][]["orderable"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["regex"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["value"] = ''
            //$this->postBaseData["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->postBaseData["search"])) {
            $searchqr = ' AND (ad.`user_name`       LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ue.`users_email_ids_email`          LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ucn.`users_cell_numbers_cell_number`    LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR t2.`type`     LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ad.`user_doj`            LIKE "%' . $this->postBaseData["search"]["value"] . '%")';
        }
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`user_pk` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ue.`users_email_ids_email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ucn.`users_cell_numbers_cell_number` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`user_doj` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t2.`type` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`user_pk` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`user_pk` AS replyererid,
            ad.`user_name` AS replyername,
            ue.`users_email_ids_email` AS replyeremail,
            ucn.`users_cell_numbers_cell_number` AS replyercell,
            t2.`type`,
            ad.`user_doj` AS doj,
            IF(ad.`user_status_id` = 4, "Reject","Accept") AS action,
            IF(ad.`user_status_id` = 4, "btn-danger", "btn-success") AS btn,
            IF(ad.`user_status_id` = 4, 42,4) AS actionid
        FROM `users` AS ad
        LEFT JOIN `users_email_ids` AS ue ON ad.`user_pk`=ue.`users_email_ids_user_pk`
        LEFT JOIN `users_cell_numbers` AS ucn ON ad.`user_pk`=ucn.`users_cell_numbers_user_pk`
        LEFT JOIN `users_type` AS t2 ON t2.`users_type_id` = ad.`user_type_id`
        WHERE (ad.`user_pk` != NULL
        OR ad.`user_pk` IS NOT NULL)
        AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk`)
        AND ad.`user_status_id` = 4
        AND ad.`user_type_id` IN (3,4,5,6,7) ' . $searchqr . ' ' . $orderqr . ' ;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    //$result[$i]["users_gender_id"]
                    array_push($data, array(
                        "Id" => $i + 1,
                        "Name" => ucfirst($result[$i]["replyername"]),
                        "Email" => $result[$i]["replyeremail"],
                        "Cell" => $result[$i]["replyercell"],
                        "Registered Date" => date("d-M-Y", strtotime($result[$i]["doj"])),
                        "User Type" => $result[$i]["type"],
                        "Action" => '<button class="btn ' . $result[$i]["btn"] . '" id="listuser_' . $result[$i]["replyererid"] . '" name="' . $result[$i]["replyererid"] . '">' . $result[$i]["action"] . '</button>',
                        "uid" => $result[$i]["replyererid"],
                        "btnid" => '#listuser_' . $result[$i]["replyererid"],
                        "actionid" => $result[$i]["actionid"],
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
    public function UserRequestRejected() {
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
        if (isset($this->postBaseData["columns"])) {
            //$this->postBaseData["columns"][]["data"]
            //$this->postBaseData["columns"][]["name"] = ''
            //$this->postBaseData["columns"][]["orderable"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["regex"] = 'true / false'
            //$this->postBaseData["columns"][]["search"]["value"] = ''
            //$this->postBaseData["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->postBaseData["search"])) {
            $searchqr = ' AND (ad.`user_name`       LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ue.`users_email_ids_email`          LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ucn.`users_cell_numbers_cell_number`    LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR t2.`type`     LIKE "%' . $this->postBaseData["search"]["value"] . '%"
                        OR ad.`user_doj`            LIKE "%' . $this->postBaseData["search"]["value"] . '%")';
        }
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`user_pk` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ue.`users_email_ids_email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ucn.`users_cell_numbers_cell_number` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`user_doj` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t2.`type` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`user_pk` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`user_pk` AS replyererid,
            ad.`user_name` AS replyername,
            ue.`users_email_ids_email` AS replyeremail,
            ucn.`users_cell_numbers_cell_number` AS replyercell,
            t2.`type`,
            ad.`user_doj` AS doj,
            IF(ad.`user_status_id` = 42, "Accept","Reject") AS action,
            IF(ad.`user_status_id` = 42, "btn-success","btn-danger") AS btn,
            IF(ad.`user_status_id` = 42, 4,42) AS actionid
        FROM `users` AS ad
        LEFT JOIN `users_email_ids` AS ue ON ad.`user_pk`=ue.`users_email_ids_user_pk`
        LEFT JOIN `users_cell_numbers` AS ucn ON ad.`user_pk`=ucn.`users_cell_numbers_user_pk`
        LEFT JOIN `users_type` AS t2 ON t2.`users_type_id` = ad.`user_type_id`
        WHERE (ad.`user_pk` != NULL
        OR ad.`user_pk` IS NOT NULL)
        AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk`)
        AND ad.`user_status_id` = 42
        AND ad.`user_type_id` IN (3,4,5,6,7) ' . $searchqr . ' ' . $orderqr . ' ;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    //$result[$i]["users_gender_id"]
                    array_push($data, array(
                        "Id" => $i + 1,
                        "Name" => ucfirst($result[$i]["replyername"]),
                        "Email" => $result[$i]["replyeremail"],
                        "Cell" => $result[$i]["replyercell"],
                        "Registered Date" => date("d-M-Y", strtotime($result[$i]["doj"])),
                        "User Type" => $result[$i]["type"],
                        "Action" => '<button class="btn ' . $result[$i]["btn"] . '" id="listuser_' . $result[$i]["replyererid"] . '" name="' . $result[$i]["replyererid"] . '">' . $result[$i]["action"] . '</button>',
                        "uid" => $result[$i]["replyererid"],
                        "btnid" => '#listuser_' . $result[$i]["replyererid"],
                        "actionid" => $result[$i]["actionid"],
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
    public function ProcessUser() {
        $jsondata = array(
            "stat" => 0,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `users`
                SET `user_status_id`="' . ($this->postBaseData['stat']) . '"
                WHERE `user_pk`="' . ($this->postBaseData['id']) . '"';
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
        if ($res) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ListFinancialSuccess() {
    }
    public function ListFinancialUnsuccess() {
    }
    public function ListServiceSuccess() {
    }
    public function ListServiceUnsuccess() {
    }
    public function SetFixedCommission() {
    }
    public function SetVariableCommission() {
    }
    public function SetCommissionDetails() {
    }
    public function ListUserCommission() {
    }
    public function DeleteUser($uid) {
        $id=base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `users` SET
                         `user_status_id` = :stat,
                         `user_updated_at` = :id1
                          WHERE `user_pk`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => ($id),
            ":stat" => ($jsondata["stat"]),
            ":id1" => date("Y-m-d H:i:s")
        ));
//        $bnk_id = $this->db->lastInsertId();
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