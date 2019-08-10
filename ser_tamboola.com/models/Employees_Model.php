<?php
class Employee_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $GYM_HOST = $_SESSION["GYM_DETAILS"][$this->postBaseData["GymId"]]["GYM_HOST"];
        $GYM_USERNAME = $_SESSION["GYM_DETAILS"][$this->postBaseData["GymId"]]["GYM_USERNAME"];
        $GYM_DB_PASSWORD = $_SESSION["GYM_DETAILS"][$this->postBaseData["GymId"]]["GYM_DB_PASSWORD"];
        $GYM_DB_NAME = $_SESSION["GYM_DETAILS"][$this->postBaseData["GymId"]]["GYM_DB_NAME"];
    }
    public function EmployeeAdd() {
        $link = MySQLconnect($this->postBaseData["GYM_HOST"], $this->postBaseData["GYM_USERNAME"], $this->postBaseData["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->postBaseData["GYM_DB_NAME"], $link)) == 1) {
                $jsondata = array(
                    "referrer" => $this->postBaseData["referrer"],
                    "attender" => $this->postBaseData["attender"],
                    "visitor" => $this->postBaseData["visitor"],
                    "email" => $this->postBaseData["email"],
                    "mobile" => $this->postBaseData["mobile"],
                    "followup1" => $this->postBaseData["followup1"],
                    "followup2" => $this->postBaseData["followup2"],
                    "followup3" => $this->postBaseData["followup3"],
                    "about" => $this->postBaseData["about"],
                    "facility" => $this->postBaseData["facility"],
                    "fitness" => $this->postBaseData["fitness"],
                    "joining" => $this->postBaseData["joining"],
                    "comments" => $this->postBaseData["comments"],
                    "stat" => 4,
                    "status" => 'error'
                );
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO `' . $this->parameters["GYM_DB_NAME"] . '`.`customer`
					(`id`,
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
                    ":id3" => mysql_real_escape_string($jsondata["email"]),
                    ":id4" => mysql_real_escape_string($jsondata["acsid"]),
                    ":id5" => mysql_real_escape_string($photo_pk),
                    ":id6" => mysql_real_escape_string($data["directory"]),
                    ":id7" => mysql_real_escape_string($jsondata["cellcode"]),
                    ":id8" => mysql_real_escape_string($jsondata["cellnum"]),
                    ":id9" => mysql_real_escape_string($jsondata["occupation"]),
                    ":id10" => mysql_real_escape_string($jsondata["company"]),
                    ":id11" => mysql_real_escape_string($data["curr_time"]),
                    ":id12" => mysql_real_escape_string($jsondata["sex_type"]),
                    ":id13" => mysql_real_escape_string($jsondata["doj"]),
                    ":id14" => mysql_real_escape_string($jsondata["emnm"]),
                    ":id15" => mysql_real_escape_string($jsondata["emnum"]),
                    ":id16" => mysql_real_escape_string($jsondata["addressline"]),
                    ":id17" => mysql_real_escape_string($jsondata["town"]),
                    ":id18" => mysql_real_escape_string($jsondata["city"]),
                    ":id19" => mysql_real_escape_string($jsondata["district"]),
                    ":id20" => mysql_real_escape_string($jsondata["province"]),
                    ":id21" => mysql_real_escape_string($jsondata["country"]),
                    ":id22" => mysql_real_escape_string($receiptno),
                    ":id23" => mysql_real_escape_string($jsondata["sum_amount"]),
                    ":id24" => mysql_real_escape_string($data["user_id"]),
                    ":id25" => mysql_real_escape_string($jsondata["stat"])
                ));
                $enq_id = $this->db->lastInsertId();
                $query2 = 'INSERT INTO `enquiry_followups`(
                        `id`,
                        `enq_id`,
                        `followup_date`,
                        `comments`,
                        `status`)Values('
                        . ' : id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5)';
                $stm2 = $this->db->prepare($query2);
                $res2 = $stm2->execute(array(
                    ":id1" => NULL,
                    ":id2" => mysql_real_escape_string($enq_id),
                    ":id3" => mysql_real_escape_string($jsondata["followup1"]),
                    ":id4" => mysql_real_escape_string($jsondata["comments"]),
                    ":id5" => 4
                ));
                $query3 = 'INSERT INTO `enquiry_reach`(
                        `id`,
                        `enq_id`,
                        `medium_ads_id`,
                        `status`)Values('
                        . ':id1,
                        :id2,
                        :id3,
                        :id4)';
                $stm3 = $this->db->prepare($query3);
                $res3 = $stm3->execute(array(
                    ":id1" => NULL,
                    ":id2" => mysql_real_escape_string($enq_id),
                    ":id3" => mysql_real_escape_string($jsondata["about"]),
                    ":id4" => 4
                ));
                $query4 = 'INSERT INTO `enquiry_on`(
                        `id`,
                        `enq_id`,
                        `facility_id`,
                        `status`)Values('
                        . ':id1,
                        :id2,
                        :id3,
                        :id4)';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => NULL,
                    ":id2" => mysql_real_escape_string($enq_id),
                    ":id3" => mysql_real_escape_string($jsondata["facility"]),
                    ":id4" => 4
                ));
                if ($res1 && $res2 && $res3 && $res4) {
                    $this->db->commit();
                    $jsondata["status"] = "success";
                } else {
                    $this->db->rollBack();
                }
                return $jsondata;
            }
        }
    }
    public function DeleteEmployee($uid) {
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