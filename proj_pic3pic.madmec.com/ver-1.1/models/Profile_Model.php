<?php
class Profile_Model extends BaseModel {

    public $UserId;

    function __construct() {
        parent::__construct();
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
    }
    public function ProfilePic() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "post_id" => $icon,
            "status" => 'error',
            "error" => '',
        );
        if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
            $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
            if ($photo["status"] === "success") {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":orgpic" => $photo['original_pic'],
                    ":ver1" => $photo['version_1'],
                    ":ver2" => $photo['version_2'],
                    ":ver3" => $photo['version_3'],
                    ":ver4" => $photo['version_4'],
                    ":ver5" => $photo['version_5']
                ));
                $icon = $this->db->lastInsertId();
                $query2 = 'UPDATE `user_profile` SET `icon` = :icon WHERE `id` = :uid;';
                $stm = $this->db->prepare($query2);
                $res2 = $stm->execute(array(
                    ":icon" => mysql_real_escape_string($icon),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
                $_SESSION["USERDATA"]["logindata"]["profic"] = $this->config["URL"] . $photo['version_2'];
                /*
                  $query2 = 'INSERT INTO `post`(`title`,`photo_id`,`user_id`,`post_location`,`status_id`,`created_at`)Values('
                  . ':id1,:id2,:id3,:id4,:id5,:id6)';
                  $stm = $this->db->prepare($query2);
                  $res2 = $stm->execute(array(
                  ":id1" => mysql_real_escape_string($jsondata["name"]),
                  ":id2" => mysql_real_escape_string($icon),
                  ":id3" => mysql_real_escape_string($this->UserId),
                  ":id4" => mysql_real_escape_string($location),
                  ":id5" => mysql_real_escape_string($jsondata["stat"]),
                  ":id6" => date("Y-m-d H:i:s")
                  ));
                 */
            }
            if ($res1 && $res2) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["post_id"] = $icon;
            } else {
                $this->db->rollBack();
            }

            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
}
?>