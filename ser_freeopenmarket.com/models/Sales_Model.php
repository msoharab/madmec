<?php

class Sales_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["users_pk"];
    }

    public function AddGateway() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "doc" => $this->postBaseData["doc"],
            "version" => $this->postBaseData["version"],
            "mobile" => $this->postBaseData["mobile"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "proof_id" => $this->postBaseData["proof_id"],
            "proof_type" => $this->postBaseData["proof_type"],
            "businesstype" => $this->postBaseData["businesstype"],
            "service" => $this->postBaseData["service"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $stm = $this->db->prepare('SELECT * FROM `gateway` WHERE `gateway_name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `gateway` WHERE `gateway_name`= :name AND `gateway_status_id`=:stat');
            $res = $stm->execute(array(
                ":name" => ($jsondata["name"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `gateway` SET `gateway_status_id`=:stat,
                    `gateway_updated_at` = :id1 WHERE `gateway_name`= :name');
                $res2 = $stm2->execute(array(
                    ":stat" => ($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":name" => ($jsondata["name"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $picid = $this->db->lastInsertId();
            /* User proof pic */
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => NULL
            ));
            $proof_pic_id = $this->db->lastInsertId();
            $query2 = 'INSERT INTO  `gateway_proof` (
                    `gateway_proof_id`,
                    `gateway_proof_portal_proof_id`,
                    `gateway_proof_code`,
                    `gateway_proof_pic`)  VALUES('
                    . ':id1,
                      :id2,
                      :id3,
                      :id4);';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["proof_type"]),
                ":id3" => ($jsondata["proof_id"]),
                ":id4" => ($proof_pic_id)
            ));
            $proof_id = $this->db->lastInsertId();
            /* Users */
            $query3 = 'INSERT INTO `gateway`(
                        `gateway_id`,
                        `gateway_business_portal_business_type_id`,
                        `gateway_services_id`,
                        `gateway_name`,
                        `gateway_business_proof_id`,
                        `gateway_photo_id`,
                        `gateway_doe`,
                        `gateway_version`,
                        `gateway_address_addressline`,
                        `gateway_address_country`,
                        `gateway_address_province`,
                        `gateway_address_district`,
                        `gateway_address_city`,
                        `gateway_address_town`,
                        `gateway_address_stloc`,
                        `gateway_address_zipcode`,
                        `gateway_status_id`)Values(
                        :id1,
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
                        :id17)';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["businesstype"]),
                ":id3" => ($jsondata["service"]),
                ":id4" => ($jsondata["name"]),
                ":id5" => ($proof_id),
                ":id6" => ($proof_pic_id),
                ":id7" => ($jsondata["doc"]),
                ":id8" => ($jsondata["version"]),
                ":id9" => ($jsondata["addline"]),
                ":id10" => ($jsondata["country"]),
                ":id11" => ($jsondata["state"]),
                ":id12" => ($jsondata["distct"]),
                ":id13" => ($jsondata["city"]),
                ":id14" => ($jsondata["city"]),
                ":id15" => ($jsondata["stloc"]),
                ":id16" => ($jsondata["zipc"]),
                ":id17" => ($jsondata["stat"])
            ));
            $gateway_id = $this->db->lastInsertId();
            if (($jsondata["email"]) != null) {
                $query4 = 'INSERT INTO `gateway_email_ids`(
                    `gateway_email_ids_id`,
                    `gateway_email_ids_gateway_id`,
                    `gateway_email_ids_email`)Values('
                        . ':id1,
                        :id2,
                        :id3)';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => NULL,
                    ":id2" => $gateway_id,
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
            $query5 = 'INSERT INTO `gateway_cell_numbers`(
                  `gateway_cell_numbers_id`,
                  `gateway_cell_numbers_gateway_id`,
                  `gateway_cell_numbers_cell_code`,
                  `gateway_cell_numbers_cell_number`)Values('
                    . ':id1,
                    :id2,
                    :id3,
                    :id4)';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id1" => NULL,
                ":id2" => $gateway_id,
                ":id3" => $result[0]["portal_countries_Phone"],
                ":id4" => ($jsondata["mobile"])
            ));
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_gateway_' . $gateway_id);
            $query6 = 'UPDATE `gateway` SET `gateway_directory` = :id1 WHERE `gateway_id`=:id2';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => ($directory),
                ":id2" => $gateway_id
            ));
            if (isset($this->postBaseFile['file'])) {
                $verImages = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'],
                    "file_size" => $this->postBaseFile['file']['size'],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'],
                    "file_type" => $this->postBaseFile['file']['type'],
                    "directory" => $directory,
                    "target" => 'Proof',
                    "picid" => (integer) $proof_pic_id,
                ));
                if ($verImages["status"] == "error") {
                    $pic_flag = false;
                }
            }

            if ($res1 && $res2 && $res3 && $res4 && $pic_flag && $res5 && $res6) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function AddRest() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "doc" => $this->postBaseData["doc"],
            "version" => $this->postBaseData["version"],
            "mobile" => $this->postBaseData["mobile"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "proof_id" => $this->postBaseData["proof_id"],
            "proof_type" => $this->postBaseData["proof_type"],
            "businesstype" => $this->postBaseData["businesstype"],
            "service" => $this->postBaseData["service"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $stm = $this->db->prepare('SELECT `gateway_name` FROM `gateway` WHERE `gateway_name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $picid = $this->db->lastInsertId();
            /* User proof pic */
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => NULL
            ));
            $proof_pic_id = $this->db->lastInsertId();
            $query2 = 'INSERT INTO  `gateway_proof` (
                    `gateway_proof_id`,
                    `gateway_proof_portal_proof_id`,
                    `gateway_proof_code`,
                    `gateway_proof_pic`)  VALUES('
                    . ':id1,
                      :id2,
                      :id3,
                      :id4);';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["proof_type"]),
                ":id3" => ($jsondata["proof_id"]),
                ":id4" => ($proof_pic_id)
            ));
            $proof_id = $this->db->lastInsertId();
            /* Users */
            $query3 = 'INSERT INTO `gateway`(
                        `gateway_id`,
                        `gateway_business_portal_business_type_id`,
                        `gateway_services_id`,
                        `gateway_name`,
                        `gateway_business_proof_id`,
                        `gateway_photo_id`,
                        `gateway_doe`,
                        `gateway_version`,
                        `gateway_address_addressline`,
                        `gateway_address_country`,
                        `gateway_address_province`,
                        `gateway_address_district`,
                        `gateway_address_city`,
                        `gateway_address_town`,
                        `gateway_address_stloc`,
                        `gateway_address_zipcode`,
                        `gateway_status_id`)Values(
                        :id1,
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
                        :id17)';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["businesstype"]),
                ":id3" => ($jsondata["service"]),
                ":id4" => ($jsondata["name"]),
                ":id5" => ($proof_id),
                ":id6" => ($proof_pic_id),
                ":id7" => (time()),
                ":id8" => ($jsondata["version"]),
                ":id9" => ($jsondata["addline"]),
                ":id10" => ($jsondata["country"]),
                ":id11" => ($jsondata["state"]),
                ":id12" => ($jsondata["distct"]),
                ":id13" => ($jsondata["city"]),
                ":id14" => ($jsondata["city"]),
                ":id15" => ($jsondata["stloc"]),
                ":id16" => ($jsondata["zipc"]),
                ":id17" => ($jsondata["stat"])
            ));
            $gateway_id = $this->db->lastInsertId();
            if (($jsondata["email"]) != null) {
                $query4 = 'INSERT INTO `gateway_email_ids`(
                    `gateway_email_ids_id`,
                    `gateway_email_ids_gateway_id`,
                    `gateway_email_ids_email`)Values('
                        . ':id1,
                        :id2,
                        :id3)';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => NULL,
                    ":id2" => $gateway_id,
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
            $query5 = 'INSERT INTO `gateway_cell_numbers`(
                  `gateway_cell_numbers_id`,
                  `gateway_cell_numbers_gateway_id`,
                  `gateway_cell_numbers_cell_code`,
                  `gateway_cell_numbers_cell_number`)Values('
                    . ':id1,
                    :id2,
                    :id3,
                    :id4)';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id1" => NULL,
                ":id2" => $gateway_id,
                ":id3" => $result[0]["portal_countries_Phone"],
                ":id4" => ($jsondata["mobile"])
            ));
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_gateway_' . $gateway_id);
            $query6 = 'UPDATE `gateway` SET `gateway_directory` = :id1 WHERE `gateway_id`=:id2';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => ($directory),
                ":id2" => $gateway_id
            ));
            if (isset($this->postBaseFile['file'])) {
                $verImages = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'],
                    "file_size" => $this->postBaseFile['file']['size'],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'],
                    "file_type" => $this->postBaseFile['file']['type'],
                    "directory" => $directory,
                    "target" => 'Proof',
                    "picid" => (integer) $proof_pic_id,
                ));
                if ($verImages["status"] == "error") {
                    $pic_flag = false;
                }
            }

            if ($res1 && $res2 && $res3 && $res4 && $pic_flag && $res5 && $res6) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function AssignGateway() {
        
    }

    public function AddSubscription() {
        
    }

    public function AddOperator() {
        $jsondata = array(
            "gate" => $this->postBaseData["gate"],
            "name" => $this->postBaseData["name"],
            "ocode" => $this->postBaseData["ocode"],
            "alias" => $this->postBaseData["alias"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators` WHERE `gateway_operator_name`= :name AND `gateway_operator_gateway_id`=:gate');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":gate" => ($jsondata["gate"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO `gateway_operators`(
                        `gateway_operator_gateway_id`,
                        `gateway_operator_name`,
                        `gateway_operator_lt_code`,
                        `gateway_operator_alias`,
                        `gateway_operator_commission_fixed`,
                        `gateway_operator_commission_variable`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => ($jsondata["gate"]),
                ":id2" => ($jsondata["name"]),
                ":id3" => ($jsondata["ocode"]),
                ":id4" => ($jsondata["alias"]),
                ":id5" => ($jsondata["flat"]),
                ":id6" => ($jsondata["variable"]),
            ));
            $operator_id = $this->db->lastInsertId();
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function AddOperatorTypeDB() {
        $jsondata = array(
            "operator" => $this->postBaseData["operator"],
            "optype" => $this->postBaseData["optype"],
            "optypecode" => $this->postBaseData["optypecode"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators_type` WHERE `gateway_operator_type_operator_id`= :operator AND `gateway_operator_type_type`=:optype');
        $res = $stm->execute(array(
            ":operator" => ($jsondata["operator"]),
            ":optype" => ($jsondata["optype"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO `gateway_operators_type`(
                        `gateway_operator_type_operator_id`,
                        `gateway_operator_type_type`,
                        `gateway_operator_type_lt_code`,
                        `gateway_operator_type_commission_fixed`,
                        `gateway_operator_type_commission_variable`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => ($jsondata["operator"]),
                ":id2" => ($jsondata["optype"]),
                ":id3" => ($jsondata["optypecode"]),
                ":id4" => ($jsondata["flat"]),
                ":id5" => ($jsondata["variable"])
            ));
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function TechnicalRest() {
        
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

    public function ListGateway() {
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
        $searchqr = ' AND (ad.`gateway_id`       LIKE :col1
                        OR ad.`gateway_name`    LIKE :col2
                        OR t2.`portal_business_type_name`    LIKE :col3
                        OR t3.`services_name`    LIKE :col4
                        OR ad.`gateway_version`    LIKE :col5
                        OR t1.`gateway_email_ids_email`    LIKE :col6
                        OR t4.`gateway_cell_numbers_cell_number`    LIKE :col7
                        OR ad.`gateway_doj`    LIKE :col8)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`gateway_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`gateway_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`portal_business_type_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY t3.`services_name` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`gateway_version` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t1.`gateway_email_ids_email` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t4.`gateway_cell_numbers_cell_number` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`gateway_doj` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`gateway_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`gateway_id` AS gateid,
            ad.`gateway_name` AS gatename,
            t2.`portal_business_type_name` AS gatebty,
            t3.`services_name` AS gateser,
            ad.`gateway_version` AS gatever,
            t1.`gateway_email_ids_email` AS gateeml,
            t4.`gateway_cell_numbers_cell_number` AS gatecel,
            ad.`gateway_doj` AS gatedoc
        FROM `gateway` AS ad
        LEFT JOIN `portal_business_type` AS t2 ON t2.`portal_business_type_id` = ad.`gateway_business_portal_business_type_id`
        LEFT JOIN `services` AS t3 ON t3.`services_id` = ad.`gateway_services_id`
        LEFT JOIN `gateway_email_ids` AS t1 ON t1.`gateway_email_ids_gateway_id` = ad.`gateway_id`
        LEFT JOIN `gateway_cell_numbers` AS t4 ON t4.`gateway_cell_numbers_gateway_id` = ad.`gateway_id`
        WHERE (ad.`gateway_id` != NULL
        OR ad.`gateway_id` IS NOT NULL)
        AND ad.`gateway_status_id` = 4
        AND t1.`gateway_email_ids_status_id` = 4
        AND t2.`portal_business_type_status_id` = 4
        AND t3.`services_status_id` = 4
        AND t4.`gateway_cell_numbers_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
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
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Gateway Name" => ucfirst($result[$i]["gatename"]),
                        "Business Type" => $result[$i]["gatebty"],
                        "Service" => $result[$i]["gateser"],
                        "Gateway API version" => $result[$i]["gatever"],
                        "Email" => $result[$i]["gateeml"],
                        "Mobile" => $result[$i]["gatecel"],
                        "Date" => $result[$i]["gatedoc"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayEdit/' . base64_encode($result[$i]["gateid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_7"] . 'DeleteGateway/' . base64_encode($result[$i]["gateid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
                    ));
                }
                $draw = isset($this->postBaseData["draw"]) ? (integer) $this->postBaseData["draw"] : 1;
                $listusers["draw"] = $draw;
                $listusers["recordsTotal"] = $num_posts;
                $listusers["recordsFiltered"] = $num_posts;
                /* Chop Array */
                $initial = isset($this->postBaseData["start"]) ? (integer) $this->postBaseData["start"] : 0;
                $final = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"] + $initial) : (10 + $initial);
                $length = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"]) : 10;
                $listusers["data"] = array_slice($data, $initial, $this->postBaseData["length"]);
            }
        }
        return $listusers;
    }

    public function ListOperators() {
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
        $searchqr = ' AND (ad.`gateway_operator_name`       LIKE :col1
                        OR ad.`gateway_operator_lt_code`          LIKE :col2
                        OR ad.`gateway_operator_alias`    LIKE :col3
                        OR ad.`gateway_operator_commission_fixed`          LIKE :col4
                        OR ad.`gateway_operator_commission_variable`    LIKE :col5
                        OR ad.`gateway_operator_created_at`     LIKE :col6
                        OR t2.`gateway_name`     LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`gateway_operator_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`gateway_operator_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`gateway_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`gateway_operator_lt_code` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`gateway_operator_alias` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`gateway_operator_commission_fixed` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`gateway_operator_commission_variable` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`gateway_operator_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`gateway_operator_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`gateway_operator_id` AS replyererid,
            ad.`gateway_operator_name` AS replyername,
            ad.`gateway_operator_lt_code` AS replyeremail,
            ad.`gateway_operator_alias` AS replyercell,
            ad.`gateway_operator_commission_fixed` AS replyerfixed,
            ad.`gateway_operator_commission_variable` AS replyervariab,
            ad.`gateway_operator_created_at`,
            t2.`gateway_name`
        FROM `gateway_operators` AS ad
        LEFT JOIN `gateway` AS t2 ON t2.`gateway_id` = ad.`gateway_operator_gateway_id`
        WHERE (ad.`gateway_operator_id` != NULL
        OR ad.`gateway_operator_id` IS NOT NULL)
        AND ad.`gateway_operator_status_id` = 4
        AND t2.`gateway_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
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
                        "Operator Name" => ucfirst($result[$i]["replyername"]),
                        "Gateway Name" => ucfirst($result[$i]["gateway_name"]),
                        "Operator LT Code" => $result[$i]["replyeremail"],
                        "Operator Alias" => $result[$i]["replyercell"],
                        "Fixed Commission" => $result[$i]["replyerfixed"],
                        "Variable Commission" => $result[$i]["replyervariab"],
                        "Started At" => date("d-M-Y", strtotime($result[$i]["gateway_operator_created_at"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayOperatorEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                    ));
                }
                $draw = isset($this->postBaseData["draw"]) ? (integer) $this->postBaseData["draw"] : 1;
                $listusers["draw"] = $draw;
                $listusers["recordsTotal"] = $num_posts;
                $listusers["recordsFiltered"] = $num_posts;
                /* Chop Array */
                $initial = isset($this->postBaseData["start"]) ? (integer) $this->postBaseData["start"] : 0;
                $final = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"] + $initial) : (10 + $initial);
                $length = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"]) : 10;
                $listusers["data"] = array_slice($data, $initial, $this->postBaseData["length"]);
            }
        }
        return $listusers;
    }

    public function ListOperatorTypes() {
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
        $searchqr = ' AND (ad.`gateway_operator_type_type`          LIKE :col1
                        OR ad.`gateway_operator_type_lt_code`       LIKE :col2
                        OR ad.`gateway_operator_type_commission_fixed`          LIKE :col3
                        OR ad.`gateway_operator_type_commission_variable`    LIKE :col4
                        OR ad.`gateway_operator_type_created_at`    LIKE :col5
                        OR t1.`gateway_operator_name`               LIKE :col6
                        OR t2.`gateway_name`               LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t1.`gateway_operator_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`gateway_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_type` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_lt_code` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_commission_fixed` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_commission_variable` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`gateway_operator_type_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`gateway_operator_type_id` AS replyererid,
            ad.`gateway_operator_type_type` AS replyername,
            ad.`gateway_operator_type_lt_code` AS replyeremail,
            ad.`gateway_operator_type_commission_fixed` AS replyerfixed,
            ad.`gateway_operator_type_commission_variable` AS replyervariab,
            ad.`gateway_operator_type_created_at`,
            t1.`gateway_operator_name`,
            t2.`gateway_name`
        FROM `gateway_operators_type` AS ad
        LEFT JOIN `gateway_operators` AS t1 ON t1.`gateway_operator_id` = ad.`gateway_operator_type_operator_id`
        LEFT JOIN `gateway` AS t2 ON t2.`gateway_id` = t1.`gateway_operator_gateway_id`
        WHERE (ad.`gateway_operator_type_id` != NULL
        OR ad.`gateway_operator_type_id` IS NOT NULL)
        AND ad.`gateway_operator_type_status_id` = 4
        AND t1.`gateway_operator_status_id` = 4
        AND t2.`gateway_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
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
                        "Operator Name" => ucfirst($result[$i]["gateway_operator_name"]),
                        "Gateway Name" => ucfirst($result[$i]["gateway_name"]),
                        "Operator Type" => $result[$i]["replyername"],
                        "Operator Type LT Code" => $result[$i]["replyeremail"],
                        "Fixed Commission" => $result[$i]["replyerfixed"],
                        "Variable Commission" => $result[$i]["replyervariab"],
                        "Started At" => date("d-M-Y", strtotime($result[$i]["gateway_operator_type_created_at"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_7"] . 'GatewayOperatorTypeEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                    ));
                }
                $draw = isset($this->postBaseData["draw"]) ? (integer) $this->postBaseData["draw"] : 1;
                $listusers["draw"] = $draw;
                $listusers["recordsTotal"] = $num_posts;
                $listusers["recordsFiltered"] = $num_posts;
                /* Chop Array */
                $initial = isset($this->postBaseData["start"]) ? (integer) $this->postBaseData["start"] : 0;
                $final = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"] + $initial) : (10 + $initial);
                $length = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"]) : 10;
                $listusers["data"] = array_slice($data, $initial, $this->postBaseData["length"]);
            }
        }
        return $listusers;
    }

    public function EditGateway() {
        $jsondata = array(
            "gateUser_id" => base64_decode($this->postBaseData["gateUser_id"]),
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "doc" => $this->postBaseData["doc"],
            "version" => $this->postBaseData["version"],
            "mobile" => $this->postBaseData["mobile"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "proof_id" => $this->postBaseData["proof_id"],
            "proof_type" => $this->postBaseData["proof_type"],
            "businesstype" => $this->postBaseData["businesstype"],
            "service" => $this->postBaseData["service"],
            "stat" => 4,
            "status" => 'error'
        );
        $pic_flag = true;
        $d = date("Y-m-d H:i:s");
        $stm = $this->db->prepare('SELECT `gateway_name` FROM `gateway` WHERE `gateway_name`= :name AND `gateway_id`!=:id');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":id" => ($jsondata["gateUser_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $stm = $this->db->prepare('SELECT * FROM `gateway` WHERE `gateway_id`= :id');
            $res = $stm->execute(array(
                ":id" => ($jsondata["gateUser_id"])
            ));
            $res = $stm->execute();
            if ($res) {
                $result1 = $stm->fetchAll();
                $data["data"] = $result1;
            }
            /* User proof pic */
            $query1 = 'UPDATE `portal_photo` SET
                    `status_id`=:id1,
                    `portal_photo_updated_at`=:id2
                    WHERE `id`=:id3';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id1" => ($jsondata["stat"]),
                ":id2" => ($d),
                ":id3" => $result1[0]["gateway_photo_id"]
            ));
            $proof_pic_id = $this->db->lastInsertId();
            $query2 = 'UPDATE `gateway_proof` SET
                    `gateway_proof_portal_proof_id`=:id1,
                    `gateway_proof_code`=:id2,
                    `gateway_proof_updated_at`=:id3
                    WHERE `gateway_proof_id`=:id4';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => ($jsondata["proof_type"]),
                ":id2" => ($jsondata["proof_id"]),
                ":id3" => ($d),
                ":id4" => $result1[0]["gateway_business_proof_id"]
            ));
            /* Users */
            $query3 = 'UPDATE `gateway` SET
                        `gateway_business_portal_business_type_id`=:id1,
                        `gateway_services_id`=:id2,
                        `gateway_name`=:id3,
                        `gateway_doe`=:id4,
                        `gateway_version`=:id5,
                        `gateway_address_addressline`=:id6,
                        `gateway_address_country`=:id7,
                        `gateway_address_province`=:id8,
                        `gateway_address_district`=:id9,
                        `gateway_address_city`=:id10,
                        `gateway_address_town`=:id11,
                        `gateway_address_stloc`=:id12,
                        `gateway_address_zipcode`=:id13,
                        `gateway_status_id`=:id14,
                        `gateway_updated_at`=:id15 WHERE `gateway_id`=:id';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => ($jsondata["businesstype"]),
                ":id2" => ($jsondata["service"]),
                ":id3" => ($jsondata["name"]),
                ":id4" => ($jsondata["doc"]),
                ":id5" => ($jsondata["version"]),
                ":id6" => ($jsondata["addline"]),
                ":id7" => ($jsondata["country"]),
                ":id8" => ($jsondata["state"]),
                ":id9" => ($jsondata["distct"]),
                ":id10" => ($jsondata["city"]),
                ":id11" => ($jsondata["city"]),
                ":id12" => ($jsondata["stloc"]),
                ":id13" => ($jsondata["zipc"]),
                ":id14" => ($jsondata["stat"]),
                ":id15" => ($d),
                ":id" => ($jsondata["gateUser_id"])
            ));
            if (($jsondata["email"]) != null) {
                $query4 = 'UPDATE `gateway_email_ids` SET
                    `gateway_email_ids_email`=:id1,
                    `gateway_email_ids_updated_at`=:id2
                    WHERE `gateway_email_ids_gateway_id`=:id';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => ($jsondata["email"]),
                    ":id2" => ($d),
                    ":id" => ($jsondata["gateUser_id"])
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
            $query5 = 'UPDATE `gateway_cell_numbers` SET
                  `gateway_cell_numbers_cell_code`=:id1,
                  `gateway_cell_numbers_cell_number`=:id2,
                  `gateway_cell_numbers_updated_at`=:id3
                  WHERE `gateway_cell_numbers_gateway_id`=:id';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id1" => $result[0]["portal_countries_Phone"],
                ":id2" => ($jsondata["mobile"]),
                ":id3" => ($d),
                ":id" => ($jsondata["gateUser_id"])
            ));
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_gateway_' . $jsondata["gateUser_id"]);
            $query6 = 'UPDATE `gateway` SET `gateway_directory` = :id1 WHERE `gateway_id`=:id2';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => ($directory),
                ":id2" => ($jsondata["gateUser_id"])
            ));
            if (isset($this->postBaseFile['file'])) {
                $verImages = $this->uploadFileToServer(array(
                    "file_name" => $this->postBaseFile['file']['name'],
                    "file_size" => $this->postBaseFile['file']['size'],
                    "file_tmp" => $this->postBaseFile['file']['tmp_name'],
                    "file_type" => $this->postBaseFile['file']['type'],
                    "directory" => $directory,
                    "target" => 'Proof',
                    "picid" => $result1[0]["gateway_photo_id"],
                ));
                if ($verImages["status"] == "error") {
                    $pic_flag = false;
                }
            }
            if ($res1 && $res2 && $res3 && $res4 && $pic_flag && $res5 && $res6 && $res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function EditOperator() {
        $jsondata = array(
            "operator_id" => base64_decode($this->postBaseData["operator_id"]),
            "gate" => $this->postBaseData["gate"],
            "name" => $this->postBaseData["name"],
            "ocode" => $this->postBaseData["ocode"],
            "alias" => $this->postBaseData["alias"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators` WHERE `gateway_operator_name`= :name AND `gateway_operator_gateway_id`=:gate AND `gateway_operator_id`!=:id');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":gate" => ($jsondata["gate"]),
            ":id" => ($jsondata["operator_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `gateway_operators` SET
                         `gateway_operator_gateway_id` = :id1,
                         `gateway_operator_name` = :id2,
                         `gateway_operator_lt_code`= :id3,
                         `gateway_operator_alias` = :id4,
                         `gateway_operator_commission_fixed` = :id5,
                         `gateway_operator_commission_variable` = :id6,
                         `gateway_operator_updated_at`= :id7
                          WHERE `gateway_operator_id`= :id
                          AND `gateway_operator_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id" => ($jsondata["operator_id"]),
                ":id1" => ($jsondata["gate"]),
                ":id2" => ($jsondata["name"]),
                ":id3" => ($jsondata["ocode"]),
                ":id4" => ($jsondata["alias"]),
                ":id5" => ($jsondata["flat"]),
                ":id6" => ($jsondata["variable"]),
                ":id7" => date("Y-m-d H:i:s"),
            ));
            $operator_id = $this->db->lastInsertId();
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function EditOperatorType() {
        $jsondata = array(
            "operator_type_id" => base64_decode($this->postBaseData["operator_type_id"]),
            "operator" => $this->postBaseData["operator"],
            "optype" => $this->postBaseData["optype"],
            "optypecode" => $this->postBaseData["optypecode"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators_type` WHERE `gateway_operator_type_operator_id`= :operator AND `gateway_operator_type_type`=:optype AND `gateway_operator_type_id`=:id');
        $res = $stm->execute(array(
            ":operator" => ($jsondata["operator"]),
            ":optype" => ($jsondata["optype"]),
            ":id" => ($jsondata["operator_type_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `gateway_operators_type` SET
                         `gateway_operator_type_operator_id` = :id1,
                         `gateway_operator_type_type` = :id2,
                         `gateway_operator_type_lt_code`= :id3,
                         `gateway_operator_type_commission_fixed` = :id4,
                         `gateway_operator_type_commission_variable` = :id5,
                         `gateway_operator_type_updated_at`= :id6
                          WHERE `gateway_operator_type_id`= :id
                          AND `gateway_operator_type_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id" => ($jsondata["operator_type_id"]),
                ":id1" => ($jsondata["operator"]),
                ":id2" => ($jsondata["optype"]),
                ":id3" => ($jsondata["optypecode"]),
                ":id4" => ($jsondata["flat"]),
                ":id5" => ($jsondata["variable"]),
                ":id6" => date("Y-m-d H:i:s"),
            ));
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function DeleteGateway($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `gateway` SET
                         `gateway_status_id` = :stat,
                         `gateway_updated_at` = :id1
                          WHERE `gateway_id`= :id';
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