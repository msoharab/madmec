<?php

class Stock_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function AddProducts() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "cost" => $this->postBaseData["cost"],
            "weight" => $this->postBaseData["weight"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `name` FROM `product` WHERE `name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `product` (
                    `id`,
                    `name`,
                    `cost`,
                    `weight`)  VALUES('
                    . ':id1,
                      :id2,
                      :id3,
                      :id4);';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["name"]),
                ":id3" => ($jsondata["cost"]),
                ":id4" => ($jsondata["weight"])
            ));

            if ($res && $res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function ListProducts() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listprods = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        $searchqr = ' AND (ad.`name`           LIKE :col1
                             OR ad.`cost`      LIKE :col2
                             OR ad.`weight`    LIKE :col3)';
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
                    $orderqr = ' ORDER BY ad.`cost` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`weight` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS prdid,
            ad.`name` AS prdname,
            ad.`cost` AS prdcost,
            ad.`weight` AS prdweig
            FROM `product` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listprods = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Name" => ucfirst($result[$i]["prdname"]),
                        "Cost" => $result[$i]["prdcost"],
                        "Weight" => $result[$i]["prdweig"],
                        "Edit" => '<a href="' . $this->config["EGPCSURL"] . $this->config["CTRL_20"] . 'ProductEdit/' . base64_encode($result[$i]["prdid"]) . '" target="_self" class="btn btn-block btn-primary">Edit<a>',
                        "Delete" => '<a href="#" data-delProduct="' . base64_encode($result[$i]["prdid"]) . '" id="listuser_' . $result[$i]["prdid"] . '" class="btn btn-block btn-danger">Delete<a>',
                        "btnid" => '#listuser_' . $result[$i]["prdid"],
                        "id" => $result[$i]["prdid"],
                    ));
                }
                $listprods["draw"] = $this->postBaseData["draw"];
                $listprods["recordsTotal"] = $num_posts;
                $listprods["recordsFiltered"] = $num_posts;
                $listprods["data"] = $data;
                /* Chop Array */
				if($this->postBaseData["length"] != -1){
					$initial = isset($this->postBaseData["start"]) ? (integer) $this->postBaseData["start"] : 0;
					$final = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"] + $initial) : (10 + $initial);
					$length = isset($this->postBaseData["length"]) ? (integer) ($this->postBaseData["length"]) : 10;
					$listprods["data"] = array_slice($data, $initial, $this->postBaseData["length"]);
				}
				else{
					$listprods["data"] = $data;
				}
            }
        }
        return $listprods;
    }

    public function EditProduct() {
        $jsondata = array(
            "pid" => base64_decode($this->postBaseData["id"]),
            "name" => $this->postBaseData["name"],
            "cost" => $this->postBaseData["cost"],
            "weight" => $this->postBaseData["weight"],
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        /* Products */
        $query2 = 'UPDATE `product` SET
                        `name`=:id2,
                        `cost`=:id3,
                        `weight`=:id4,
                        `dou` = :id5
                        WHERE `id`=:id1
                        AND `status` = :id6';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => ($jsondata["pid"]),
            ":id2" => ($jsondata["name"]),
            ":id3" => ($jsondata["cost"]),
            ":id4" => ($jsondata["weight"]),
            ":id5" => date("Y-m-d H:i:s"),
            ":id6" => ($jsondata["stat"])
        ));
        if ($res2) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["id"] = base64_decode($this->postBaseData["id"]);
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function DeleteProduct($id) {
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
        } else {
            $this->db->rollBack();
            $jsondata["status"] = "error";
        }
        return $jsondata;
    }

}

?>