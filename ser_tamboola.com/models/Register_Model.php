<?php
class Register_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
    public function signUp(){
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "email" => $this->postBaseData["email"],
            "mobile" => $this->postBaseData["mobile"],
            "gender" => $this->postBaseData["gender"],
            "pass1" => $this->postBaseData["pass1"],
            "pass2" => $this->postBaseData["pass2"],
            "utype" => $this->postBaseData["utype"],
            "stat" => 1,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `email_id` FROM `user_profile` WHERE `email_id`= :email');
        $res = $stm->execute(array(
            ":email" => ($jsondata["email"])
        ));$count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            /* User profile pic */
            $query1 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id" => NULL
            ));
            $picid = $this->db->lastInsertId();
             $query2 = 'INSERT INTO `user_profile`(
                        `id`,
                        `user_name`,
                        `email_id`,
                        `photo_id`,
                        `password`,
                        `apassword`,
                        `cell_number`,
                        `gender`,
                        `status`)Values('
                    . ':id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        MD5(:id6),
                        :id7,
                        :id8,
                        :id9)';
            $stm2 = $this->db->prepare($query2);
            $res2 = $stm2->execute(array(
                ":id1" => NULL,
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($jsondata["email"]), 
                ":id4" => mysql_real_escape_string($picid),
                ":id5" => mysql_real_escape_string($jsondata["pass1"]),
                ":id6" => mysql_real_escape_string($jsondata["pass2"]),
                ":id7" => mysql_real_escape_string($jsondata["mobile"]),
                ":id8" => mysql_real_escape_string($jsondata["gender"]),
                ":id9" => mysql_real_escape_string($jsondata["stat"])
            ));
            $user_pk = $this->db->lastInsertId();
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
                ":id2" => mysql_real_escape_string($user_pk),
                ":id3" => mysql_real_escape_string($jsondata["utype"]),
                ":id4" => 4
            ));
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query6 = 'UPDATE `user_profile` SET `directory` = :id1 WHERE `id`=:id2';
            $stm6 = $this->db->prepare($query6);
            $res6 = $stm6->execute(array(
                ":id1" => mysql_real_escape_string($directory),
                ":id2" => mysql_real_escape_string($user_pk)
            ));
            if ($res1 && $res2 && $res3 && $res6 && $res) {
                $this->db->commit();
                $jsondata["status"] = "success";
//                    $this->sendMail(array(
//                        "to" => $jsondata["email"],
//                        "subject" => 'Thank you for registerting to Tamboola',
//                        "message" => '<table width="80%" border="1" align="center" cellpadding="3" cellspacing="3">
//                                <td colspan="2">&nbsp;</td>
//                                <tr>
//                                <td width="50%" align="left">Your User Name is ' . $jsondata["name"] . '</td>
//                                </tr>
//                                <tr>
//                                <td width="50%" align="left">Password : ' . $jsondata["pass1"] . '</td>
//                                </tr>
//                                <tr>
//                                <td colspan="2"><p>We will get back to you soon.</p></td>
//                                </tr>
//                                <tr>
//                                <td colspan="2">Regards,<br />Tamboola</td>
//                                </tr>
//                                </table>'
//                            )
//                    );
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
}
?>