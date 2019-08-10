<?php

class Dashboard_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    /* Product */

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
            ad.`description` AS descrip,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph.`ver3` IS NULL OR ph.`ver3` = ""
            THEN "' . $this->config["DEFAULT_PRD_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph.`ver3`)
            END AS pic,
            IF(ad.`status` = 4, 6,4) AS actionid
            FROM `product` AS ad
        LEFT JOIN `photo` AS ph ON ph.`id` = ad.`photo_id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ph.`status` = 4' . $searchqr . ' ' . $orderqr;
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
                        "Image" => '<img src="' . $result[$i]["pic"] . '" height="100" width="100"/>',
//                        "Image" => '<a href="' . $result[$i]["pic"] . '" target="_new" class="btn btn-block btn-warning">View<a>',
                        "Description" => $result[$i]["descrip"],
                        "Date" => $result[$i]["date"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'ProductEdit/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="#" data-delProduct="' . $result[$i]["id"] . '" id="listuser_' . $result[$i]["id"] . '" >Delete<a>',
                        "btnid" => '#listuser_' . $result[$i]["id"],
                        "id" => $result[$i]["id"],
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
            "pid" => base64_decode($this->postBaseData["id"]),
            "name" => $this->postBaseData["name"],
            "brand" => $this->postBaseData["brand"],
            "category" => $this->postBaseData["category"],
            "quantity" => $this->postBaseData["quantity"],
            "price" => $this->postBaseData["price"],
            "description" => $this->postBaseData["description"],
            "photo_id" => $this->postBaseData["photo_id"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* Products */
        $query2 = 'UPDATE `product` SET
                        `name`=:id2,
                        `brand`=:id4,
                        `category`=:id5,
                        `quantity`=:id6,
                        `price`=:id7,
                        `description`=:id8,
                        `dou` = :id9
                        WHERE `id`=:id1
                        AND `status` = :id10';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => ($jsondata["pid"]),
            ":id2" => ($jsondata["name"]),
            ":id4" => ($jsondata["brand"]),
            ":id5" => ($jsondata["category"]),
            ":id6" => ($jsondata["quantity"]),
            ":id7" => ($jsondata["price"]),
            ":id8" => ($jsondata["description"]),
            ":id9" => date("Y-m-d H:i:s"),
            ":id10" => ($jsondata["stat"])
        ));
        array_push($jsondata["picids"], $jsondata["photo_id"]);
        //":id3" => ($photo_id),
        if ($res2) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["id"] = base64_decode($this->postBaseData["id"]);
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function DeleteProduct() {
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
            ":id" => ($this->postBaseData["id"]),
            ":stat" => ($jsondata["stat"]),
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

    /* Member */

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
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph.`ver3` IS NULL OR ph.`ver3` = ""
            THEN "' . $this->config["DEFAULT_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph.`ver3`)
            END AS pic,
            ad.`facebook_link` AS faceb1,
            ad.`twitter_link` AS faceb2,
            ad.`googleP_link` AS faceb3
            FROM `team_members` AS ad
        LEFT JOIN `photo` AS ph ON ph.`id` = ad.`photo_id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ph.`status` = 4' . $searchqr . ' ' . $orderqr;
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
                    if ($result[$i]["faceb1"] === NULL) {
                        $result[$i]["faceb1"] = "#";
                    }
                    if ($result[$i]["faceb2"] === NULL) {
                        $result[$i]["faceb2"] = "#";
                    }
                    if ($result[$i]["faceb3"] === NULL) {
                        $result[$i]["faceb3"] = "#";
                    }
                    $address = str_replace($this->order, $this->replace, $result[$i]["addr"]);
                    array_push($data, array(
                        "#" => $i + 1,
                        "Member Name" => ucfirst($result[$i]["name"]),
                        "Designation" => $result[$i]["desig"],
                        "Mobile" => $result[$i]["email"],
                        "Email" => $result[$i]["cell"],
                        "Address" => $address,
                        "Facebook" => '<a href="' . $result[$i]["faceb1"] . '" target="_new" class="btn btn-block btn-info">Facebook<a><br />' .
                        '<a href="' . $result[$i]["faceb3"] . '" target="_new" class="btn btn-block btn-info">Google+<a><br />' .
                        '<a href="' . $result[$i]["faceb2"] . '" target="_new" class="btn btn-block btn-info">Twitter<a><br />',
                        "Date" => date("d-M-Y", strtotime($result[$i]["doc"])),
                        "Image" => '<img src="' . $result[$i]["pic"] . '" height="100" width="100"/>',
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_9"] . 'MemberEdit/' . base64_encode($result[$i]["id"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="#" data-delMember="' . $result[$i]["id"] . '" id="listuser_' . $result[$i]["id"] . '" >Delete<a>',
                        "btnid" => '#listuser_' . $result[$i]["id"],
                        "id" => $result[$i]["id"],
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

    public function EditMember() {
        $jsondata = array(
            "pid" => base64_decode($this->postBaseData["id"]),
            "name" => $this->postBaseData["name"],
            "designation" => $this->postBaseData["designation"],
            "email" => $this->postBaseData["email"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "facebook" => $this->postBaseData["facebook"],
            "twitter" => $this->postBaseData["twitter"],
            "googlep" => $this->postBaseData["googlep"],
            "address" => $this->postBaseData["address"],
            "photo_id" => $this->postBaseData["photo_id"],
            "stat" => 4,
            "id" => 0,
            "picids" => array(),
            "imgstatus" => NULL,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* Members */
        $query2 = 'UPDATE `team_members` SET
                        `name`=:id2,
                        `designation`=:id3,
                        `email`=:id4,
                        `cell_1`=:id5,
                        `cell_2`=:id6,
                        `facebook_link`=:id7,
                        `twitter_link`=:id8,
                        `googleP_link`=:id9,
                        `address`=:id10,
                        `dou` = :id12
                        WHERE `id`=:id1
                        AND `status` = :id13';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => ($jsondata["pid"]),
            ":id2" => ($jsondata["name"]),
            ":id3" => ($jsondata["designation"]),
            ":id4" => ($jsondata["email"]),
            ":id5" => ($jsondata["mobile1"]),
            ":id6" => ($jsondata["mobile2"]),
            ":id7" => ($jsondata["facebook"]),
            ":id8" => ($jsondata["twitter"]),
            ":id9" => ($jsondata["googlep"]),
            ":id10" => ($jsondata["address"]),
            ":id12" => date("Y-m-d H:i:s"),
            ":id13" => ($jsondata["stat"])
        ));
        array_push($jsondata["picids"], $jsondata["photo_id"]);
        if ($res2) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["id"] = base64_decode($this->postBaseData["id"]);
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function DeleteMember() {
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `team_members` SET
                         `status` = :stat
                          WHERE `id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => ($this->postBaseData["id"]),
            ":stat" => ($jsondata["stat"]),
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

    /* Member */

    public function ListEnquiry() {
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
                        OR ad.`email`          LIKE :col2
                        OR ad.`phone`    LIKE :col3
                        OR ad.`subject`     LIKE :col4
                        OR ad.`message`      LIKE :col5
                        OR ad.`doe`      LIKE :col6)';
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
                    $orderqr = ' ORDER BY ad.`email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`phone` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad. `subject` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`message` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`doe` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS id,
            ad.`name` AS name,
            ad.`email` AS email,
            ad.`phone` AS cell,
            ad.`subject` AS sub,
            ad.`message` AS mes,
            ad.`doe` AS doe
            FROM `contact` AS ad
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
                    //$address = str_replace($this->order, $this->replace, $result[$i]["addr"]);
                    array_push($data, array(
                        "#" => $i + 1,
                        "Name" => ucfirst($result[$i]["name"]),
                        "Email" => $result[$i]["email"],
                        "Mobile" => $result[$i]["cell"],
                        "Subject" => $result[$i]["sub"],
                        "Message" => $result[$i]["mes"],
                        "Date" => date("d-M-Y", strtotime($result[$i]["doe"])),
                        "Delete" => '<a href="#" data-delEnquiry="' . $result[$i]["id"] . '" id="listuser_' . $result[$i]["id"] . '" >Delete<a>',
                        "btnid" => '#listuser_' . $result[$i]["id"],
                        "id" => $result[$i]["id"],
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

    public function DeleteEnquiry() {
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `contact` SET
                         `status` = :stat
                          WHERE `id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => ($this->postBaseData["id"]),
            ":stat" => ($jsondata["stat"]),
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

}

?>