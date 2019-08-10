<?php
class Restaurants_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
    public function ListBusinessInfo() {
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
        $searchqr = ' AND (ad.`company_id`       LIKE :col1
                        OR ad.`company_name`    LIKE :col2
                        OR ad.`company_website`    LIKE :col3
                        OR ad.`company_addressline`    LIKE :col4
                        OR ad.`company_country`    LIKE :col5
                        OR ad.`company_city`    LIKE :col6
                        OR cn.`company_cell_numbers_cell_number`    LIKE :col7
                        OR ad.`company_proof_id`    LIKE :col8
                        OR ad.`company_doc`    LIKE :col9)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`company_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`company_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`company_website` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`company_addressline` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`company_country` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`company_city` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY cn.`company_cell_numbers_cell_number` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`company_proof_id` ' . $dir;
                    break;
                case 8:
                    $orderqr = ' ORDER BY ad.`company_doc` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`company_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`company_id` AS comid,
            ad.`company_name` AS comname,
            ad.`company_website` AS comweb,
            ad.`company_addressline` AS comadr,
            ad.`company_country` AS comctn,
            ad.`company_city` AS comct,
            cn.`company_cell_numbers_cell_number` AS comcel,
            ad.`company_proof_id` AS comprof,
            ad.`company_doc` AS comdate
        FROM `company` AS ad
        LEFT JOIN `company_cell_numbers` AS cn ON cn.`company_cell_numbers_company_id` = ad.`company_id`
        WHERE (ad.`company_id` != NULL
        OR ad.`company_id` IS NOT NULL)
        AND ad.`company_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Business Name" => ucfirst($result[$i]["comname"]),
                        "Website" => $result[$i]["comweb"],
                        "Address line" => $result[$i]["comadr"],
                        "Country" => $result[$i]["comctn"],
                        "City" => $result[$i]["comct"],
                        "Business Established" => $result[$i]["comdate"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'BusinessInfoEdit/' . base64_encode($result[$i]["comid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteBusinessInfo/' . base64_encode($result[$i]["comid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListBusinessAddr() {
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
        $searchqr = ' AND (ad.`company_id`       LIKE :col1
                        OR ad.`company_name`    LIKE :col2
                        OR ad.`company_addressline`    LIKE :col3
                        OR ad.`company_country`    LIKE :col4
                        OR ad.`company_city`    LIKE :col5
                        OR cn.`company_cell_numbers_cell_number`    LIKE :col6
                        OR ad.`company_proof_id`    LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`company_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`company_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`company_addressline` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`company_country` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`company_city` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY cn.`company_cell_numbers_cell_number` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`company_proof_id` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`company_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`company_id` AS comid,
            ad.`company_name` AS comname,
            ad.`company_addressline` AS comadr,
            ad.`company_country` AS comctn,
            ad.`company_city` AS comct,
            cn.`company_cell_numbers_cell_number` AS comcel,
            ad.`company_proof_id` AS comprof
        FROM `company` AS ad
        LEFT JOIN `company_cell_numbers` AS cn ON cn.`company_cell_numbers_company_id` = ad.`company_id`
        WHERE (ad.`company_id` != NULL
        OR ad.`company_id` IS NOT NULL)
        AND ad.`company_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Business Name" => ucfirst($result[$i]["comname"]),
                        "Address line" => $result[$i]["comadr"],
                        "Country" => $result[$i]["comctn"],
                        "City" => $result[$i]["comct"],
                        "Mobile" => $result[$i]["comcel"],
                        "Proof ID" => $result[$i]["comprof"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'BusinessAddrEdit/' . base64_encode($result[$i]["comid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
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
    public function ListBankDetails() {
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
        $searchqr = ' AND (ad.`company_bank_accounts_id`       LIKE :col1
                        OR ad.`company_bank_accounts_ac_name`    LIKE :col2
                        OR ad.`company_bank_accounts_ac_no`    LIKE :col3
                        OR ad.`company_bank_accounts_name`    LIKE :col4
                        OR ad.`company_bank_accounts_branch`    LIKE :col5
                        OR ad.`company_bank_accounts_branch_code`    LIKE :col6
                        OR ad.`company_bank_accounts_IFSC`    LIKE :col7
                        OR t2.`company_name`    LIKE :col8)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_ac_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_ac_no` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_name` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_branch` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_branch_code` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_IFSC` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`company_bank_accounts_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`company_bank_accounts_id` AS combid,
            ad.`company_bank_accounts_ac_name` AS combname,
            ad.`company_bank_accounts_ac_no` AS combacc,
            ad.`company_bank_accounts_name` AS combnm,
            ad.`company_bank_accounts_branch` AS combbr,
            ad.`company_bank_accounts_branch_code` AS combbc,
            ad.`company_bank_accounts_IFSC` AS combifs,
            t2.`company_name`
        FROM `company_bank_accounts` AS ad
        LEFT JOIN `company` AS t2 ON t2.`company_id` = ad.`company_bank_accounts_company_id`
        WHERE (ad.`company_bank_accounts_id` != NULL
        OR ad.`company_bank_accounts_id` IS NOT NULL)
        AND ad.`company_bank_accounts_status_id` = 4
        AND t2.`company_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Company" => $result[$i]["company_name"],
                        "Account Name" => $result[$i]["combname"],
                        "Account Number" => $result[$i]["combacc"],
                        "Bank Name" => $result[$i]["combnm"],
                        "Branch" => $result[$i]["combbr"],
                        "Branch Code" => $result[$i]["combbc"],
                        "IFSC" => $result[$i]["combifs"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'BankDetailsEdit/' . base64_encode($result[$i]["combid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteBankDetails/' . base64_encode($result[$i]["combid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListSetCurrency() {
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
        $searchqr = ' AND (ad.`company_currency_id`       LIKE :col1
                        OR com.`company_name`    LIKE :col2
                        OR pc.`portal_currencies_CurrencyName`    LIKE :col3)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`company_currency_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY com.`company_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY pc.`portal_currencies_CurrencyName` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`company_currency_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`company_currency_id` AS comid,
            com.`company_name` AS comname,
            pc.`portal_currencies_CurrencyName` AS curname
        FROM `company_currency` AS ad
        LEFT JOIN `company` AS com ON com.`company_id` = ad.`company_currency_company_id`
        LEFT JOIN `portal_currencies` AS pc ON pc.`portal_currencies_id` = ad.`company_currency_portal_currencies_id`
        WHERE (ad.`company_currency_id` != NULL
        OR ad.`company_currency_id` IS NOT NULL)
        AND ad.`company_currency_status_id` = 4
        AND com.`company_status_id` = 4
        AND pc.`portal_currencies_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Company" => $result[$i]["comname"],
                        "Currency" => $result[$i]["curname"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'SetCurrencyEdit/' . base64_encode($result[$i]["comid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteSetCurrency/' . base64_encode($result[$i]["comid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListService() {
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
        $searchqr = ' AND (ad.`services_name`       LIKE :col1
                        OR ad.`services_lt_code`    LIKE :col2
                        OR ad.`services_created_at` LIKE :col3
                        OR ad.`services_commission_fixed`    LIKE :col4
                        OR ad.`services_commission_variable` LIKE :col5
                        OR t2.`company_name` LIKE :col6)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`services_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`services_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`services_lt_code` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`services_created_at` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY t2.`company_name` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`services_commission_fixed` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t2.`services_commission_variable` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`services_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`services_id` AS replyererid,
            ad.`services_name` AS replyername,
            ad.`services_lt_code` AS replyeremail,
            ad.`services_commission_fixed` AS replyerfixed,
            ad.`services_commission_variable` AS replyervariab,
            ad.`services_created_at` AS replyercell,
            t2.`company_name`
        FROM `services` AS ad
        LEFT JOIN `services_company` AS t1 ON t1.`services_company_services_id` = ad.`services_id`
        LEFT JOIN `company` AS t2 ON t2.`company_id` = t1.`services_company_company_id`
        WHERE (ad.`services_id` != NULL
        OR ad.`services_id` IS NOT NULL)
        AND ad.`services_status_id` = 4
        AND t1.`services_company_status_id` = 4
        AND t2.`company_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Company" => ucfirst($result[$i]["company_name"]),
                        "Service Name" => $result[$i]["replyername"],
                        "Service LT Code" => $result[$i]["replyeremail"],
                        "Flat Commission" => $result[$i]["replyerfixed"],
                        "Variable Commission" => $result[$i]["replyervariab"],
                        "Started At" => date("d-M-Y", strtotime($result[$i]["replyercell"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'ServiceEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteService/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
        $searchqr = ' AND (ad.`operator_name`       LIKE :col1
                        OR ad.`operator_lt_code`          LIKE :col2
                        OR ad.`operator_alias`    LIKE :col3
                        OR ad.`operator_commission_fixed`    LIKE :col4
                        OR ad.`operator_commission_variable` LIKE :col5
                        OR ad.`operator_created_at`     LIKE :col6
                        OR t2.`services_name`     LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`operator_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`operator_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`services_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`operator_lt_code` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`operator_alias` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`operator_created_at` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`operator_commission_fixed` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY t2.`operator_commission_variable` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`operator_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`operator_id` AS replyererid,
            ad.`operator_name` AS replyername,
            ad.`operator_lt_code` AS replyeremail,
            ad.`operator_commission_fixed` AS replyerfixed,
            ad.`operator_commission_variable` AS replyervariab,
            ad.`operator_alias` AS replyercell,
            ad.`operator_created_at`,
            t2.`services_name`
        FROM `operators` AS ad
        LEFT JOIN `services` AS t2 ON t2.`services_id` = ad.`operator_services_id`
        WHERE (ad.`operator_id` != NULL
        OR ad.`operator_id` IS NOT NULL)
        AND ad.`operator_status_id` = 4
        AND t2.`services_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Service Name" => ucfirst($result[$i]["services_name"]),
                        "Operator LT Code" => $result[$i]["replyeremail"],
                        "Operator Alias" => $result[$i]["replyercell"],
                        "Flat Commission" => $result[$i]["replyerfixed"],
                        "Variable Commission" => $result[$i]["replyervariab"],
                        "Started At" => date("d-M-Y", strtotime($result[$i]["operator_created_at"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'OperatorEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteOperator/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
        $searchqr = ' AND (ad.`operator_type_type`          LIKE :col1
                        OR ad.`operator_type_lt_code`       LIKE :col2
                        OR ad.`operator_type_created_at`    LIKE :col3
                        OR ad.`operator_type_commission_fixed`    LIKE :col4
                        OR ad.`operator_type_commission_variable` LIKE :col5
                        OR t1.`operator_name`               LIKE :col6
                        OR t2.`services_name`               LIKE :col7)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`operator_type_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t1.`operator_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`services_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`operator_type_type` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`operator_type_lt_code` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`operator_type_created_at` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`operator_type_commission_fixed` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY t2.`operator_type_commission_variable` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`operator_type_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`operator_type_id` AS replyererid,
            ad.`operator_type_type` AS replyername,
            ad.`operator_type_lt_code` AS replyeremail,
            ad.`operator_type_commission_fixed` AS replyerfixed,
            ad.`operator_type_commission_variable` AS replyervariab,
            ad.`operator_type_created_at`,
            t1.`operator_name`,
            t2.`services_name`
        FROM `operators_type` AS ad
        LEFT JOIN `operators` AS t1 ON t1.`operator_id` = ad.`operator_type_operator_id`
        LEFT JOIN `services` AS t2 ON t2.`services_id` = t1.`operator_services_id`
        WHERE (ad.`operator_type_id` != NULL
        OR ad.`operator_type_id` IS NOT NULL)
        AND ad.`operator_type_status_id` = 4
        AND t1.`operator_status_id` = 4
        AND t2.`services_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Operator Name" => ucfirst($result[$i]["operator_name"]),
                        "Service Name" => ucfirst($result[$i]["services_name"]),
                        "Operator Type" => $result[$i]["replyername"],
                        "Operator Type LT Code" => $result[$i]["replyeremail"],
                        "Flat Commission" => $result[$i]["replyerfixed"],
                        "Variable Commission" => $result[$i]["replyervariab"],
                        "Started At" => date("d-M-Y", strtotime($result[$i]["operator_type_created_at"])),
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'OperatorTypeEdit/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteOperatorType/' . base64_encode($result[$i]["replyererid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListBusinessType() {
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
        $searchqr = ' AND (ad.`portal_business_type_id`       LIKE :col1
                        OR ad.`portal_business_type_name`    LIKE :col2
                        OR t2.`portal_countries_Country`    LIKE :col3)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_business_type_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_business_type_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`portal_countries_Country` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_business_type_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_business_type_id` AS pbtid,
            ad.`portal_business_type_name` AS pbtame,
            t2.`portal_countries_Country` AS pbtcnt
        FROM `portal_business_type` AS ad
        LEFT JOIN `portal_countries` AS t2 ON t2.`portal_countries_id` = ad.`portal_business_type_portal_countries_id`
        WHERE (ad.`portal_business_type_id` != NULL
        OR ad.`portal_business_type_id` IS NOT NULL)
        AND ad.`portal_business_type_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Business Type" => ucfirst($result[$i]["pbtame"]),
                        "Country" => $result[$i]["pbtcnt"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'BusinessTypeEdit/' . base64_encode($result[$i]["pbtid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteBusinessType/' . base64_encode($result[$i]["pbtid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListCountries() {
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
        $searchqr = ' AND (ad.`portal_countries_id`       LIKE :col1
                        OR ad.`portal_countries_Country`    LIKE :col2
                        OR ad.`portal_countries_Capital`    LIKE :col3
                        OR ad.`portal_countries_fips`    LIKE :col4
                        OR cont.`portal_continents_continent_name`    LIKE :col5)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_countries_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_countries_Country` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_countries_Capital` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_countries_fips` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY cont.`portal_continents_continent_name` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_countries_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_countries_id` AS conid,
            ad.`portal_countries_Country` AS country,
            ad.`portal_countries_Capital` AS concap,
            ad.`portal_countries_fips` AS confip,
            cont.`portal_continents_continent_name` AS concnt
        FROM `portal_countries` AS ad
        LEFT JOIN `portal_continents` AS cont ON cont.`portal_continents_id` = ad.`portal_countries_portal_continents_id`
        WHERE (ad.`portal_countries_id` != NULL
        OR ad.`portal_countries_id` IS NOT NULL)
        AND ad.`portal_countries_status_id` = 4
        AND cont.`portal_continents_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Country Name" => ucfirst($result[$i]["country"]),
                        "Country Capital" => $result[$i]["concap"],
                        "Country Fips" => $result[$i]["confip"],
                        "Continent" => $result[$i]["concnt"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'CountriesEdit/' . base64_encode($result[$i]["conid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteCountries/' . base64_encode($result[$i]["conid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListCurrencies() {
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
        $searchqr = ' AND (ad.`portal_currencies_id`       LIKE :col1
                        OR ad.`portal_currencies_CurrencyName`    LIKE :col2
                        OR ad.`portal_currencies_CurrencyCode`    LIKE :col3
                        OR ad.`portal_currencies_created_at`    LIKE :col4
                        OR cont.`portal_countries_Country`    LIKE :col5)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_currencies_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_currencies_CurrencyName` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_currencies_CurrencyCode` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_currencies_created_at` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY cont.`portal_countries_Country` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_currencies_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_currencies_id` AS currid,
            ad.`portal_currencies_CurrencyName` AS currname,
            ad.`portal_currencies_CurrencyCode` AS currcode,
            cont.`portal_countries_Country` AS country,
            ad.`portal_currencies_created_at` AS currdate
        FROM `portal_currencies` AS ad
        LEFT JOIN `portal_countries` AS cont ON cont.`portal_countries_id` = ad.`portal_currencies_portal_countries_id`
        WHERE (ad.`portal_currencies_id` != NULL
        OR ad.`portal_currencies_id` IS NOT NULL)
        AND ad.`portal_currencies_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Currency Name" => ucfirst($result[$i]["currname"]),
                        "Currency Code" => $result[$i]["currcode"],
                        "Created At" => $result[$i]["currdate"],
                        "Country" => $result[$i]["country"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'CurrencyEdit/' . base64_encode($result[$i]["currid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteCurrency/' . base64_encode($result[$i]["currid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListModeOfPay() {
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
        $searchqr = ' AND (ad.`portal_mode_of_payment_id`       LIKE :col1
                        OR ad.`portal_mode_of_payment_mop`    LIKE :col2
                        OR ad.`portal_mode_of_payment_created_at`    LIKE :col3
                        OR ad.`portal_mode_of_payment_updated_at`    LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_payment_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_payment_mop` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_payment_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_payment_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_mode_of_payment_id` AS payid,
            ad.`portal_mode_of_payment_mop` AS paymode,
            ad.`portal_mode_of_payment_created_at` AS paydate,
            ad.`portal_mode_of_payment_updated_at` AS paydate1
        FROM `portal_mode_of_payment` AS ad
        WHERE (ad.`portal_mode_of_payment_id` != NULL
        OR ad.`portal_mode_of_payment_id` IS NOT NULL)
        AND ad.`portal_mode_of_payment_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Mode Of Payment" => ucfirst($result[$i]["paymode"]),
                        "Created At" => $result[$i]["paydate"],
                        "Updated At" => $result[$i]["paydate1"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'MOPEdit/' . base64_encode($result[$i]["payid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteMOP/' . base64_encode($result[$i]["payid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListModeOfServ() {
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
        $searchqr = ' AND (ad.`portal_mode_of_services_id`       LIKE :col1
                        OR ad.`portal_mode_of_services_mos`    LIKE :col2
                        OR ad.`portal_mode_of_services_created_at`    LIKE :col3
                        OR ad.`portal_mode_of_services_updated_at`    LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_services_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_services_mos` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_services_created_at` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_services_updated_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_mode_of_services_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_mode_of_services_id` AS serid,
            ad.`portal_mode_of_services_mos` AS sermode,
            ad.`portal_mode_of_services_created_at` AS serdate,
            ad.`portal_mode_of_services_updated_at` AS serdate1
        FROM `portal_mode_of_services` AS ad
        WHERE (ad.`portal_mode_of_services_id` != NULL
        OR ad.`portal_mode_of_services_id` IS NOT NULL)
        AND ad.`portal_mode_of_services_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Mode Of Service" => ucfirst($result[$i]["sermode"]),
                        "Created At" => $result[$i]["serdate"],
                        "Updated At" => $result[$i]["serdate1"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'MOSEdit/' . base64_encode($result[$i]["serid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteMOS/' . base64_encode($result[$i]["serid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListProtocols() {
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
        $searchqr = ' AND (ad.`portal_protocols_id`       LIKE :col1
                        OR ad.`portal_protocols_name`    LIKE :col2
                        OR ad.`portal_protocols_base_name`    LIKE :col3
                        OR ad.`portal_protocols_created_at`    LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_protocols_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_protocols_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_protocols_base_name` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_protocols_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_protocols_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_protocols_id` AS protid,
            ad.`portal_protocols_name` AS protnm,
            ad.`portal_protocols_base_name` AS protbnm,
            ad.`portal_protocols_created_at` AS protdate
        FROM `portal_protocols` AS ad
        WHERE (ad.`portal_protocols_id` != NULL
        OR ad.`portal_protocols_id` IS NOT NULL)
        AND ad.`portal_protocols_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "Protocol Name" => ucfirst($result[$i]["protnm"]),
                        "Base Name" => $result[$i]["protbnm"],
                        "Date" => $result[$i]["protdate"]
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
    public function ListRestParam() {
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
        $searchqr = ' AND (ad.`portal_rest_parameters_id`       LIKE :col1
                        OR ad.`portal_rest_parameters_field`    LIKE :col2
                        OR ad.`portal_rest_parameters_meaning`    LIKE :col3
                        OR ad.`portal_rest_parameters_description`    LIKE :col4
                        OR ad.`portal_rest_parameters_created_at`    LIKE :col5)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_field` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_meaning` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_description` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_rest_parameters_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_rest_parameters_id` AS protid,
            ad.`portal_rest_parameters_field` AS parafld,
            ad.`portal_rest_parameters_meaning` AS paramng,
            ad.`portal_rest_parameters_description` AS paradesc,
            ad.`portal_rest_parameters_created_at` AS paradate
        FROM `portal_rest_parameters` AS ad
        WHERE (ad.`portal_rest_parameters_id` != NULL
        OR ad.`portal_rest_parameters_id` IS NOT NULL)
        AND ad.`portal_rest_parameters_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Parameter Field" => ucfirst($result[$i]["parafld"]),
                        "Parameter Meaning" => $result[$i]["paramng"],
                        "Parameter Description" => $result[$i]["paradesc"],
                        "Date" => $result[$i]["paradate"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'RestParamEdit/' . base64_encode($result[$i]["protid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteRestParam/' . base64_encode($result[$i]["protid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListTraffic() {
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
        $searchqr = ' AND (ad.`portal_traffic_id`       LIKE :col1
                        OR ad.`portal_traffic_ip`    LIKE :col2
                        OR ad.`portal_traffic_host`    LIKE :col3
                        OR ad.`portal_traffic_organization`    LIKE :col4
                        OR ad.`portal_traffic_isp`    LIKE :col5
                        OR ad.`portal_traffic_hittime`    LIKE :col6
                        OR ad.`portal_traffic_city`    LIKE :col7
                        OR ad.`portal_traffic_country` LIKE :col8)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_traffic_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_traffic_ip` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_traffic_host` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`portal_traffic_organization` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`portal_traffic_isp` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`portal_traffic_hittime` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`portal_traffic_city` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`portal_traffic_country` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_traffic_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_traffic_id` AS trafid,
            ad.`portal_traffic_ip` AS trafip,
            ad.`portal_traffic_host` AS trafhost,
            ad.`portal_traffic_organization` AS traforg,
            ad.`portal_traffic_isp` AS trafisp,
            ad.`portal_traffic_hittime` AS trafhit,
            ad.`portal_traffic_city` AS trafcity,
            ad.`portal_traffic_country` AS trafcount
        FROM `portal_traffic` AS ad
        WHERE (ad.`portal_traffic_id` != NULL
        OR ad.`portal_traffic_id` IS NOT NULL)
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
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
                        "Traffic Ip" => ucfirst($result[$i]["trafip"]),
                        "Traffic Host" => $result[$i]["trafhost"],
                        "Organisation" => $result[$i]["traforg"],
                        "Traffic Isp" => $result[$i]["trafisp"],
                        "Traffic Hit Time" => $result[$i]["trafhit"],
                        "City" => $result[$i]["trafcity"],
                        "Country" => $result[$i]["trafcount"]
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
    public function ListUserProof() {
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
        $searchqr = ' AND (ad.`portal_proof_id`       LIKE :col1
                        OR ad.`portal_proof_name`    LIKE :col2
                        OR ad.`portal_proof_created_at` LIKE :col3
                        OR cont.`portal_countries_Country` LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`portal_proof_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`portal_proof_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`portal_proof_created_at` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY cont.`portal_countries_Country` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`portal_proof_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`portal_proof_id` AS proofid,
            ad.`portal_proof_name` AS prooftype,
            ad.`portal_proof_created_at` AS proofdate,
            cont.`portal_countries_Country` AS country
        FROM `portal_proof` AS ad
        LEFT JOIN `portal_countries` AS cont ON cont.`portal_countries_id` = ad.`portal_proof_portal_countries_id`
        WHERE (ad.`portal_proof_id` != NULL
        OR ad.`portal_proof_id` IS NOT NULL)
        AND ad.`portal_proof_status_id` = 4
        AND cont.`portal_countries_status_id` = 4
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "ID Proof Type" => ucfirst($result[$i]["prooftype"]),
                        "Date" => $result[$i]["proofdate"],
                        "Country" => $result[$i]["country"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'UserProofEdit/' . base64_encode($result[$i]["proofid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'DeleteUserProof/' . base64_encode($result[$i]["proofid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function ListUserTypes() {
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
        $usertypes = isset($this->postBaseData["who"]) && is_array($this->postBaseData["who"]) ? implode(",", $this->postBaseData["who"]) :
                "2,3,4,5,6,7,8,9,10,11";
        $searchqr = ' AND (ad.`users_type_id`       LIKE :col1
                        OR ad.`users_type_type`    LIKE :col2
                        OR ad.`users_type_minimum_balance`    LIKE :col3
                        OR ad.`users_type_created_at` LIKE :col4)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`users_type_id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`users_type_type` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`users_type_minimum_balance` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`users_type_created_at` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`users_proof_id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`users_type_id` AS typeid,
            ad.`users_type_type` AS type,
            ad.`users_type_minimum_balance` AS typemin,
            ad.`users_type_created_at` AS typedate
        FROM `users_type` AS ad
        WHERE (ad.`users_type_id` != NULL
        OR ad.`users_type_id` IS NOT NULL)
        AND ad.`users_type_status_id` = 4
        AND ad.`users_type_id` IN (' . $usertypes . ')
        ' . $searchqr . ' ' . $orderqr;
        $stm = $this->db->prepare($query);
        $keyword = "%" . mysql_real_escape_string($this->postBaseData["search"]["value"]) . "%";
        $stm->bindParam(':col1', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col2', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col3', $keyword, PDO::PARAM_STR);
        $stm->bindParam(':col4', $keyword, PDO::PARAM_STR);
        $res = $stm->execute();
        if ($res) {
            $num_posts = $stm->rowCount();
            $result = $stm->fetchAll();
            if ($num_posts) {
                $listusers = array();
                for ($i = 0; $i < count($result); $i++) {
                    array_push($data, array(
                        "#" => $i + 1,
                        "User Type" => ucfirst($result[$i]["type"]),
                        "Minimum Balance" => (integer) $result[$i]["typemin"],
                        "Date" => $result[$i]["typedate"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_21"] . 'UserTypesEdit/' . base64_encode($result[$i]["typeid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
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
    public function AddCountries() {
        $jsondata = array(
            "countname" => $this->postBaseData["countname"],
            "countcap" => $this->postBaseData["countcap"],
            "countiso" => $this->postBaseData["countiso"],
            "countis3" => $this->postBaseData["countis3"],
            "countisn" => $this->postBaseData["countisn"],
            "counttld" => $this->postBaseData["counttld"],
            "countfib" => $this->postBaseData["countfib"],
            "countphn" => $this->postBaseData["countphn"],
            "countcurnm" => $this->postBaseData["countcurnm"],
            "countcurcd" => $this->postBaseData["countcurcd"],
            "continent" => $this->postBaseData["continent"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_countries` WHERE `portal_countries_Country`= :name');
        $res = $stm->execute(array(
            ":name" => mysql_real_escape_string($jsondata["countname"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_countries` WHERE `portal_countries_Country`= :name AND `portal_countries_status_id`=:stat');
            $res = $stm->execute(array(
                ":name" => mysql_real_escape_string($jsondata["countname"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_countries` SET `portal_countries_status_id`=:stat,
                    `portal_countries_updated_at` = :id1 WHERE `portal_countries_Country`= :name');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":name" => mysql_real_escape_string($jsondata["countname"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query4 = 'INSERT INTO  `portal_countries` (
                        `portal_countries_id`,
                        `portal_countries_Country`,
                        `portal_countries_Capital`,
                        `portal_countries_ISO`,
                        `portal_countries_ISO3`,
                        `portal_countries_ISO-Numeric`,
                        `portal_countries_tld`,
                        `portal_countries_fips`,
                        `portal_countries_Phone`,
                        `portal_countries_CurrencyName`,
                        `portal_countries_CurrencyCode`,
                        `portal_countries_portal_continents_id`
                    )  VALUES(
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
                        :id12
                    );';
            $stm = $this->db->prepare($query4);
            $res4 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => mysql_real_escape_string($jsondata["countname"]),
                ":id3" => mysql_real_escape_string($jsondata["countcap"]),
                ":id4" => mysql_real_escape_string($jsondata["countiso"]),
                ":id5" => mysql_real_escape_string($jsondata["countis3"]),
                ":id6" => mysql_real_escape_string($jsondata["countisn"]),
                ":id7" => mysql_real_escape_string($jsondata["counttld"]),
                ":id8" => mysql_real_escape_string($jsondata["countfib"]),
                ":id9" => mysql_real_escape_string($jsondata["countphn"]),
                ":id10" => mysql_real_escape_string($jsondata["countcurnm"]),
                ":id11" => mysql_real_escape_string($jsondata["countcurcd"]),
                ":id12" => mysql_real_escape_string($jsondata["continent"]),
            ));
            $bnk_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddCurrencies() {
        $jsondata = array(
            "country" => $this->postBaseData["country"],
            "curname" => $this->postBaseData["currname"],
            "curcode" => $this->postBaseData["currcode"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_currencies` WHERE `portal_currencies_portal_countries_id`= :country AND `portal_currencies_CurrencyName`=:curname');
        $res1 = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":curname" => mysql_real_escape_string($jsondata["curname"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_currencies` WHERE `portal_currencies_portal_countries_id`= :country AND `portal_currencies_CurrencyName`=:curname AND `portal_currencies_status_id`=:stat');
            $res = $stm->execute(array(
                ":country" => mysql_real_escape_string($jsondata["country"]),
                ":curname" => mysql_real_escape_string($jsondata["curname"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_currencies` SET `portal_currencies_status_id`=:stat,
                    `portal_currencies_updated_at` = :id1 WHERE `portal_currencies_portal_countries_id`= :country AND `portal_currencies_CurrencyName`=:curname');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":country" => mysql_real_escape_string($jsondata["country"]),
                    ":curname" => mysql_real_escape_string($jsondata["curname"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query4 = 'INSERT INTO  `portal_currencies` (
                        `portal_currencies_portal_countries_id`,
                        `portal_currencies_CurrencyCode`,
                        `portal_currencies_CurrencyName`,
                        `portal_currencies_status_id`
                    )  VALUES(
                        :id2,
                        :id3,
                        :id4,
                        :id5)';
            $stm = $this->db->prepare($query4);
            $res4 = $stm->execute(array(
                ":id2" => mysql_real_escape_string($jsondata["country"]),
                ":id3" => mysql_real_escape_string($jsondata["curcode"]),
                ":id4" => mysql_real_escape_string($jsondata["curname"]),
                ":id5" => mysql_real_escape_string($jsondata["stat"])
            ));
            if ($res4) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddBusinessType() {
        $jsondata = array(
            "country" => $this->postBaseData["country"],
            "btype" => $this->postBaseData["btype"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_business_type` WHERE `portal_business_type_portal_countries_id`= :country AND `portal_business_type_name`=:bustype');
        $res1 = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":bustype" => mysql_real_escape_string($jsondata["btype"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_business_type` WHERE `portal_business_type_portal_countries_id`= :country AND `portal_business_type_name`=:bustype AND `portal_business_type_status_id`=:stat');
            $res = $stm->execute(array(
                ":country" => mysql_real_escape_string($jsondata["country"]),
                ":bustype" => mysql_real_escape_string($jsondata["btype"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_business_type` SET `portal_business_type_status_id`=:stat,
                    `portal_business_type_updated_at` = :id1 WHERE `portal_business_type_portal_countries_id`= :country AND `portal_business_type_name`=:bustype');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":country" => mysql_real_escape_string($jsondata["country"]),
                    ":bustype" => mysql_real_escape_string($jsondata["btype"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query4 = 'INSERT INTO  `portal_business_type` (
                        `portal_business_type_portal_countries_id`,
                        `portal_business_type_name`,
                        `portal_business_type_status_id`
                    )  VALUES(
                        :id2,
                        :id3,
                        :id4)';
            $stm = $this->db->prepare($query4);
            $res4 = $stm->execute(array(
                ":id2" => mysql_real_escape_string($jsondata["country"]),
                ":id3" => mysql_real_escape_string($jsondata["btype"]),
                ":id4" => mysql_real_escape_string($jsondata["stat"])
            ));
            if ($res4) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddMOP() {
        $jsondata = array(
            "mop" => $this->postBaseData["mop"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_mode_of_payment` WHERE `portal_mode_of_payment_mop`= :mop');
        $res1 = $stm1->execute(array(
            ":mop" => mysql_real_escape_string($jsondata["mop"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_mode_of_payment` WHERE `portal_mode_of_payment_mop`= :mop AND `portal_mode_of_payment_status_id`=:stat');
            $res = $stm->execute(array(
                ":mop" => mysql_real_escape_string($jsondata["mop"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_mode_of_payment` SET `portal_mode_of_payment_status_id`=:stat,
                    `portal_mode_of_payment_updated_at` = :id1  WHERE `portal_mode_of_payment_mop`= :mop');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":mop" => mysql_real_escape_string($jsondata["mop"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `portal_mode_of_payment` (
                        `portal_mode_of_payment_id`,
                        `portal_mode_of_payment_mop`
                    )  VALUES(
                        :id1,
                        :id2)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["mop"])
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
    public function AddMOS() {
        $jsondata = array(
            "mos" => $this->postBaseData["mos"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_mode_of_services` WHERE `portal_mode_of_services_mos`= :mos');
        $res1 = $stm1->execute(array(
            ":mos" => mysql_real_escape_string($jsondata["mos"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_mode_of_services` WHERE `portal_mode_of_services_mos`= :mos AND `portal_mode_of_services_status_id`=:stat');
            $res = $stm->execute(array(
                ":mos" => mysql_real_escape_string($jsondata["mos"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_mode_of_services` SET `portal_mode_of_services_status_id`=:stat,
                    `portal_mode_of_services_updated_at` = :id1 WHERE `portal_mode_of_services_mos`= :mos');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":mos" => mysql_real_escape_string($jsondata["mos"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `portal_mode_of_services` (
                        `portal_mode_of_services_id`,
                        `portal_mode_of_services_mos`
                    )  VALUES(
                        :id1,
                        :id2)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["mos"])
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
    public function AddProtocols() {
        $jsondata = array(
            "proto" => $this->postBaseData["Proto"],
            "base" => $this->postBaseData["base"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_protocols` WHERE `portal_protocols_name`= :Proto');
        $res = $stm1->execute(array(
            ":Proto" => mysql_real_escape_string($jsondata["Proto"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `portal_mode_of_services` (
                        `portal_mode_of_services_id`,
                        `portal_mode_of_services_mos`
                    )  VALUES(
                        :id1,
                        :id2)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["Proto"]),
                ":id3" => mysql_real_escape_string($jsondata["base"])
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
    public function AddRestParameters() {
        $jsondata = array(
            "Param" => $this->postBaseData["Param"],
            "meang" => $this->postBaseData["meang"],
            "desc" => $this->postBaseData["desc"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_rest_parameters` WHERE `portal_rest_parameters_field`= :Param');
        $res1 = $stm1->execute(array(
            ":Param" => mysql_real_escape_string($jsondata["Param"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_rest_parameters` WHERE `portal_rest_parameters_field`= :Param AND `portal_rest_parameters_status_id`=:stat');
            $res = $stm->execute(array(
                ":Param" => mysql_real_escape_string($jsondata["Param"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_rest_parameters` SET `portal_rest_parameters_status_id`=:stat,
                    `portal_rest_parameters_updated_at` = :id1 WHERE `portal_rest_parameters_field`= :Param');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":Param" => mysql_real_escape_string($jsondata["Param"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `portal_rest_parameters` (
                        `portal_rest_parameters_id`,
                        `portal_rest_parameters_field`,
                        `portal_rest_parameters_meaning`,
                        `portal_rest_parameters_description`
                    )  VALUES(
                        :id1,
                        :id2,
                        :id3,
                        :id4)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["Param"]),
                ":id3" => mysql_real_escape_string($jsondata["meang"]),
                ":id4" => mysql_real_escape_string($jsondata["desc"])
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
    public function AddProof() {
        $jsondata = array(
            "country" => $this->postBaseData["country"],
            "proof" => $this->postBaseData["proof"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_proof` WHERE `portal_proof_portal_countries_id`= :country AND `portal_proof_name`=:proof');
        $res1 = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":proof" => mysql_real_escape_string($jsondata["proof"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $stm = $this->db->prepare('SELECT * FROM `portal_proof` WHERE `portal_proof_portal_countries_id`= :country AND `portal_proof_name`=:proof AND `portal_proof_status_id`=:stat');
            $res = $stm->execute(array(
                ":country" => mysql_real_escape_string($jsondata["country"]),
                ":proof" => mysql_real_escape_string($jsondata["proof"]),
                ":stat" => 6
            ));
            $c = $stm->rowCount();
            if ($c > 0) {
                $stm2 = $this->db->prepare('UPDATE `portal_proof` SET `portal_proof_status_id`=:stat,
                    `portal_proof_updated_at` = :id1 WHERE `portal_proof_portal_countries_id`= :country AND `portal_proof_name`=:proof');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":country" => mysql_real_escape_string($jsondata["country"]),
                    ":proof" => mysql_real_escape_string($jsondata["proof"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `portal_proof` (
                        `portal_proof_portal_countries_id`,
                        `portal_proof_name`
                    )  VALUES(
                        :id1,
                        :id2)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["country"]),
                ":id2" => mysql_real_escape_string($jsondata["proof"])
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
    public function AddUserType() {
        $jsondata = array(
            "userType" => $this->postBaseData["userType"],
            "minBalance" => $this->postBaseData["minBalance"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `users_type` WHERE `users_type_type`= :userType');
        $res = $stm1->execute(array(
            ":userType" => mysql_real_escape_string($jsondata["userType"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO  `users_type` (
                        `users_type_type`,
                        `users_type_minimum_balance`
                    )  VALUES(
                        :id1,
                        :id2)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["userType"]),
                ":id2" => mysql_real_escape_string($jsondata["minBalance"])
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
    public function AddBusinessInfo() {
        $jsondata = array(
            "btype" => $this->postBaseData["btype"],
            "cname" => $this->postBaseData["cname"],
            "doc" => $this->postBaseData["doc"],
            "website" => $this->postBaseData["website"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `company` WHERE `company_name`= :company');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["cname"])
        ));
        $res1 = $stm1->execute();
        if ($res1) {
            $st = $stm1->fetchAll();
            $data["data"] = $st;
        }
        $count = $stm1->rowCount();
        $st = $st[0]["company_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `company` SET `company_status_id`=:stat,
                    `company_updated_at` = :id1 WHERE `company_name`= :company');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":company" => mysql_real_escape_string($jsondata["cname"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO `company`(`company_id`,
                                 `company_name`,
                                 `company_doc`,
                                 `company_website`,
                                 `company_addressline`,
                                 `company_country`,
                                 `company_province`,
                                 `company_district`,
                                 `company_city`,
                                 `company_town`,
                                 `company_zipcode`,
                                 `company_business_type_id`)
                Values(:id1,:id2,:id3,:id4,:id5,:id6,:id7,:id8,:id9,:id10,:id11,:id12)';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["cname"]),
                ":id3" => mysql_real_escape_string($jsondata["doc"]),
                ":id4" => mysql_real_escape_string($jsondata["website"]),
                ":id5" => mysql_real_escape_string($jsondata["addline"]),
                ":id6" => mysql_real_escape_string($jsondata["country"]),
                ":id7" => mysql_real_escape_string($jsondata["state"]),
                ":id8" => mysql_real_escape_string($jsondata["distct"]),
                ":id9" => mysql_real_escape_string($jsondata["city"]),
                ":id10" => mysql_real_escape_string($jsondata["stloc"]),
                ":id11" => mysql_real_escape_string($jsondata["zipc"]),
                ":id12" => mysql_real_escape_string($jsondata["btype"]),
            ));
            $company_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddBankDetails() {
        $jsondata = array(
            "cmpname" => $this->postBaseData["cmpname"],
            "acname" => $this->postBaseData["acname"],
            "acno" => $this->postBaseData["acno"],
            "acifsc" => $this->postBaseData["acifsc"],
            "bnkame" => $this->postBaseData["bnkame"],
            "bnkcode" => $this->postBaseData["bnkcode"],
            "bbrname" => $this->postBaseData["bbrname"],
            "bbrcode" => $this->postBaseData["bbrcode"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `company_bank_accounts` WHERE `company_bank_accounts_company_id`= :company AND `company_bank_accounts_ac_no`=:account');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["cmpname"]),
            ":account" => mysql_real_escape_string($jsondata["acno"])
        ));
        $res1 = $stm1->execute();
        if ($res1) {
            $st = $stm1->fetchAll();
            $data["data"] = $st;
        }
        $count = $stm1->rowCount();
        $st = $st[0]["company_bank_accounts_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `company_bank_accounts` SET `company_bank_accounts_status_id`=:stat,
                    `company_bank_accounts_updated_at` = :id1 WHERE `company_bank_accounts_company_id`= :company');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":company" => mysql_real_escape_string($jsondata["cmpname"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query4 = 'INSERT INTO  `company_bank_accounts` (
                        `company_bank_accounts_id`,
                        `company_bank_accounts_ac_name`,
                        `company_bank_accounts_ac_no`,
                        `company_bank_accounts_IFSC`,
                        `company_bank_accounts_name`,
                        `company_bank_accounts_code`,
                        `company_bank_accounts_branch`,
                        `company_bank_accounts_branch_code`,
                        `company_bank_accounts_company_id`
                    )  VALUES(
                        :id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8,
                        :id9
                    );';
            $stm = $this->db->prepare($query4);
            $res = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["acname"]),
                ":id3" => mysql_real_escape_string($jsondata["acno"]),
                ":id4" => mysql_real_escape_string($jsondata["acifsc"]),
                ":id5" => mysql_real_escape_string($jsondata["bnkame"]),
                ":id6" => mysql_real_escape_string($jsondata["bnkcode"]),
                ":id7" => mysql_real_escape_string($jsondata["bbrname"]),
                ":id8" => mysql_real_escape_string($jsondata["bbrcode"]),
                ":id9" => mysql_real_escape_string($jsondata["cmpname"]),
            ));
            $bnk_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddService() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "code" => $this->postBaseData["code"],
            "company" => $this->postBaseData["company"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `services`,`services_company` WHERE `services_company_company_id`= :company AND `services_name`=:service');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["company"]),
            ":service" => mysql_real_escape_string($jsondata["name"])
        ));
        $res1 = $stm1->execute();
        if ($res1) {
            $st = $stm1->fetchAll();
            $data["data"] = $st;
        }
        $id = $st[0]["services_id"];
        $count = $stm1->rowCount();
        $st = $st[0]["services_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `services` SET `services_status_id`=:stat,
                    `services_updated_at` = :id1 WHERE `services_id`= :id');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":id" => mysql_real_escape_string($id)
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            /* Users */
            $query = 'INSERT INTO `services`(`services_name`,`services_lt_code`)Values(:id1,:id2)';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["name"]),
                ":id2" => mysql_real_escape_string($jsondata["code"])
            ));
            $serv = $this->db->lastInsertId();
            $query1 = 'INSERT INTO  `services_company` (
                    `services_company_services_id`,
                    `services_company_company_id`)  VALUES(
                      :id1,
                      :id2);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id1" => mysql_real_escape_string($serv),
                ":id2" => mysql_real_escape_string($jsondata["company"])
            ));
            $serv_id = $this->db->lastInsertId();
            if ($res && $res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function AddOperatorDB() {
        $jsondata = array(
            "service" => $this->postBaseData["serv"],
            "name" => $this->postBaseData["name"],
            "ocode" => $this->postBaseData["ocde"],
            "alias" => $this->postBaseData["alas"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `operators` WHERE `operator_name`= :operator');
        $res1 = $stm1->execute(array(
            ":operator" => mysql_real_escape_string($jsondata["name"])
        ));
        $res1 = $stm1->execute();
        if ($res1) {
            $st = $stm1->fetchAll();
            $data["data"] = $st;
        }
        $count = $stm1->rowCount();
        $st = $st[0]["operator_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `operators` SET `operator_status_id`=:stat,
                    `operator_updated_at` = :id1 WHERE `operator_name`= :operator');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":operator" => mysql_real_escape_string($jsondata["name"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO `operators`(
                        `operator_services_id`,
                        `operator_name`,
                        `operator_lt_code`,
                        `operator_alias`,
                        `operator_commission_fixed`,
                        `operator_commission_variable`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["service"]),
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($jsondata["ocode"]),
                ":id4" => mysql_real_escape_string($jsondata["alias"]),
                ":id5" => mysql_real_escape_string($jsondata["flat"]),
                ":id6" => mysql_real_escape_string($jsondata["variable"]),
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
        $stm1 = $this->db->prepare('SELECT * FROM `operators_type` WHERE `operator_type_operator_id`= :operator AND `operator_type_type`=:type');
        $res1 = $stm1->execute(array(
            ":operator" => mysql_real_escape_string($jsondata["operator"]),
            ":type" => mysql_real_escape_string($jsondata["optype"])
        ));
        $res1 = $stm1->execute();
        if ($res1) {
            $st = $stm1->fetchAll();
            $data["data"] = $st;
        }
        $count = $stm1->rowCount();
        $st = $st[0]["operator_type_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `operators_type` SET `operator_type_status_id`=:stat,
                    `operator_type_updated_at` = :id1  WHERE `operator_type_operator_id`= :operator AND `operator_type_type`=:type');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":operator" => mysql_real_escape_string($jsondata["operator"]),
                    ":type" => mysql_real_escape_string($jsondata["optype"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query = 'INSERT INTO `operators_type`(
                        `operator_type_operator_id`,
                        `operator_type_type`,
                        `operator_type_lt_code`,
                        `operator_type_commission_fixed`,
                        `operator_type_commission_variable`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5)';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["operator"]),
                ":id2" => mysql_real_escape_string($jsondata["optype"]),
                ":id3" => mysql_real_escape_string($jsondata["optypecode"]),
                ":id4" => mysql_real_escape_string($jsondata["flat"]),
                ":id5" => mysql_real_escape_string($jsondata["variable"])
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
    public function setCurrency() {
        $jsondata = array(
            "company" => $this->postBaseData["company"],
            "currency" => $this->postBaseData["currency"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company_currency` WHERE `company_currency_company_id`= :company AND `company_currency_portal_currencies_id`=:currency');
        $res = $stm->execute(array(
            ":company" => mysql_real_escape_string($jsondata["company"]),
            ":currency" => mysql_real_escape_string($jsondata["currency"])
        ));
        $res = $stm->execute();
        if ($res) {
            $st = $stm->fetchAll();
            $data["data"] = $st;
        }
        $count = $stm->rowCount();
        $st = $st[0]["company_currency_status_id"];
        if ($count > 0) {
            if ($st == 6) {
                $stm2 = $this->db->prepare('UPDATE `company_currency` SET `company_currency_status_id`=:stat,
                    `company_currency_updated_at` = :id1 WHERE `company_currency_company_id`= :company AND `company_currency_portal_currencies_id`=:currency');
                $res2 = $stm2->execute(array(
                    ":stat" => mysql_real_escape_string($jsondata["stat"]),
                    ":id1" => date("Y-m-d H:i:s"),
                    ":company" => mysql_real_escape_string($jsondata["company"]),
                    ":currency" => mysql_real_escape_string($jsondata["currency"])
                ));
                $jsondata["status"] = "success";
            } else {
                $jsondata["status"] = "alreadyexist";
            }
        } else {
            $this->db->beginTransaction();
            $query4 = 'INSERT INTO  `company_currency` (
                        `company_currency_id`,
                        `company_currency_company_id`,
                        `company_currency_portal_currencies_id`,
                        `company_currency_status_id`
                    )  VALUES(
                        :id1,
                        :id2,
                        :id3,
                        :id4
                    );';
            $stm = $this->db->prepare($query4);
            $res = $stm->execute(array(
                ":id1" => Null,
                ":id2" => mysql_real_escape_string($jsondata["company"]),
                ":id3" => mysql_real_escape_string($jsondata["currency"]),
                ":id4" => mysql_real_escape_string($jsondata["stat"]),
            ));
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditBusinessDetails() {
        $jsondata = array(
            "company_id" => base64_decode($this->postBaseData["company_id"]),
            "btype" => $this->postBaseData["btype"],
            "cname" => $this->postBaseData["cname"],
            "doc" => $this->postBaseData["doc"],
            "website" => $this->postBaseData["website"],
            "addline" => $this->postBaseData["addline"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "distct" => $this->postBaseData["distct"],
            "city" => $this->postBaseData["city"],
            "stloc" => $this->postBaseData["stloc"],
            "zipc" => $this->postBaseData["zipc"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `company` WHERE `company_name`= :company AND `company_id`!=:id');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["cname"]),
            ":id" => mysql_real_escape_string($jsondata["company_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            /* User business details */
            $query = 'UPDATE `company` SET
                         `company_business_type_id` = :id1,
                         `company_name` = :id2,
                         `company_doc`= :id3,
                         `company_website` = :id4,
                         `company_addressline` = :id5,
                         `company_country`= :id6,
                         `company_province` = :id7,
                         `company_district` = :id8,
                         `company_city` = :id9,
                         `company_street_loc` = :id10,
                         `company_zipcode`= :id11,
                         `company_updated_at` = :id12
                          WHERE `company_id`= :id
                          AND `company_status_id` = :stat';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["company_id"]),
                ":id1" => mysql_real_escape_string($jsondata["btype"]),
                ":id2" => mysql_real_escape_string($jsondata["cname"]),
                ":id3" => mysql_real_escape_string($jsondata["doc"]),
                ":id4" => mysql_real_escape_string($jsondata["website"]),
                ":id5" => mysql_real_escape_string($jsondata["addline"]),
                ":id6" => mysql_real_escape_string($jsondata["country"]),
                ":id7" => mysql_real_escape_string($jsondata["state"]),
                ":id8" => mysql_real_escape_string($jsondata["distct"]),
                ":id9" => mysql_real_escape_string($jsondata["city"]),
                ":id10" => mysql_real_escape_string($jsondata["stloc"]),
                ":id11" => mysql_real_escape_string($jsondata["zipc"]),
                ":id12" => date("Y-m-d H:i:s"),
                ":stat" => mysql_real_escape_string($jsondata["stat"])
            ));
//        $business_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditBankDetails() {
        $jsondata = array(
            "id" => base64_decode($this->postBaseData["company_bank_accounts_id"]),
            "cmpname" => $this->postBaseData["cmpname"],
            "acname" => $this->postBaseData["acname"],
            "acno" => $this->postBaseData["acno"],
            "acifsc" => $this->postBaseData["acifsc"],
            "bnkame" => $this->postBaseData["bnkame"],
            "bnkcode" => $this->postBaseData["bnkcode"],
            "bbrname" => $this->postBaseData["bbrname"],
            "bbrcode" => $this->postBaseData["bbrcode"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `company_bank_accounts` WHERE `company_bank_accounts_company_id`= :company AND `company_bank_accounts_ac_no`!=:account AND `company_bank_accounts_id`=:id');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["cmpname"]),
            ":account" => mysql_real_escape_string($jsondata["acno"]),
            ":id" => mysql_real_escape_string($jsondata["id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `company_bank_accounts` SET
                         `company_bank_accounts_name` = :id2,
                         `company_bank_accounts_code` = :id3,
                         `company_bank_accounts_ac_name`= :id4,
                         `company_bank_accounts_ac_no` = :id5,
                         `company_bank_accounts_IFSC` = :id6,
                         `company_bank_accounts_branch`= :id7,
                         `company_bank_accounts_branch_code` = :id8,
                         `company_bank_accounts_company_id` = :id9,
                         `company_bank_accounts_updated_at` = :id10
                          WHERE `company_bank_accounts_id`= :id
                          AND `company_bank_accounts_status_id` = :stat';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["id"]),
                ":id2" => mysql_real_escape_string($jsondata["bnkame"]),
                ":id3" => mysql_real_escape_string($jsondata["bnkcode"]),
                ":id4" => mysql_real_escape_string($jsondata["acname"]),
                ":id5" => mysql_real_escape_string($jsondata["acno"]),
                ":id6" => mysql_real_escape_string($jsondata["acifsc"]),
                ":id7" => mysql_real_escape_string($jsondata["bbrname"]),
                ":id8" => mysql_real_escape_string($jsondata["bbrcode"]),
                ":id9" => mysql_real_escape_string($jsondata["cmpname"]),
                ":id10" => date("Y-m-d H:i:s"),
                ":stat" => mysql_real_escape_string($jsondata["stat"])
            ));
//        $bnk_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditSetCurrency() {
        $jsondata = array(
            "currency_id" => base64_decode($this->postBaseData["company_currency_id"]),
            "company" => $this->postBaseData["company"],
            "currency" => $this->postBaseData["currency"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company_currency` WHERE `company_currency_company_id`= :company AND `company_currency_portal_currencies_id`=:currency AND `company_currency_id`!=:id');
        $res = $stm->execute(array(
            ":company" => mysql_real_escape_string($jsondata["company"]),
            ":currency" => mysql_real_escape_string($jsondata["currency"]),
            ":id" => mysql_real_escape_string($jsondata["currency_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `company_currency` SET
                         `company_currency_company_id` = :id2,
                         `company_currency_portal_currencies_id` = :id3,
                         `company_currency_status_id`= :id4,
                         `company_currency_updated_at` = :id5
                          WHERE `company_currency_id`= :id';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id2" => mysql_real_escape_string($jsondata["company"]),
                ":id3" => mysql_real_escape_string($jsondata["currency"]),
                ":id4" => mysql_real_escape_string($jsondata["stat"]),
                ":id5" => date("Y-m-d H:i:s"),
                ":id" => mysql_real_escape_string($jsondata["currency_id"])
            ));
//        $bnk_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditService() {
        $jsondata = array(
            "services_id" => base64_decode($this->postBaseData["services_id"]),
            "name" => $this->postBaseData["name"],
            "code" => $this->postBaseData["code"],
            "company" => $this->postBaseData["company"],
            "flatcommission" => $this->postBaseData["flatcommission"],
            "variablecommission" => $this->postBaseData["variablecommission"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `services`,`services_company` WHERE `services_company_company_id`= :company AND `services_name`=:service AND `services_id`!=:id');
        $res1 = $stm1->execute(array(
            ":company" => mysql_real_escape_string($jsondata["company"]),
            ":service" => mysql_real_escape_string($jsondata["name"]),
            ":id1" => mysql_real_escape_string($jsondata["services_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            /* Users */
            $query = 'UPDATE `services` SET
                         `services_name` = :id2,
                         `services_lt_code` = :id3,
                         `services_updated_at` = :id4,
                         `services_commission_fixed` =:id5,
                         `services_commission_variable` =:id6
                          WHERE `services_id`=:id1';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["services_id"]),
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($jsondata["code"]),
                ":id4" => date("Y-m-d H:i:s"),
                ":id5" => mysql_real_escape_string($jsondata["flatcommission"]),
                ":id6" => mysql_real_escape_string($jsondata["variablecommission"]),
            ));
//        $serv = $this->db->lastInsertId();
            $query1 = 'UPDATE `services_company` SET
                         `services_company_company_id` = :id2,
                         `services_company_updated_at` = :id3
                          WHERE `services_company_services_id`=:id1';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["services_id"]),
                ":id2" => mysql_real_escape_string($jsondata["company"]),
                ":id3" => date("Y-m-d H:i:s"),
            ));
            $serv_id = $this->db->lastInsertId();
            if ($res && $res1) {
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
            "service" => $this->postBaseData["serv"],
            "name" => $this->postBaseData["name"],
            "ocode" => $this->postBaseData["ocde"],
            "alias" => $this->postBaseData["alas"],
            "flat" => $this->postBaseData["flat"],
            "variable" => $this->postBaseData["variable"],
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `operators` WHERE `operator_name`= :operator AND `operator_id`!=:id');
        $res1 = $stm1->execute(array(
            ":operator" => mysql_real_escape_string($jsondata["name"]),
            ":id" => mysql_real_escape_string($jsondata["operator_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `operators` SET
                         `operator_services_id` = :id1,
                         `operator_name` = :id2,
                         `operator_lt_code`= :id3,
                         `operator_alias` = :id4,
                         `operator_commission_fixed` = :id5,
                         `operator_commission_variable` = :id6,
                         `operator_updated_at`= :id7
                          WHERE `operator_id`= :id
                          AND `operator_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["operator_id"]),
                ":id1" => mysql_real_escape_string($jsondata["service"]),
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($jsondata["ocode"]),
                ":id4" => mysql_real_escape_string($jsondata["alias"]),
                ":id5" => mysql_real_escape_string($jsondata["flat"]),
                ":id6" => mysql_real_escape_string($jsondata["variable"]),
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
        $stm1 = $this->db->prepare('SELECT * FROM `operators_type` WHERE `operator_type_operator_id`= :operator AND `operator_type_type`=:type AND `operator_type_id`!=id');
        $res1 = $stm1->execute(array(
            ":operator" => mysql_real_escape_string($jsondata["operator"]),
            ":type" => mysql_real_escape_string($jsondata["optype"]),
            ":id" => mysql_real_escape_string($jsondata["operator_type_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `operators_type` SET
                         `operator_type_operator_id` = :id1,
                         `operator_type_type` = :id2,
                         `operator_type_lt_code`= :id3,
                         `operator_type_commission_fixed` = :id4,
                         `operator_type_commission_variable` = :id5,
                         `operator_type_updated_at`= :id6
                          WHERE `operator_type_id`= :id
                          AND `operator_type_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["operator_type_id"]),
                ":id1" => mysql_real_escape_string($jsondata["operator"]),
                ":id2" => mysql_real_escape_string($jsondata["optype"]),
                ":id3" => mysql_real_escape_string($jsondata["optypecode"]),
                ":id4" => mysql_real_escape_string($jsondata["flat"]),
                ":id5" => mysql_real_escape_string($jsondata["variable"]),
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
    public function EditBusinessTypeDetails() {
        $jsondata = array(
            "business_type_id" => base64_decode($this->postBaseData["business_type_id"]),
            "country" => $this->postBaseData["country"],
            "btype" => $this->postBaseData["btype"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_business_type` WHERE `portal_business_type_portal_countries_id`= :country AND `portal_business_type_name`=:bustype AND `portal_business_type_id`!=:id');
        $res = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":bustype" => mysql_real_escape_string($jsondata["btype"]),
            ":id" => mysql_real_escape_string($jsondata["business_type_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_business_type` SET
                         `portal_business_type_portal_countries_id` =:id1,
                         `portal_business_type_name` = :id2,
                         `portal_business_type_status_id` = :id3,
                         `portal_business_type_updated_at`= :id4
                          WHERE `portal_business_type_id`=:id';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["business_type_id"]),
                ":id1" => mysql_real_escape_string($jsondata["country"]),
                ":id2" => mysql_real_escape_string($jsondata["btype"]),
                ":id3" => mysql_real_escape_string($jsondata["stat"]),
                ":id4" => date("Y-m-d H:i:s"),
            ));
//        $business_type_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditCountryDetails() {
        $jsondata = array(
            "portal_countries_id" => base64_decode($this->postBaseData["portal_countries_id"]),
            "continent" => $this->postBaseData["continent"],
            "countname" => $this->postBaseData["countname"],
            "countcap" => $this->postBaseData["countcap"],
            "countiso" => $this->postBaseData["countiso"],
            "countis3" => $this->postBaseData["countis3"],
            "countisn" => $this->postBaseData["countisn"],
            "counttld" => $this->postBaseData["counttld"],
            "countfib" => $this->postBaseData["countfib"],
            "countphn" => $this->postBaseData["countphn"],
            "countcurnm" => $this->postBaseData["countcurnm"],
            "countcurcd" => $this->postBaseData["countcurcd"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `portal_countries_Country` FROM `portal_countries` WHERE `portal_countries_Country`= :name AND `portal_countries_id`!=:id');
        $res = $stm->execute(array(
            ":name" => mysql_real_escape_string($jsondata["countname"]),
            ":id" => mysql_real_escape_string($jsondata["portal_countries_id"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_countries` SET
                         `portal_countries_portal_continents_id` = :id1,
                         `portal_countries_Country` = :id2,
                         `portal_countries_Capital`= :id3,
                         `portal_countries_ISO` = :id4,
                         `portal_countries_ISO3` = :id5,
                         `portal_countries_ISO-Numeric`= :id6,
                         `portal_countries_tld` = :id7,
                         `portal_countries_fips` = :id8,
                         `portal_countries_Phone` = :id9,
                         `portal_countries_CurrencyName` = :id10,
                         `portal_countries_CurrencyCode`= :id11,
                         `portal_countries_updated_at`= :id12
                          WHERE `portal_countries_id`= :id
                          AND `portal_countries_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["portal_countries_id"]),
                ":id1" => mysql_real_escape_string($jsondata["continent"]),
                ":id2" => mysql_real_escape_string($jsondata["countname"]),
                ":id3" => mysql_real_escape_string($jsondata["countcap"]),
                ":id4" => mysql_real_escape_string($jsondata["countiso"]),
                ":id5" => mysql_real_escape_string($jsondata["countis3"]),
                ":id6" => mysql_real_escape_string($jsondata["countisn"]),
                ":id7" => mysql_real_escape_string($jsondata["counttld"]),
                ":id8" => mysql_real_escape_string($jsondata["countfib"]),
                ":id9" => mysql_real_escape_string($jsondata["countphn"]),
                ":id10" => mysql_real_escape_string($jsondata["countcurnm"]),
                ":id11" => mysql_real_escape_string($jsondata["countcurcd"]),
                ":id12" => date("Y-m-d H:i:s")
            ));
//        $currency_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditCurrencyDetails() {
        $jsondata = array(
            "curr_id" => base64_decode($this->postBaseData["curr_id"]),
            "country" => $this->postBaseData["country"],
            "currname" => $this->postBaseData["currname"],
            "currcode" => $this->postBaseData["currcode"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_currencies` WHERE `portal_currencies_portal_countries_id`= :country AND `portal_currencies_CurrencyName`=:curname AND `portal_currencies_id`!=:id');
        $res = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":curname" => mysql_real_escape_string($jsondata["currname"]),
            ":id" => mysql_real_escape_string($jsondata["curr_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_currencies` SET
                         `portal_currencies_portal_countries_id` = :id1,
                         `portal_currencies_CurrencyName` = :id2,
                         `portal_currencies_CurrencyCode`= :id3,
                         `portal_currencies_updated_at` = :id4
                          WHERE `portal_currencies_id`= :id
                          AND `portal_currencies_status_id` = 4';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["curr_id"]),
                ":id1" => mysql_real_escape_string($jsondata["country"]),
                ":id2" => mysql_real_escape_string($jsondata["currname"]),
                ":id3" => mysql_real_escape_string($jsondata["currcode"]),
                ":id4" => date("Y-m-d H:i:s"),
            ));
//        $currency_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditProof() {
        $jsondata = array(
            "proof_id" => base64_decode($this->postBaseData["proof_id"]),
            "country" => $this->postBaseData["country"],
            "proof" => $this->postBaseData["proof"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_proof` WHERE `portal_proof_portal_countries_id`= :country AND `portal_proof_name`=:proof AND `portal_proof_id`!=:id');
        $res = $stm1->execute(array(
            ":country" => mysql_real_escape_string($jsondata["country"]),
            ":proof" => mysql_real_escape_string($jsondata["proof"]),
            ":id" => mysql_real_escape_string($jsondata["proof_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_proof` SET
                        `portal_proof_portal_countries_id` = :id1,
                        `portal_proof_name` = :id2,
                        `portal_proof_updated_at` = :id3
                         WHERE `portal_proof_id`= :id';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["proof_id"]),
                ":id1" => mysql_real_escape_string($jsondata["country"]),
                ":id2" => mysql_real_escape_string($jsondata["proof"]),
                ":id3" => date("Y-m-d H:i:s"),
            ));
//        $business_type_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditModeOfService() {
        $jsondata = array(
            "mos_id" => base64_decode($this->postBaseData["mos_id"]),
            "mos" => $this->postBaseData["mos"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_mode_of_services` WHERE `portal_mode_of_services_mos`= :mos AND `portal_mode_of_services_id`!=:id');
        $res = $stm1->execute(array(
            ":mos" => mysql_real_escape_string($jsondata["mos"]),
            ":id" => mysql_real_escape_string($jsondata["mos_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_mode_of_services` SET
                         `portal_mode_of_services_mos` = :id2,
                         `portal_mode_of_services_updated_at` = :id3
                          WHERE `portal_mode_of_services_id`= :id
                          AND `portal_mode_of_services_status_id` = :id4';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["mos_id"]),
                ":id2" => mysql_real_escape_string($jsondata["mos"]),
                ":id3" => date("Y-m-d H:i:s"),
                ":id4" => mysql_real_escape_string($jsondata["stat"]),
            ));
//        $Mos_id = $this->db->lastInsertId();
            if ($res) {
                $jsondata["status"] = "success";
                $this->db->commit();
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditModeOPayment() {
        $jsondata = array(
            "mop_id" => base64_decode($this->postBaseData["mop_id"]),
            "mop" => $this->postBaseData["mop"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_mode_of_payment` WHERE `portal_mode_of_payment_mop`= :mop AND `portal_mode_of_payment_id`!=:id');
        $res = $stm1->execute(array(
            ":mop" => mysql_real_escape_string($jsondata["mop"]),
            ":id" => mysql_real_escape_string($jsondata["mop_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_mode_of_payment` SET
                         `portal_mode_of_payment_mop` = :id2,
                         `portal_mode_of_payment_updated_at` = :id3
                          WHERE `portal_mode_of_payment_id`= :id
                          AND `portal_mode_of_payment_status_id` = :id4';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id" => mysql_real_escape_string($jsondata["mop_id"]),
                ":id2" => mysql_real_escape_string($jsondata["mop"]),
                ":id3" => date("Y-m-d H:i:s"),
                ":id4" => mysql_real_escape_string($jsondata["stat"])
            ));
//        $Mos_id = $this->db->lastInsertId();
            if ($res) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function EditRestParameters() {
        $jsondata = array(
            "rest_param_id" => base64_decode($this->postBaseData["rest_param_id"]),
            "Param" => $this->postBaseData["Param"],
            "meang" => $this->postBaseData["meang"],
            "desc" => $this->postBaseData["desc"],
            "stat" => 4,
            "status" => 'error'
        );
        $stm1 = $this->db->prepare('SELECT * FROM `portal_rest_parameters` WHERE `portal_rest_parameters_field`= :Param AND `portal_rest_parameters_id`!=:id');
        $res = $stm1->execute(array(
            ":Param" => mysql_real_escape_string($jsondata["Param"]),
            ":id" => mysql_real_escape_string($jsondata["rest_param_id"])
        ));
        $count = $stm1->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query = 'UPDATE `portal_rest_parameters` SET
                         `portal_rest_parameters_field` = :id2,
                         `portal_rest_parameters_meaning` = :id3,
                         `portal_rest_parameters_description` = :id4,
                         `portal_rest_parameters_updated_at` = :id5
                          WHERE `portal_rest_parameters_id`= :id1
                          AND `portal_rest_parameters_status_id` = :id6';
            $stm = $this->db->prepare($query);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["rest_param_id"]),
                ":id2" => mysql_real_escape_string($jsondata["Param"]),
                ":id3" => mysql_real_escape_string($jsondata["meang"]),
                ":id4" => mysql_real_escape_string($jsondata["desc"]),
                ":id5" => date("Y-m-d H:i:s"),
                ":id6" => mysql_real_escape_string($jsondata["stat"])
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
    public function EditUserTypes() {
        $jsondata = array(
            "userType_id" => base64_decode($this->postBaseData["userType_id"]),
            "userType" => $this->postBaseData["userType"],
            "minBalance" => $this->postBaseData["minBalance"],
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `users_type` SET
                         `users_type_type` = :id1,
                         `users_type_minimum_balance` = :id2,
                         `users_type_updated_at` = :id3
                          WHERE `users_type_id`= :id
                          AND `users_type_status_id` = :id4';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($jsondata["userType_id"]),
            ":id1" => mysql_real_escape_string($jsondata["userType"]),
            ":id2" => mysql_real_escape_string($jsondata["minBalance"]),
            ":id3" => date("Y-m-d H:i:s"),
            ":id4" => mysql_real_escape_string($jsondata["stat"]),
        ));
//        $Mos_id = $this->db->lastInsertId();
        if ($res) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function DeleteBankDetails($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `company_bank_accounts` SET
                         `company_bank_accounts_status_id` = :stat,
                         `company_bank_accounts_updated_at` = :id1
                          WHERE `company_bank_accounts_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteBusinessInfo($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `company` SET
                         `company_status_id` = :stat,
                         `company_updated_at` = :id1
                          WHERE `company_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteSetCurrency($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `company_currency` SET
                         `company_currency_status_id` = :stat,
                         `company_currency_updated_at` = :id1
                          WHERE `company_currency_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteService($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `services` SET
                         `services_status_id` = :stat,
                         `services_updated_at` = :id1
                          WHERE `services_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteOperator($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `operators` SET
                         `operator_status_id` = :stat,
                         `operator_updated_at` = :id1
                          WHERE `operator_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteOperatorType($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `operators_type` SET
                         `operator_type_status_id` = :stat,
                         `operator_type_updated_at` = :id1
                          WHERE `operator_type_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteBusinessType($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_business_type` SET
                         `portal_business_type_status_id` = :stat,
                         `portal_business_type_updated_at` = :id1
                          WHERE `portal_business_type_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteCountries($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_countries` SET
                         `portal_countries_status_id` = :stat,
                         `portal_countries_updated_at` = :id1
                          WHERE `portal_countries_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteCurrency($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_currencies` SET
                         `portal_currencies_status_id` = :stat,
                         `portal_currencies_updated_at` = :id1
                          WHERE `portal_currencies_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteMOP($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_mode_of_payment` SET
                         `portal_mode_of_payment_status_id` = :stat,
                         `portal_mode_of_payment_updated_at` = :id1
                          WHERE `portal_mode_of_payment_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteMOS($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_mode_of_services` SET
                         `portal_mode_of_services_status_id` = :stat,
                         `portal_mode_of_services_updated_at` = :id1
                          WHERE `portal_mode_of_services_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteRestParam($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_rest_parameters` SET
                         `portal_rest_parameters_status_id` = :stat,
                         `portal_rest_parameters_updated_at` = :id1
                          WHERE `portal_rest_parameters_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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
    public function DeleteUserProof($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `portal_proof` SET
                         `portal_proof_status_id` = :stat,
                         `portal_proof_updated_at` = :id1
                          WHERE `portal_proof_id`= :id';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":id" => mysql_real_escape_string($id),
            ":stat" => mysql_real_escape_string($jsondata["stat"]),
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