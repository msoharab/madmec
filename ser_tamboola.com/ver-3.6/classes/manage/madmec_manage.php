<?php

class madmec_manage {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function autoCompleteEnq() {
         $query = 'SELECT
					tr.`id` AS pk,
					tr.`user_name` AS name,
					tr.`email` AS email,
					tr.`cell_number` AS cell,
					CASE WHEN tr.`photo_id` IS NULL
						 THEN \'' . TRAIN_ANON_IMAGE . '\'
						 ELSE CONCAT(\'' . URL . DIRS . '\',ph2.`ver3`)
					END AS photo,
                                        ut.user_type
				FROM `user_profile` AS tr
				LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
                                LEFT JOIN user_type ut
                                ON ut.id=tr.user_type_id
				WHERE tr.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Registered" AND `status` = 1)
				;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $name[$i]["label"] = $row["user_type"] . "-" .$row["name"] . "-" . $row["email"] . "-" . $row["cell"];
                $name[$i]["value"] = $i;
                $name[$i]["icon"] = $row["photo"];
                $name[$i]["id"] = $row["pk"];
                $i++;
            }
        } else {
            $name = '';
        }
//        $query = 'SELECT
//					tr.`id` AS pk,
//					tr.`user_name` AS name,
//					tr.`email` AS email,
//					tr.`cell_number` AS cell,
//					CASE WHEN tr.`photo_id` IS NULL
//						 THEN \'' . TRAIN_ANON_IMAGE . '\'
//						 ELSE CONCAT(\'' . URL . DIRS . '\',ph2.`ver3`)
//					END AS photo
//				FROM `employee` AS tr
//				LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
//				WHERE tr.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Joined" AND `status` = 1)
//				;';
//        $res = executeQuery($query);
//        if (mysql_num_rows($res) > 0) {
//            $i = 0;
//            while ($row = mysql_fetch_assoc($res)) {
//                $emp[$i]["label"] = $row["name"] . "-" . $row["email"] . "-" . $row["cell"];
//                $emp[$i]["value"] = $i;
//                $emp[$i]["icon"] = $row["photo"];
//                $emp[$i]["id"] = $row["pk"];
//                $i++;
//            }
//        } else
//            $emp = '';
        $clients = array(
            "listofPeoples" => $name,
//            "listofEmp" => $emp,
        );
        return $clients;
    }

}
