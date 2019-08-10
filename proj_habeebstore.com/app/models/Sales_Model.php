<?php

class Sales_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function ProductSearch() {
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
        $searchqr = ' AND (ad.`name`    LIKE :col1
                        OR ad.`cost`    LIKE :col2)';
        $query = 'SELECT
            ad.`id` AS prdid,
            ad.`name` AS prdname,
            ad.`cost` AS prdcost
        FROM `product` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`weight` = "' . mysql_real_escape_string($this->postBaseData["loadProd"]) . '" AND ad.`status` = 4 ' . $searchqr . ' ORDER BY (ad.`id`) DESC';

        $stm = $this->db->prepare($query);
        if (isset($this->postBaseData["q"]))
            $keyword = "%" . mysql_real_escape_string($this->postBaseData["q"]) . "%";
        else
            $keyword = "%%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["prdname"]; $i++) {
            $result[$i]["prdcost"] = $result[$i]["prdcost"] ? (integer) $result[$i]["prdcost"] : 0;
            array_push($data["items"], array(
                "index" => ($i + 1),
                "text" => $result[$i]["prdname"] . " - " . $result[$i]["prdcost"] . "/-",
                //"id" => (integer) $result[$i]["pk"],
//                "id" => $this->config["URL"] . $this->config["CTRL_21"] . 'AddProductSale/' . $result[$i]["prdid"],
                "id" => $result[$i]["prdid"],
                "name" => $result[$i]["prdname"],
                "cost" => $result[$i]["prdcost"],
            ));
        }
        return $data;
    }

    public function BillGenerate() {
        $jsondata = array(
            "refer" => "",
            "stat" => 4,
            "status" => 'error'
        );
		if(isset($this->postBaseData["attr"]) && count($this->postBaseData["attr"])){
			$this->db->beginTransaction();
			$query = 'INSERT INTO  `bill` (
						`id`,
						`reference_id`,
						`total_items`,
						`total_amt`
						)  VALUES(
						:id1,
						:id2,
						:id3,
						:id4);';
			$stm = $this->db->prepare($query);
			$res = $stm->execute(array(
				":id1" => NULL,
				":id2" => ($this->postBaseData["attr"][count($this->postBaseData["attr"]) - 2]["RID"]),
				":id3" => (count($this->postBaseData["attr"]) - 1),
				":id4" => ($this->postBaseData["attr"][count($this->postBaseData["attr"]) - 1]["Amount"]),
			));
			$bill_id = $this->db->lastInsertId();
			$data = array();
			for ($i = 0; $i < count($this->postBaseData["attr"]) && isset($this->postBaseData["attr"][$i]["idDB"]); $i++) {
				$data[] = array(
					"product_id" => $this->postBaseData["attr"][$i]["idDB"],
					"bill_id" => $bill_id,
					"cost" => $this->postBaseData["attr"][$i]["ctDB"],
					"quantity" => $this->postBaseData["attr"][$i]["wtDB"],
					"total_price" => $this->postBaseData["attr"][$i]["amtDB"],
					"doc" => date("Y-m-d H:i:s"),
				);
			}
			$datafields = array("`product_id`", "`bill_id`", "`cost`", "`quantity`", "`total_price`", "`doc`");
			$question_marks = array();
			$insert_values = array();
			foreach ($data as $d) {
				$question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
				$insert_values = array_merge($insert_values, array_values($d));
			}
			$query2 = 'INSERT INTO `sales` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
			$stm = $this->db->prepare($query2);
			$res1 = $stm->execute($insert_values);
			if ($res && $res1) {
				$this->db->commit();
				$jsondata["status"] = "success";
			} else {
				$this->db->rollBack();
			}
		}
        return $jsondata;
    }

    public function AddProductKg() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "kg" => $this->postBaseData["kg"],
            "grams" => $this->postBaseData["grams"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `product_id` FROM `sales` WHERE `product_id`= :id');
        $res = $stm->execute(array(
            ":id" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `sales` (
                    `id`,
                    `product_id`,
                    `quantity`)  VALUES('
                    . ':id1,
                      :id2,
                      :id4);';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["name"]),
                ":id4" => ($jsondata["kg"] . '.' . $jsondata["grams"])
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

    public function AddProductUnit() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "quantity" => $this->postBaseData["quantity"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `product_id` FROM `sales` WHERE `product_id`= :id');
        $res = $stm->execute(array(
            ":id" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `sales` (
                    `id`,
                    `product_id`,
                    `quantity`)  VALUES('
                    . ':id1,
                      :id2,
                      :id4);';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["name"]),
                ":id4" => ($jsondata["quantity"])
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

    public function SaleList() {
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
        $searchqr = ' AND (pd.`name`           LIKE :col1
                             OR pd.`cost`          LIKE :col2
                             OR ad.`quantity`    LIKE :col3)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY pd.`name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY pd.`cost` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`quantity` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS prdid,
            pd.`name` AS prdname,
            pd.`cost` AS prdcost,
            ad.`quantity` AS prdweig
            FROM `sales` AS ad
        LEFT JOIN `product` AS pd ON pd.`id` = ad.`product_id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
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
                        "Quantity" => $result[$i]["prdweig"],
                        "Amount" => $result[$i]["prdcost"] * $result[$i]["prdweig"],
                        "Delete" => '<a href="" data-delProduct="' . base64_encode($result[$i]["prdid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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

    public function DeleteProduct($id, $stat) {
        $jsondata = array(
            "stat" => $stat,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `sales` SET
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