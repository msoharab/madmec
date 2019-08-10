<?php
class Channel_Model extends BaseModel {

    private $postData;

    function __construct() {
        parent::__construct();
    }
    public function getPostData() {
        return $this->postData;
    }
    public function setPostData($para, $base = false) {
        if (isset($para))
            $this->postData = $para;
        if (isset($base) && $base)
            $this->setPostBaseData($para);
    }
    public function CreateChannel() {
        $jsondata = array(
            "name" => $this->postData["details"]["name"],
            "target" => (array) $this->postData["details"]["target"],
            "langauges" => array(),
            "channel_id" => 0,
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT COUNT(`user_id`) FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
            ":status_id" => mysql_real_escape_string($jsondata["stat"])
        ));
        $count = $stm->rowCount();
        if ($count >= 5) {
            $jsondata["status"] = "Your quota is finished.";
        } else {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL
            ));
            $icon = $this->db->lastInsertId();
            $query2 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
            $stm = $this->db->prepare($query2);
            $res2 = $stm->execute(array(
                ":id" => NULL
            ));
            $background = $this->db->lastInsertId();
            $query3 = 'INSERT INTO `channel`(`user_id`,`channel_name`,`channel_icon`,`channel_background`,`status_id`,`channel_created_at`)Values('
                    . ':id1,:id2,:id3,:id4,:id5,NOW())';
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($icon),
                ":id4" => mysql_real_escape_string($background),
                ":id5" => mysql_real_escape_string($jsondata["stat"])
            ));
            $channel_pk = $this->db->lastInsertId();
            $data = array();
            for ($i = 0; $i < sizeof($jsondata["target"]); $i++) {
                $data[] = array(
                    "channel_id" => $channel_pk,
                    "country_id" => $jsondata["target"][$i],
                    "created_at" => date("Y-m-d H:i:s")
                );
            }
            $datafields = array("`channel_id`", "`country_id`", "`created_at`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $query4 = 'INSERT INTO `channel_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
            $stm = $this->db->prepare($query4);
            $res4 = $stm->execute($insert_values);
            if ($res1 && $res2 && $res3 && $res4) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["channel_id"] = $channel_pk;
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function ListChannels() {
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id ORDER BY `channel_created_at` DESC');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
            ":status_id" => mysql_real_escape_string($data["stat"])
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<a class="list-group-item"  href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/'.base64_encode($result[$i]["id"]) . '">' . $result[$i]["channel_name"] . '</a>';
        }
        if ($data["count"] <= 5) {
            $data["html"] .= '<button type="button" data-toggle="modal" data-target="#createchannel" data-whatever="@mdo" class="list-group-item btn btn-block btn-default" id="ex1">Create Channel</button>';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function View(){
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_countries` ORDER BY `Country`');
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["Country"] . '</option>';
        }
        //$data = $stm->fetchAll();
        return $data;
        
    }
}
?>