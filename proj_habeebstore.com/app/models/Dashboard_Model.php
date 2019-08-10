<?php
class Dashboard_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
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
        $searchqr = ' AND (ad.`reference_id`           LIKE :col1
                             OR ad.`total_items`          LIKE :col2
                             OR ad.`total_amt`          LIKE :col3
                             OR ad.`doc`    	LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`reference_id` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`total_items` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`total_amt` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`doc` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS prdid,
            ad.`reference_id` AS prdname,
            ad.`total_items` AS prdcost,
            ad.`total_amt` AS prdweig,
            ad.`doc` AS prddoc
            FROM `bill` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . ($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listprods = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Reference" => ucfirst($result[$i]["prdname"]),
                        "Total Items" => $result[$i]["prdcost"],
                        "Total Amount" => $result[$i]["prdweig"],
                        //"Date" => date("d-m-Y",strtotime($result[$i]["prddoc"])),
                        "Date" => date("Y-m-d",strtotime($result[$i]["prddoc"])),
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
}
?>