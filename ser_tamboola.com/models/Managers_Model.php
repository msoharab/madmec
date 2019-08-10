<?php
class Managers_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
    public function ManagerAdd() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "gender" => $this->postBaseData["gender"],
            "dob" => $this->postBaseData["dob"],
            "utype" => $this->postBaseData["utype"],
            "email" => $this->postBaseData["email"],
            "cellnumber" => $this->postBaseData["cellnumber"],
            "country" => $this->postBaseData["country"],
            "state" => $this->postBaseData["state"],
            "district" => $this->postBaseData["district"],
            "city" => $this->postBaseData["city"],
            "addressline" => $this->postBaseData["addressline"],
            "zipcode" => $this->postBaseData["zipcode"],
            "doctype" => $this->postBaseData["doctype"],
            "docnumber" => $this->postBaseData["docnumber"],
            "docpath" => $this->postBaseData["docpath"],
            "pass1" => $this->generateRandomString(),
            "pass2" => $this->generateRandomString(),
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO `user_profile`(
                        `id`,
                        `user_name`,
                        `gender`,
                        `dob`,
                        `cell_number`,
                        `email_id`,
                        `password`,
                        `apassword`,
                        `status`)Values('
                . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8,
                        :id13)';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($jsondata["name"]),
            ":id3" => mysql_real_escape_string($jsondata["gender"]),
            ":id4" => mysql_real_escape_string($jsondata["dob"]),
            ":id5" => mysql_real_escape_string($jsondata["cellnumber"]),
            ":id6" => mysql_real_escape_string($jsondata["email"]),
            ":id7" => mysql_real_escape_string($jsondata["pass1"]),
            ":id8" => mysql_real_escape_string($jsondata["pass2"]),
//            ":id9" => mysql_real_escape_string($jsondata["state"]),
//            ":id10" => mysql_real_escape_string($jsondata["district"]),
//            ":id11" => mysql_real_escape_string($jsondata["city"]),
//            ":id12" => mysql_real_escape_string($jsondata["zipcode"]),
            ":id13" => mysql_real_escape_string($jsondata["stat"])
        ));
        $user_id = $this->db->lastInsertId();
        $query2 = 'INSERT INTO `user_documents`(
                  `id`,
                  `user_pk`,
                  `document_type`,
                  `document_number`,
                  `document_path`,
                  `status`)Values('
                . ':id1,
                    :id2,
                    :id3,
                    :id4,
                    :id5,
                    :id6)';
        $stm2 = $this->db->prepare($query2);
        $res2 = $stm2->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($user_id),
            ":id3" => mysql_real_escape_string($jsondata["doctype"]),
            ":id4" => mysql_real_escape_string($jsondata["docnumber"]),
            ":id5" => mysql_real_escape_string($jsondata["docpath"]),
            ":id6" => 4
        ));
        $query3 = 'INSERT INTO `user_profile_type`(
                  `id`,
                  `user_pk`,
                  `usertype_id`,
                  `status`)Values('
                . ':id1,
                    :id2,
                    :id3,
                    :id4)';
        $stm3 = $this->db->prepare($query3);
        $res3 = $stm3->execute(array(
            ":id1" => NULL,
            ":id2" => mysql_real_escape_string($user_id),
            ":id3" => mysql_real_escape_string($jsondata["utype"]),
            ":id4" => 4
        ));
        if ($res1 && $res2 && $res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ListEnquiry() {
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
        $searchqr = ' AND (ad.`customer_name`    LIKE :col1
                        OR ad.`cell_number`    LIKE :col2
                        OR ad.`email_id`   LIKE :col3
                        OR ad.`handled_by`   LIKE :col4
                        OR ad.`referred_by`    LIKE :col5
                        OR ad.`jop`     LIKE :col6
                        OR ad.`ft_goal`     LIKE :col7
                        OR ad.`date`     LIKE :col8
                        OR ad.`comments`     LIKE :col9)';
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
                    $orderqr = ' ORDER BY ad.`cell_number` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`email_id` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY ad.`handled_by` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY ad.`referred_by` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY ad.`jop` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY ad.`ft_goal` ' . $dir;
                    break;
                case 8:
                    $orderqr = ' ORDER BY ad.`date` ' . $dir;
                    break;
                case 9:
                    $orderqr = ' ORDER BY ad.`comments` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }
        $query = 'SELECT
            ad.`id` AS enqid,
            ad.`customer_name` AS enqname,
            ad.`cell_number` AS enqnumb,
            ad.`email_id` AS enqemail,
            ad.`handled_by` AS enqhand,
            ad.`referred_by` AS enqref,
            ad.`jop` AS enqjop,
            ad.`ft_goal` AS enqgoal,
            ad.`comments` AS enqcomm,
            ad.`date` AS enqdate
            FROM `enquiry` AS ad
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
                        "Customer Name" => ucfirst($result[$i]["enqname"]),
                        "Cell Number" => $result[$i]["enqnumb"],
                        "Email" => $result[$i]["enqemail"],
                        "Referred" => $result[$i]["enqref"],
                        "Trainer" => $result[$i]["enqhand"],
                        "Joining Probability" => $result[$i]["enqjop"],
                        "Comments" => $result[$i]["enqcomm"],
                        "Date" => $result[$i]["enqdate"],
                        "Fitness Goals" => $result[$i]["enqgoal"],
                        "Edit" => '<a href="' . $this->config["URL"] . $this->config["CTRL_20"] . 'EditEnquiry/' . base64_encode($result[$i]["enqid"]) . '" target="_self" class="btn btn-block btn-danger">Edit<a>',
                        "Delete" => '<a href="' . $this->config["URL"] . $this->config["CTRL_20"] . 'DeleteEnquiry/' . base64_encode($result[$i]["enqid"]) . '" target="_self" class="btn btn-block btn-danger">Delete<a>'
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
    public function DeleteEnquiry($uid) {
        $id = base64_decode($uid);
        $jsondata = array(
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query = 'UPDATE `enquiry` SET
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
}
?>