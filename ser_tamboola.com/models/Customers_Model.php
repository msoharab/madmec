<?php
class Customers_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData, $db, $connString, $obj;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
    public function CustomersAdd() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "gender" => $this->postBaseData["gender"],
            "cellnumber" => $this->postBaseData["cellnumber"],
            "emailid" => $this->postBaseData["emailid"],
            "company" => $this->postBaseData["company"],
            "occupation" => $this->postBaseData["occupation"],
            "regisfee" => $this->postBaseData["regisfee"],
            "amount" => $this->postBaseData["amount"],
            "doj" => $this->postBaseData["doj"],
            "referred" => $this->postBaseData["referred"],
            "emergencyname" => $this->postBaseData["emergencyname"],
            "emergencynum" => $this->postBaseData["emergencynum"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "district" => $this->postBaseData["district"],
            "city" => $this->postBaseData["city"],
            "street" => $this->postBaseData["street"],
            "addressline" => $this->postBaseData["addressline"],
            "zipcode" => $this->postBaseData["zipcode"],
            "website" => $this->postBaseData["website"],
            "link" => $link,
            "stat" => 4,
            "status" => 'error'
        );
        $user_pk = $this->logindata["user_pk"];
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO  `customer` (`id`,
                                         `name`,
					`email`,
					`acs_id`,
					`photo_id`,
					`directory`,
					`cell_code`,
					`cell_number`,
					`occupation`,
					`company`,
					`dob`,
					`sex`,
					`date_of_join`,
					`emergency_name`,
					`emergency_num`,
					`addressline`,
					`town`,
					`city`,
					`district`,
					`province`,
					`country`,
					`receipt_no`,
					`fee`,
					`master_pk`,
					`status`) VALUES('
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
                        :id25)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["name"]),
            ":id3" => mysql_real_escape_string($jsondata["gender"]),
            ":id4" => mysql_real_escape_string($jsondata["db_host"]),
            ":id5" => mysql_real_escape_string($jsondata["db_username"]),
            ":id6" => mysql_real_escape_string($jsondata["db_password"]),
            ":id7" => Null,
            ":id8" => Null,
            ":id9" => mysql_real_escape_string($jsondata["cellnum"]),
            ":id10" => mysql_real_escape_string($jsondata["emailid"]),
            ":id11" => mysql_real_escape_string($jsondata["company"]),
            ":id12" => mysql_real_escape_string($jsondata["occupation"]),
            ":id13" => mysql_real_escape_string($jsondata["amount"]),
            ":id14" => mysql_real_escape_string($jsondata["datejoining"]),
            ":id15" => mysql_real_escape_string($jsondata["emergencyname"]),
            ":id16" => mysql_real_escape_string($jsondata["emergencynum"]),
            ":id27" => mysql_real_escape_string($jsondata["addressline"]),
            ":id19" => mysql_real_escape_string($jsondata["street"]),
            ":id20" => mysql_real_escape_string($jsondata["city"]),
            ":id21" => mysql_real_escape_string($jsondata["district"]),
            ":id22" => mysql_real_escape_string($jsondata["state"]),
            ":id23" => NULL,
            ":id24" => mysql_real_escape_string($jsondata["country"]),
            ":id25" => NULL,
            ":id26" => mysql_real_escape_string($jsondata["zipcode"]),
            ":id27" => mysql_real_escape_string($jsondata["website"]),
            ":id28" => mysql_real_escape_string($jsondata["stat"]),
        ));
        $custamer_pk = $this->db->lastInsertId();
        $query2 = 'INSERT INTO `customer_email_ids`(
                  `id`,
                  `user_pk`,
                  `email`,
                  `status`)Values('
                . ':id1,
                    :id2,
                    :id3,
                    :id4)';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($custamer_pk),
            ":id3" => mysql_real_escape_string($jsondata["email"]),
            ":id4" => 4
        ));
        $query3 = 'INSERT INTO `$customer_reach`(
                  `id`,
                  `user_pk`,
                  `cell_number`,
                  `status`)Values('
                . ':id1,
                    :id2,
                    :id3,
                    :id4)';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string(custamer_pk),
            ":id3" => mysql_real_escape_string($jsondata["cellnumber"]),
            ":id4" => 4
        ));
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_Customer_' . $customer_pk);
        $query4 = 'UPDATE `cutomer` SET `directory` = :id1 WHERE `id`= :id2;';
        $stm4 = $this->db->prepare($query4);
        $res4 = $stm4->execute(array(
            ":id1" => $directory,
            ":id2" => $custamer_pk
        ));
        $query5 = 'UPDATE `Customer` SET `db_name` = :id1 WHERE `id`= :id2;';
        $stm5 = $this->db->prepare($query5);
        $res5 = $stm5->execute(array(
            ":id1" => mysql_real_escape_string($jsondata["db_name"]),
            ":id2" => customer_pk
        ));
        $query6 = 'INSERT INTO `userprofile_Customer` VALUES (NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($Customer_pk) . '\',\'' . mysql_real_escape_string($active) . '\');';
        $stm6 = $this->db->prepare($query6);
        $res6 = $stm6->execute();
        $dbname = mysql_real_escape_string($jsondata["db_name"]);
        $query7 = 'CALL slaveDbCreate("' . $dbname . '");';
        $stm7 = $this->db->prepare($query7);
        $res7 = $stm7->execute();
        if ($res1 && $res2 && $res3 && $res4 && $res5 && $res6 && $res7) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function Listcumtomer() {
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
        $searchqr = ' AND (ad.`customer name`    LIKE :col1
                        OR ue.`email`   LIKE :col2
                        OR ucn.`cell_number`    LIKE :col3
                        OR ad.`date_of_joining`     LIKE :col4
                        OR ad.`reg_fee`     LIKE :col5)';
        if (isset($this->postBaseData["order"])) {
            $column = (int) $this->postBaseData["order"][0]["column"];
            $dir = $this->postBaseData["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`customer_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`email_id` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`cell_number` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`date_of_joining` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`reg_fee` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS custid,
            ad.`customer_name` AS enqname,
            ad.`email_id` AS custnumb,
            ad.`cell_number` AS custemail,
            ad.`date_of_joining` AS custdoj,
            ad.`reg_fee` AS custregfee,
            FROM `customer` AS ad
        LEFT JOIN `customer_email_ids` AS ue ON ue.`user_pk` = ad.`id`
         LEFT JOIN `customer_cell_numbers` AS ucn ON ucn.`gym_id` = ad.`id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ue.`status` = 4
        AND ucn.`status` = 4' . $searchqr . ' ' . $orderqr;
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
                        "Customer Name" => ucfirst($result[$i]["custname"]),
                        "Email" => $result[$i]["custemail"],
                        "Cell Number" => $result[$i]["custnumb"],
                        "date_of_joining" => $result[$i]["custref"],
                        "reg_fee" => $result[$i]["custregfee"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_24"] . 'EditCostomer/' . base64_encode($result[$i]["custid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_24"] . 'DeleteCustomer/' . base64_encode($result[$i]["custid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function EditCustomers() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "gender" => $this->postBaseData["gender"],
            "cellnumber" => $this->postBaseData["cellnumber"],
            "emailid" => $this->postBaseData["emailid"],
            "company" => $this->postBaseData["company"],
            "occupation" => $this->postBaseData["occupation"],
            "regisfee" => $this->postBaseData["regisfee"],
            "amount" => $this->postBaseData["amount"],
            "datejoining" => $this->postBaseData["datejoining"],
            "referred" => $this->postBaseData["referred"],
            "emergencyname" => $this->postBaseData["emergencyname"],
            "emergencynum" => $this->postBaseData["emergencynum"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "district" => $this->postBaseData["district"],
            "city" => $this->postBaseData["city"],
            "street" => $this->postBaseData["street"],
            "addressline" => $this->postBaseData["addressline"],
            "zipcode" => $this->postBaseData["zipcode"],
            "website" => $this->postBaseData["website"],
            "db_host" => '192.168.0.10',
            "db_user" => 'remote',
            "db_name" => 'tamboola_' . $this->generateRandomString(),
            "db_pass" => '9743967575',
            "stat" => 4,
            "status" => 'error'
        );
        $user_pk = $this->logindata["user_pk"];
        $this->db->beginTransaction();
        $query1 = 'UPDATE `Customers` SET
					`name`=:id1,
					`gender`=:id2,
					`db_host`=:id3,
					`db_username`=:id4,
					`db_password`=:id5,
					`short_logo`=:id6,
					`header_logo`=:id7,
					`cell_number`=:id8,
					`email_id`=:id9,
					`company`=:id10,
					`occupation`=:id11,
					`reg_fee`=:id12,
					`amount`=:id13,
                    `date_joining=:id14`,
                    `referred`=:id15,
                    `emergencyname`=:id16,
                    `emergencyname`=:id17,
					`addressline`=:id18,
					`town`=:id19,
					`city`=:id20,
					`district`=:id21,
					`province`=:id22,
					`province_code`=:id23,
					`country`=:id24,
					`country_code`=:id25,
					`zipcode`=:id25,
					`website`=:id26,
					`status`=:id29,
					WHERE `id`=:id';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["name"]),
            ":id3" => mysql_real_escape_string($jsondata["gender"]),
            ":id4" => mysql_real_escape_string($jsondata["db_host"]),
            ":id5" => mysql_real_escape_string($jsondata["db_username"]),
            ":id6" => mysql_real_escape_string($jsondata["db_password"]),
            ":id7" => Null,
            ":id8" => Null,
            ":id9" => mysql_real_escape_string($jsondata["cellnum"]),
            ":id10" => mysql_real_escape_string($jsondata["emailid"]),
            ":id11" => mysql_real_escape_string($jsondata["company"]),
            ":id12" => mysql_real_escape_string($jsondata["occupation"]),
            ":id13" => mysql_real_escape_string($jsondata["regisfee"]),
            ":id14" => mysql_real_escape_string($jsondata["amount"]),
            ":id15" => mysql_real_escape_string($jsondata["datejoining"]),
            ":id16" => mysql_real_escape_string($jsondata["referred"]),
            ":id17" => mysql_real_escape_string($jsondata["emergencyname"]),
            ":id18" => mysql_real_escape_string($jsondata["emergencynum"]),
            ":id29" => mysql_real_escape_string($jsondata["addressline"]),
            ":id20" => mysql_real_escape_string($jsondata["street"]),
            ":id21" => mysql_real_escape_string($jsondata["city"]),
            ":id22" => mysql_real_escape_string($jsondata["district"]),
            ":id23" => mysql_real_escape_string($jsondata["state"]),
            ":id24" => NULL,
            ":id25" => mysql_real_escape_string($jsondata["country"]),
            ":id26" => NULL,
            ":id27" => mysql_real_escape_string($jsondata["zipcode"]),
            ":id28" => mysql_real_escape_string($jsondata["website"]),
            ":id29" => mysql_real_escape_string($jsondata["stat"]),
        ));
        $query2 = 'UPDATE `Customers_email_ids` SET
                              `email`=:id1,
                              `status`=:id2
                               WHERE `id`=:id3';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => mysql_real_escape_string($jsondata["email"]),
            ":id2" => mysql_real_escape_string($jsondata["stat"]),
            ":id3" => mysql_real_escape_string($jsondata["id"]),
        ));
        $query3 = 'UPDATE `Customers_cell_numbers` SET
                  `cell_code`=:id1,
                  `cell_number`=:id2,
                  `status`=:id3
                  WHERE `id`=:id';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => mysql_real_escape_string($jsondata["cellnumber"]),
            ":id2" => mysql_real_escape_string($jsondata["stat"]),
            ":id" => mysql_real_escape_string($jsondata["id"])
        ));
        $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_Customer_' . $id);
        $query4 = 'UPDATE `Customer` SET `directory` = :id1 WHERE `id`=:id2';
        $stm4 = $this->db->prepare($query4);
        $res4 = $stm4->execute(array(
            ":id1" => mysql_real_escape_string($directory),
            ":id2" => mysql_real_escape_string($jsondata["id"])
        ));
        if ($res1 && $res2 && $res3 && $res4) {
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
        $query = 'UPDATE `Customers` SET
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
    public function DeleteCustomer($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => ' error '
        );
        $this->db->beginTransaction();
        $query = ' UPDATE `  enquiry  ` SET `  status` = :stat
                        WHERE `id` = :id';
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
            echo '<script language = "javascript">';
            echo 'alert("Not deleted")';
            echo '</script>';
        }
        return $jsondata;
    }
}
?>