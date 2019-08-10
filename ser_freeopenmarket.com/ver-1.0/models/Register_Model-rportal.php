<?php

class Register_Model extends BaseModel {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }

    public function signUp() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "pass1" => $this->postBaseData["pass1"],
            "pass2" => $this->postBaseData["pass2"],
            "mobile1" => $this->postBaseData["mobile1"],
            "mobile2" => $this->postBaseData["mobile2"],
            "utype" => $this->postBaseData["utype"],
            "stat" => 1,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `user_name` FROM `users` WHERE `user_name`= :name');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            /* User profile pic */
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => NULL
            ));
            $picid = $this->db->lastInsertId();
            /* Users */
            $query2 = 'INSERT INTO `users`(
                        `users_pk`,
                        `user_name`,
                        `user_photo_id`,
                        `user_password`,
                        `user_apassword`,
                        `user_authenticatkey`,
                        `user_type_id`,
                        `user_status_id`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        MD5(:id5),
                        MD5(:id6),
                        :id7,
                        :id8)';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => NULL,
                ":id2" => ($jsondata["name"]),
                ":id3" => ($picid),
                ":id4" => ($jsondata["pass1"]),
                ":id5" => ($jsondata["pass2"]),
                ":id6" => (time()),
                ":id7" => ($jsondata["utype"]),
                ":id8" => ($jsondata["stat"])
            ));
            $user_pk = $this->db->lastInsertId();
            if (($jsondata["email"]) != null) {
                $query4 = 'INSERT INTO `users_email_ids`(
                    `users_email_ids_id`,
                    `users_email_ids_users_pk`,
                    `users_email_ids_email`)Values('
                        . ':id1,
                        :id2,
                        :id3)';
                $stm4 = $this->db->prepare($query4);
                $res4 = $stm4->execute(array(
                    ":id1" => NULL,
                    ":id2" => $user_pk,
                    ":id3" => ($jsondata["email"])
                ));
            }
//        $q='SELECT * FROM `portal_countries` WHERE `portal_countries_Country`=:country';
//         $s = $this->db->prepare($q);
//            $r = $s->execute(array(
//                ":country" => ($jsondata["country"])
//        ));
//            $r = $s->execute();
//        if ($r) {
//            $result = $s->fetchAll();
//            $data["data"] = $result;
//        }
            $query6 = 'INSERT INTO `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_users_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                    . ':id1,
                    :id2,
                    :id3,
                    :id4)';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => NULL,
                ":id2" => $user_pk,
                ":id3" => NULL,
                ":id4" => ($jsondata["mobile1"])
            ));
            if (($jsondata["mobile2"]) != null) {
                $query7 = 'INSERT INTO `users_cell_numbers`(
                  `users_cell_numbers_id`,
                  `users_cell_numbers_users_pk`,
                  `users_cell_numbers_cell_code`,
                  `users_cell_numbers_cell_number`)Values('
                        . ':id1,
                    :id2,
                    :id3,
                    :id4)';
                $stm7 = $this->db->prepare($query7);
                $res7 = $stm7->execute(array(
                    ":id1" => NULL,
                    ":id2" => $user_pk,
                    ":id3" => NULL,
                    ":id4" => ($jsondata["mobile2"])
                ));
            }


            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query3 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `users_pk`=:id2';
            $stm3 = $this->db->prepare($query3);
            $res3 = $stm3->execute(array(
                ":id1" => ($directory),
                ":id2" => $user_pk
            ));
            /* User Money */
            $query5 = 'INSERT INTO  `users_money` (`users_money_users_pk`)  VALUES(:id);';
            $stm5 = $this->db->prepare($query5);
            $res5 = $stm5->execute(array(
                ":id" => ($user_pk)
            ));
            $money_id = $this->db->lastInsertId();
            if ($res1 && $res2 && $res3 && $res5 && $res6) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $this->sendMail(array(
                    "to" => $jsondata["email"],
                    "subject" => 'Thank you for registerting to Local Talent',
                    "message" => '<table width="80%" border="1" align="center" cellpadding="3" cellspacing="3">
                                <td colspan="2">&nbsp;</td>
                                <tr>
                                <td width="50%" align="left">Your User Name is ' . $jsondata["name"] . '</td>
                                </tr>
                                <tr>
                                <td width="50%" align="left">Password : ' . $jsondata["pass1"] . '</td>
                                </tr>
                                <tr>
                                <td colspan="2"><p>You cannot access this account till admin accepts your request.</p></td>
                                </tr>
                                <tr>
                                <td colspan="2">Regards,<br />Local Talent</td>
                                </tr>
                                </table>',
                        )
                );
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

}

?>