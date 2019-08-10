<?php
class Manage_Model extends BaseModel {

    private $para, $logindata, $UserId, $GymId, $GymData;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->GymData = $_SESSION["GYM_DETAILS"];
        $this->GymId = $this->GymData["gymid"];
    }
    /* Facility */
    public function AddFacility() {
        $jsondata = array(
            "facility" => $this->postBaseData["facility"],
            "status" => $this->postBaseData["status"],
            "stat" => 4,
        );
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO `' . $this->GymData["db_name"] . '`.`gym_facility`(
                        `id`,
                        `name`,
                        `status`)Values('
                . ':id1,
                        :id2,
                        :id3)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["facility"]),
            ":id3" => mysql_real_escape_string($jsondata["stat"])
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function chageFacilityStatusDB($id, $stat) {
        $jsondata = array(
            "stat" => $stat,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_facility` SET
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    public function ListFacilityShow() {
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
        $searchqr = ' AND (ad.`name`    LIKE :col1)';
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
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS facid,
            ad.`name` AS facname
            FROM `' . $this->GymData["db_name"] . '`. `gym_facility` AS ad
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Facility" => ucfirst($result[$i]["facname"]),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_28"] . 'EditFacility/' . base64_encode($result[$i]["facid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Deactive" => '<a href="#" data-defacility="' . base64_encode($result[$i]["facid"]) . '" target="_self" class="btn btn-block btn-danger deactivate">Deactive<a>'
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
    public function ListFacilityReactive() {
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
        $searchqr = ' AND (ad.`name`    LIKE :col1)';
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
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS facid,
            ad.`name` AS facname
            FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS ad
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` != 4' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Facility" => ucfirst($result[$i]["facname"]),
                        "Reactive" => '<a href="#" data-acfacility="' . base64_encode($result[$i]["facid"]) . '" target="_self" class="btn btn-block btn-success activate">Activate<a>'
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
    public function ShowFacility($uid) {
        $jsondata = array(
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_facility` SET
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    public function DeleteFacility($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_facility` SET
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
        } else {
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    /* Offer */
    public function AddOffer() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "duration" => $this->postBaseData["duration"],
            "minmember" => $this->postBaseData["minmember"],
            "facility" => $this->postBaseData["facility"],
            "price" => $this->postBaseData["price"],
            "descrip" => $this->postBaseData["descrip"],
            "stat" => 4,
        );
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO `' . $this->GymData["db_name"] . '`.`gym_offers`(
                        `id`,
                        `name`,
                        `duration_id`,
                        `facility_id`,
                        `description`,
                        `cost`,
                        `min_members_id`,
                        `status`)Values('
                . ':id1,
                        :id2,
                        :id3,
                        :id5,
                        :id6,
                        :id7,
                        :id8,
                        :id9)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["name"]),
            ":id3" => mysql_real_escape_string($jsondata["duration"]),
            ":id5" => mysql_real_escape_string($jsondata["facility"]),
            ":id6" => mysql_real_escape_string($jsondata["descrip"]),
            ":id7" => mysql_real_escape_string($jsondata["price"]),
            ":id8" => mysql_real_escape_string($jsondata["minmember"]),
            ":id9" => mysql_real_escape_string($jsondata["stat"])
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function chageOfferStatusDB($id, $stat) {
        $jsondata = array(
            "stat" => $stat,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_offers` SET
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    public function ListOffer() {
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
        $searchqr = ' AND (ad.`name`    LIKE :col1
                        OR (SELECT fc.`name` FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS fc WHERE  fc.`id` = ad.`facility_id`)    LIKE :col2
                        OR (SELECT fd.`duration` FROM `' . $this->GymData["db_name"] . '`.`master_offer_duration` AS fd WHERE  fd.`id` = ad.`duration_id`)    LIKE :col3
                        OR ad.`description`    LIKE :col4
                        OR ad.`cost`     LIKE :col5
                        OR (SELECT CONCAT(fm.`name`," - ",fm.`min_members`) FROM `' . $this->GymData["db_name"] . '`.`master_min_members` AS fm WHERE  fm.`id` = ad.`min_members_id`)     LIKE :col6)';
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
                    $orderqr = ' ORDER BY ad.`duration_id` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`cost` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS offid,
            ad.`name` AS offname,
            (SELECT fc.`name` FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS fc WHERE  fc.`id` = ad.`facility_id`) AS offfaci,
            (SELECT fd.`duration` FROM `' . $this->GymData["db_name"] . '`.`master_offer_duration` AS fd WHERE  fd.`id` = ad.`duration_id`) AS offdura,
            (SELECT CONCAT(fm.`name`," - ",fm.`min_members`) AS mmm FROM `' . $this->GymData["db_name"] . '`.`master_min_members` AS fm WHERE  fm.`id` = ad.`min_members_id`) AS offmem,
            ad.`description` AS offdesc,
            ad.`cost` AS offcost
            FROM `' . $this->GymData["db_name"] . '`.`gym_offers` AS ad
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = " ' . $this->postBaseData["action"]["stat"] . '"  ' . $searchqr . ' ' . $orderqr;
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
                        "Offer Name" => ucfirst($result[$i]["offname"]),
                        "Duration" => $result[$i]["offdura"],
                        "Facility" => $result[$i]["offfaci"],
                        "Cost" => $result[$i]["offcost"],
                        "Min Members" => $result[$i]["offmem"],
                        "Description" => $result[$i]["offdesc"],
                        "View" => '<a href="' . $this->config["URL"] . $this->config["CTRL_28"] . 'ViewOffers/' . base64_encode($result[$i]["offid"]) . '" target="_self" class="btn btn-block btn-info">View<a>',
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_28"] . 'EditOffer/' . base64_encode($result[$i]["offid"]) . '" target="_self" class="btn btn-block btn-warning">Edit<a>',
                        "Status" => '<a href="#" class="btn btn-block ' . $this->postBaseData["action"]["btnclass"] . ' " id="' . $this->postBaseData["action"]["btntext"] . '_' . $i . '"> ' . $this->postBaseData["action"]["btntext"] . ' <a>',
                        "actionbtn" => $this->postBaseData["action"]["btntext"] . '_' . $i,
                        "ide" => base64_encode($result[$i]["offid"]),
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
    public function DeleteOffer($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_offers` SET
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
        } else {
            $jsondata["status"] = "error";
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
            ":id" => mysql_real_escape_string($jsondata["id"]),
            ":id1" => mysql_real_escape_string($jsondata["name"]),
            ":id2" => mysql_real_escape_string($jsondata["duration"]),
            ":id4" => mysql_real_escape_string($jsondata["facility"]),
            ":id5" => mysql_real_escape_string($jsondata["descrip"]),
            ":id6" => mysql_real_escape_string($jsondata["price"]),
            ":id7" => mysql_real_escape_string($jsondata["minmember"]),
            ":id8" => mysql_real_escape_string($jsondata["stat"])
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
    public function AddPackage() {
        $jsondata = array(
            "packType" => $this->postBaseData["packType"],
            "facility" => $this->postBaseData["facility"],
            "name" => $this->postBaseData["name"],
            "minmem" => $this->postBaseData["minmem"],
            "numofSess" => $this->postBaseData["numofSess"],
            "price" => $this->postBaseData["price"],
            "desp" => $this->postBaseData["desp"],
            "stat" => 4,
        );
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO `' . $this->GymData["db_name"] . '`.`gym_packages`(
                        `id`,
                        `package_type_id`,
                        `facility_id`,
                        `name`,
                        `number_of_sessions`,
                        `cost`,
                        `min_members_id`,
                        `description`,
                        `status`)Values('
                . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id9,
                        :id8)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["packType"]),
            ":id3" => mysql_real_escape_string($jsondata["facility"]),
            ":id4" => mysql_real_escape_string($jsondata["name"]),
            ":id5" => mysql_real_escape_string($jsondata["numofSess"]),
            ":id6" => mysql_real_escape_string($jsondata["price"]),
            ":id7" => mysql_real_escape_string($jsondata["minmem"]),
            ":id8" => mysql_real_escape_string($jsondata["stat"]),
            ":id9" => mysql_real_escape_string($jsondata["desp"]),
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function chagePackageStatusDB($id, $stat) {
        $jsondata = array(
            "stat" => $stat,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_packages` SET
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    public function ListPackages() {
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
        $searchqr = ' AND (ad.`name`    LIKE :col1
                        OR ad.`number_of_sessions`    LIKE :col2
                        OR ad.`cost`   LIKE :col3
                        OR (SELECT fc.`name` FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS fc WHERE  fc.`id` = ad.`facility_id`)    LIKE :col4
                        OR (SELECT CONCAT(fm.`name`," - ",fm.`min_members`) FROM `' . $this->GymData["db_name"] . '`.`master_min_members` AS fm WHERE  fm.`id` = ad.`min_members_id`)     LIKE :col5)';
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
                case 3:
                    $orderqr = ' ORDER BY ad.`facility_id` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`min_members_id` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`number_of_sessions` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`cost` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS facid,
            (SELECT fc.`name` FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS fc WHERE  fc.`id` = ad.`facility_id`) AS packfaci,
            (SELECT CONCAT(fm.`name`," - ",fm.`min_members`) AS mmm FROM `' . $this->GymData["db_name"] . '`.`master_min_members` AS fm WHERE  fm.`id` = ad.`min_members_id`) AS packmem,
            (SELECT CONCAT(pn.`package_name`) AS mmm FROM `' . $this->GymData["db_name"] . '`.`master_package_name` AS pn WHERE  pn.`id` = ad.`package_type_id`) AS packtype,
            ad.`name` AS facname,
            ad.`number_of_sessions` AS facsess,
            ad.`description` AS descrip,
            ad.`cost` AS facCost
            FROM `' . $this->GymData["db_name"] . '`.`gym_packages` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL) AND ad.`status` =  "' . $this->postBaseData["action"]["stat"] . '"  ' . $searchqr . '  ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col5', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Package name" => ucfirst($result[$i]["facname"]),
                        "Package type" => ucfirst($result[$i]["packtype"]),
                        "Facility" => ucfirst($result[$i]["packfaci"]),
                        "Min Members" => $result[$i]["packmem"],
                        "Number of Sessions" => $result[$i]["facsess"],
                        "Cost" => $result[$i]["facCost"],
                        "Description" => $result[$i]["descrip"],
                        "View" => '<a href="' . $this->config["URL"] . $this->config["CTRL_28"] . 'ViewPackage/' . base64_encode($result[$i]["facid"]) . '" target="_self" class="btn btn-block btn-info">View<a>',
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_28"] . 'EditPackage/' . base64_encode($result[$i]["facid"]) . '" target="_self" class="btn btn-block btn-warning">Edit<a>',
                        "Status" => '<a href="#" class="btn btn-block ' . $this->postBaseData["action"]["btnclass"] . ' " id="' . $this->postBaseData["action"]["btntext"] . '_' . $i . '"> ' . $this->postBaseData["action"]["btntext"] . ' <a>',
                        "actionbtn" => $this->postBaseData["action"]["btntext"] . '_' . $i,
                        "ide" => base64_encode($result[$i]["facid"]),
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
    public function DeletePackage($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_packages` SET
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }
    public function EditPackage() {
        $jsondata = array(
            "id" => $this->postBaseData["packid"],
            "packType" => $this->postBaseData["packType"],
            "facility" => $this->postBaseData["facility"],
            "name" => $this->postBaseData["name"],
            "minmem" => $this->postBaseData["minmem"],
            "numofSess" => $this->postBaseData["numofSess"],
            "price" => $this->postBaseData["price"],
            "desp" => $this->postBaseData["desp"],
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query1 = 'UPDATE `' . $this->GymData["db_name"] . '`.`gym_packages` SET
                                `package_type_id`=:id1,
                                `number_of_sessions`=:id2,
                                `cost`=:id3,
                                `facility_id`=:id4,
                                `name`=:id5,
                                `min_members_id`=:id6,
                                `description`=:id8,
                                `status`=:id7
                                 WHERE `id`=:id';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id" => mysql_real_escape_string($jsondata["id"]),
            ":id1" => mysql_real_escape_string($jsondata["packType"]),
            ":id2" => mysql_real_escape_string($jsondata["numofSess"]),
            ":id3" => mysql_real_escape_string($jsondata["price"]),
            ":id4" => mysql_real_escape_string($jsondata["facility"]),
            ":id5" => mysql_real_escape_string($jsondata["name"]),
            ":id6" => mysql_real_escape_string($jsondata["minmem"]),
            ":id7" => mysql_real_escape_string($jsondata["stat"]),
            ":id8" => mysql_real_escape_string($jsondata["desp"]),
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
}
?>