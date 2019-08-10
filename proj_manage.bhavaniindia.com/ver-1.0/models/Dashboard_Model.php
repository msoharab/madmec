<?php

class Dashboard_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function AddProduct() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "brand" => $this->postBaseData["brand"],
            "category" => $this->postBaseData["category"],
            "quantity" => $this->postBaseData["quantity"],
            "price" => $this->postBaseData["price"],
            "description" => $this->postBaseData["description"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* User profile pic */
        $query0 = 'INSERT INTO `photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $photo_id = $this->db->lastInsertId();
        array_push($jsondata["picids"], $photo_id);
        /* Users */
        $query2 = 'INSERT INTO `product`(
                        `id`,
                        `name`,
                        `photo_id`,
                        `brand`,
                        `category`,
                        `quantity`,
                        `price`,
                        `description`,
                        `status`)Values('
                . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8,
                        :id9)';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => NULL,
            ":id2" => ($jsondata["name"]),
            ":id3" => ($photo_id),
            ":id4" => ($jsondata["brand"]),
            ":id5" => ($jsondata["category"]),
            ":id6" => ($jsondata["quantity"]),
            ":id7" => ($jsondata["price"]),
            ":id8" => ($jsondata["description"]),
            ":id9" => ($jsondata["stat"])
        ));
        $prd_pk = $this->db->lastInsertId();
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_Product_' . $prd_pk);
        $query3 = 'UPDATE `product` SET `directory` = :id1 WHERE `id`=:id2';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => ($directory),
            ":id2" => $prd_pk
        ));
        if ($res2 && $res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["imgstatus"] = "success";
            $jsondata["id"] = $prd_pk;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function ListProduct() {
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
        $searchqr = ' AND (ad.`name`           LIKE :col1
                        OR ad.`brand`          LIKE :col2
                        OR ad.`category`    LIKE :col3
                        OR ad.`quantity`     LIKE :col4
                        OR ad.`doc`      LIKE :col5
                        OR ad.`description`     LIKE :col6)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`brand` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`category` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad. `quantity` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`doc` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`description` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS id,
            ad.`name` AS name,
            ad.`brand` AS brand,
            ad.`category` AS cate,
            ad.`quantity` AS quant,
            ad.`price` AS price,
            ad.`doc` AS date,
            ad.`description` AS descrip
            FROM `product` AS ad
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4' . $searchqr . ' ' . $orderqr;
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
                        "Product Name" => ucfirst($result[$i]["name"]),
                        "Brand" => $result[$i]["brand"],
                        "Category" => $result[$i]["cate"],
                        "Quantity" => $result[$i]["quant"],
                        "Price" => $result[$i]["price"],
//                        "Picture" => '<a href="' . $result[$i]["pic"] . '" target="_new" class="btn btn-block btn-warning">View<a>',
                        "Description" => $result[$i]["descrip"],
                        "Date" => $result[$i]["date"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'Edit/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'DeleteProduct/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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

    public function AddMembers() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "designation" => $this->postBaseData["designation"],
            "email" => $this->postBaseData["email"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "facebook" => $this->postBaseData["facebook"],
            "twitter" => $this->postBaseData["twitter"],
            "googlep" => $this->postBaseData["googlep"],
            "address" => $this->postBaseData["address"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* User profile pic */
        $query0 = 'INSERT INTO `photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $photo_id = $this->db->lastInsertId();
        array_push($jsondata["picids"], $photo_id);
        /* Users */
        $query2 = 'INSERT INTO `team_members`(
                        `id`,
                        `name`,
                        `designation`,
                        `email`,
                        `cell_1`,
                        `cell_2`,
                        `facebook_link`,
                        `twitter_link`,
                        `googleP_link`,
                        `address`,
                        `photo_id`,
                        `status`)Values('
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
                        :id12)';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => NULL,
            ":id2" => ($jsondata["name"]),
            ":id3" => ($jsondata["designation"]),
            ":id4" => ($jsondata["email"]),
            ":id5" => ($jsondata["mobile1"]),
            ":id6" => ($jsondata["mobile2"]),
            ":id7" => ($jsondata["facebook"]),
            ":id8" => ($jsondata["twitter"]),
            ":id9" => ($jsondata["googlep"]),
            ":id10" => ($jsondata["address"]),
            ":id11" => ($photo_id),
            ":id12" => ($jsondata["stat"])
        ));
        $prd_pk = $this->db->lastInsertId();
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_Members_' . $prd_pk);
        $query3 = 'UPDATE `team_members` SET `directory` = :id1 WHERE `id`=:id2';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => ($directory),
            ":id2" => $prd_pk
        ));
        if ($res2 && $res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["imgstatus"] = "success";
            $jsondata["id"] = $prd_pk;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function ListMembers() {
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
        $searchqr = ' AND (ad.`name`           LIKE :col1
                        OR ad.`designation`          LIKE :col2
                        OR ad.`cell_1`    LIKE :col3
                        OR ad.`email`     LIKE :col4
                        OR ad.`address`      LIKE :col5
                        OR ad.`facebook_link`      LIKE :col6
                        OR ad.`doc`     LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`designation` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`cell_1` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad. `email` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`address` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`doc` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS id,
            ad.`name` AS name,
            ad.`designation` AS desig,
            ad.`cell_1` AS cell,
            ad.`email` AS email,
            REPLACE(ad.`address`,"\r\n","<br />") AS addr,
            ad.`doc` AS doc,
            ad.`facebook_link` AS faceb1,
            ad.`twitter_link` AS faceb2,
            ad.`googleP_link` AS faceb3
            FROM `team_members` AS ad
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4' . $searchqr . ' ' . $orderqr;
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
                    if($result[$i]["faceb1"] === NULL){
                       $result[$i]["faceb1"] = "#";
                    }
                    if($result[$i]["faceb2"] === NULL){
                        $result[$i]["faceb2"] = "#";
                    }
                    if($result[$i]["faceb3"] === NULL){
                        $result[$i]["faceb3"] = "#";
                    }
                    $address = str_replace($this->order, $this->replace, $result[$i]["addr"]);
                    array_push($data, array(
                        "#" => $i + 1,
                        "Member Name" => ucfirst($result[$i]["name"]),
                        "Designation" => $result[$i]["desig"],
                        "Mobile" =>$result[$i]["email"],
                        "Email" =>  $result[$i]["cell"],
                        "Address" => $address,
                        "Facebook" => '<a href="' . $result[$i]["faceb1"] . '" target="_new" class="btn btn-block btn-info">Facebook<a><br />'.
                                        '<a href="' . $result[$i]["faceb3"] . '" target="_new" class="btn btn-block btn-info">Google+<a><br />'.
                                        '<a href="' . $result[$i]["faceb2"] . '" target="_new" class="btn btn-block btn-info">Twitter<a><br />',
                        "Date" => date("d-M-Y",  strtotime($result[$i]["doc"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'Edit/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'DeleteProduct/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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

    public function EditProduct() {
        $jsondata = array(
            "product_name" => $this->postBaseData["product_name"],
            "brand" => $this->postBaseData["brand"],
            "category" => $this->postBaseData["category"],
            "quantity" => $this->postBaseData["quantity"],
            "price" => $this->postBaseData["price"],
            "date" => $this->postBaseData["date"],
            "description" => $this->postBaseData["description"],
            "photo" => $this->postBaseData["photo"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $d = date("Y-m-d H:i:s");
        $stm = $this->db->prepare('SELECT `user_name` FROM `users` WHERE `user_name`= :name AND `users_pk`!=:id');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":id" => ($jsondata["user_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $q1 = 'SELECT ad.*,up.*,pp.* FROM `users` ad,`users_proof` up,`portal_photo` pp WHERE ad.`user_proof_id` = up.`users_proof_id` AND up.`users_proof_pic`=pp.`id` AND `users_pk`=:id';
            $s1 = $this->db->prepare($q1);
            $r1 = $s1->execute(array(
                ":id" => ($jsondata["user_id"])
            ));
            $r1 = $s1->execute();
            if ($r1) {
                $result1 = $s1->fetchAll();
                $data["data"] = $result1;
            }
            $proof_pic_id = $result1[0]["id"];
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
                        WHERE `users_pk`=:id1';
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
                        WHERE `users_email_ids_users_pk`=:id3';
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
            $se = $this->db->prepare('SELECT * FROM `users_cell_numbers` WHERE `users_cell_numbers_users_pk`=:id');
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
               WHERE `users_cell_numbers_id`=:id1 AND `users_cell_numbers_users_pk`=:id5');
                    $res6 = $stm6->execute(array(
                        ":id1" => $result2[1]["users_cell_numbers_id"],
                        ":id2" => $result[0]["portal_countries_Phone"],
                        ":id3" => ($jsondata["mobile2"]),
                        ":id4" => ($d),
                        ":id5" => ($jsondata["user_id"])
                    ));
                } else {
                    $stm6 = $this->db->prepare('INSERT INTO `users_cell_numbers`(
                    `users_cell_numbers_users_pk`,
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
            $query5 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `users_pk`=:id2';
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

    public function EditOffer() {
        $jsondata = array(
            "id" => $this->postBaseData["offid"],
            "name" => $this->postBaseData["name"],
            "duration" => $this->postBaseData["duration"],
            "minmember" => $this->postBaseData["minmember"],
            "facility" => $this->postBaseData["facility"],
            "price" => $this->postBaseData["price"],
            "descrip" => $this->postBaseData["descrip"],
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query1 = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_offers` SET
                                `name`=:id1,
                                `duration_id`=:id2,
                                `facility_id`=:id4,
                                `description`=:id5,
                                `cost`=:id6,
                                `min_members_id`=:id7,
                                `status`=:id8
                                 WHERE `id`=:id';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id" => ($jsondata["id"]),
            ":id1" => ($jsondata["name"]),
            ":id2" => ($jsondata["duration"]),
            ":id4" => ($jsondata["facility"]),
            ":id5" => ($jsondata["descrip"]),
            ":id6" => ($jsondata["price"]),
            ":id7" => ($jsondata["minmember"]),
            ":id8" => ($jsondata["stat"])
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    /* Package */

    public function DeleteProduct($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `product` SET
                         `status` = :stat
                          WHERE `id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => ($id),
            ":stat" => ($jsondata["stat"]),
        ));
        if ($res) {
            $this->db->commit();
            $jsondata["status"] = "success";
            echo "<script>
           alert('Successfully deleted');
           window.history.back();
            </script>";
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