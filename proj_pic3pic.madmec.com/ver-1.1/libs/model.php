<?php
class BaseModel extends configure {

    protected $db, $postBaseData, $configBase;

    public function __construct() {
        parent::__construct();
        $this->db = new dataBase();
        $this->db->query('SET SESSION group_concat_max_len=18446744073709551615');
        $this->postBaseData = NULL;
    }
    public function getPostData() {
        return $this->postBaseData;
    }
    public function setPostData($para) {
        if (isset($para))
            $this->postBaseData = $para;
    }
    public function setIdHolders($para = false) {
        $this->idHolders = $para;
    }
    public function getIdHolders() {
        return $this->idHolders;
    }
    public function checkEmailDB($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'failed',
            "userdata" => array(),
        );
        if (isset($this->postBaseData["user_name"])) {
            $stm = $this->db->prepare('SELECT `email` FROM `user_profile` WHERE `email`= :email');
            $res = $stm->execute(array(
                ":email" => mysql_real_escape_string($this->postBaseData["user_name"]),
            ));
            if ($res) {
                if ($stm->rowCount() > 0) {
                    $data["count"] = $stm->rowCount();
                    $stm = $this->db->prepare('SELECT 
                                                t1.*,
                                                CASE WHEN t1.`icon` IS NULL OR t1.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                                                THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                                                ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                                                END AS profic
                                                FROM `user_profile` AS t1 
                                                LEFT JOIN `photo` AS ph1 ON t1.`icon` = ph1.`id`
                                                WHERE t1.`email`= :email
                                                AND t1.`status_id` = 4');
                    $res = $stm->execute(array(
                        ":email" => mysql_real_escape_string($this->postBaseData["user_name"]),
                    ));
                    $count = $stm->rowCount();
                    if ($count > 0) {
                        $data["loggedin"] = 0;
                        $_SESSION["USERDATA"] = $data;
                        $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION["USERDATA"]["logindata"] = $temp[0];
                        $data["userdata"] = (array) $_SESSION["USERDATA"]["logindata"];
                    }
                    $data["status"] = 'success';
                }
            }
        }
        return $data;
    }
    /* Query Builder */
    public function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }
        return implode($separator, $result);
    }
    public function buildListPostArray($res, $stm) {
        $newRes = array();
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount(); $i++) {
                array_push($newRes, array(
                    "posts" => array(
                        //"post_ct" => (integer) $result[$i]["post_ct"],
                        "id" => (integer) $result[$i]["id"],
                        "title" => $result[$i]["title"],
                        "photo_id" => (integer) $result[$i]["photo_id"],
                        "section_id" => (integer) $result[$i]["section_id"],
                        "user_id" => (integer) $result[$i]["user_id"],
                        "created_at" => $result[$i]["created_at"],
                        "posterid" => (integer) $result[$i]["posterid"],
                        "postername" => $result[$i]["postername"],
                        "posteremail" => $result[$i]["posteremail"],
                        "postercell" => $result[$i]["postercell"],
                        "posterpic" => $result[$i]["posterpic"],
                        "p_pic_flag" => $result[$i]["p_pic_flag"],
                        "lk_p_ct" => (integer) $result[$i]["lk_p_ct"],
                        "pc_ct" => (integer) $result[$i]["pc_ct"],
                        "chwaid" => (integer) $result[$i]["chwaid"],
                        "chwauid" => (integer) $result[$i]["chwauid"],
                        "chwacid" => (integer) $result[$i]["chwacid"],
                        "chwapost_id" => (integer) $result[$i]["chwapost_id"],
                        "chwatime" => $result[$i]["chwatime"],
                        "channel_name" => $result[$i]["channel_name"],
                        "channel_description" => isset($result[$i]["channel_description"]) ? $result[$i]["channel_description"] : '',
                        "channel_location" => isset($result[$i]["channel_location"]) ? $result[$i]["channel_location"] : '',
                        "channel_language" => isset($result[$i]["channel_language"]) ? $result[$i]["channel_language"] : '',
                        "channel_icon" => isset($result[$i]["channel_icon"]) ? $result[$i]["channel_icon"] : '',
                        "channel_background" => isset($result[$i]["channel_background"]) ? $result[$i]["channel_background"] : '',
                        "channel_created_at" => isset($result[$i]["channel_created_at"]) ? $result[$i]["channel_created_at"] : '',
                        "channel_updated_at" => isset($result[$i]["channel_updated_at"]) ? $result[$i]["channel_updated_at"] : '',
                        "channel_website" => isset($result[$i]["channel_website"]) ? $result[$i]["channel_website"] : '',
                        "channel_status_id" => isset($result[$i]["channel_status_id"]) ? $result[$i]["channel_status_id"] : '',
                        "chsubid" => isset($result[$i]["chsubid"]) ? $result[$i]["chsubid"] : 0,
                        "chsubcid" => isset($result[$i]["chsubcid"]) ? $result[$i]["chsubcid"] : 0,
                        "chsubuid" => isset($result[$i]["chsubuid"]) ? $result[$i]["chsubuid"] : 0,
                        "chsubtime" => isset($result[$i]["chsubtime"]) ? $result[$i]["chsubtime"] : '',
                        "photo" => array(
                            "p_phid" => $result[$i]['p_phid'],
                            "p_ph" => $result[$i]['p_ph'],
                            "p_pv1" => $result[$i]['p_pv1'],
                            "p_pv2" => $result[$i]['p_pv2'],
                            "p_pv3" => $result[$i]['p_pv3'],
                            "p_pv4" => $result[$i]['p_pv4'],
                            "p_pv5" => $result[$i]['p_pv5'],
                        ),
                        "post_location" => array(
                            "post_location" => $result[$i]["post_location"],
                            "pcont_id" => explode("♥☻☻♥", $result[$i]['pcont_id']),
                            "pcont_time" => explode("♥☻☻♥", $result[$i]['pcont_time']),
                            "pcont_contid" => explode("♥☻☻♥", $result[$i]['pcont_contid']),
                            "pcont_contname" => explode("♥☻☻♥", $result[$i]['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => explode("♥☻☻♥", $result[$i]['pr_uname']),
                            "pr_id" => explode("♥☻☻♥", $result[$i]['pr_id']),
                            "pr_uid" => explode("♥☻☻♥", $result[$i]['pr_uid']),
                            "pr_time" => explode("♥☻☻♥", $result[$i]['pr_time']),
                            "pr_repid" => explode("♥☻☻♥", $result[$i]['pr_repid']),
                            "pr_repname" => explode("♥☻☻♥", $result[$i]['pr_repname']),
                        ),
                        "preference" => array(
                            "pp_uname" => explode("♥☻☻♥", $result[$i]['pp_uname']),
                            "pp_id" => explode("♥☻☻♥", $result[$i]['pp_id']),
                            "pp_uid" => explode("♥☻☻♥", $result[$i]['pp_uid']),
                            "pp_time" => explode("♥☻☻♥", $result[$i]['pp_time']),
                            "pp_preid" => explode("♥☻☻♥", $result[$i]['pp_preid']),
                            "pp_pref" => explode("♥☻☻♥", $result[$i]['pp_pref']),
                        ),
                        "likes" => array(
                            "lk_p_uname" => explode("♥☻☻♥", $result[$i]['lk_p_uname']),
                            "lk_p_id" => explode("♥☻☻♥", $result[$i]['lk_p_id']),
                            "lk_p_uid" => explode("♥☻☻♥", $result[$i]['lk_p_uid']),
                            "lk_p_time" => explode("♥☻☻♥", $result[$i]['lk_p_time']),
                        ),
                        "sections" => array(
                            "ps_id" => $result[$i]['ps_id'],
                            "ps_time" => $result[$i]['ps_time'],
                            "ps_secid" => $result[$i]['ps_secid'],
                            "pr_secname" => $result[$i]['pr_secname'],
                        ),
                        "languages" => array(
                            "plng_id" => explode("♥☻☻♥", $result[$i]['plng_id']),
                            "plng_time" => explode("♥☻☻♥", $result[$i]['plng_time']),
                            "plng_lngid" => explode("♥☻☻♥", $result[$i]['plng_lngid']),
                            "plng_lngname" => explode("♥☻☻♥", $result[$i]['plng_lngname']),
                        ),
                        "comments" => array(
                            "pc_id" => explode("♥☻☻♥", $result[$i]['pc_id']),
                            "pc_uid" => explode("♥☻☻♥", $result[$i]['pc_uid']),
                            "commentererid" => explode("♥☻☻♥", $result[$i]['commentererid']),
                            "commentername" => explode("♥☻☻♥", $result[$i]['commentername']),
                            "commenteremail" => explode("♥☻☻♥", $result[$i]['commenteremail']),
                            "commentercell" => explode("♥☻☻♥", $result[$i]['commentercell']),
                            "commenterpic" => explode("♥☻☻♥", $result[$i]['commenterpic']),
                            "comments" => explode("♥☻☻♥", $result[$i]['comments']),
                            "pc_phid" => explode("♥☻☻♥", $result[$i]['pc_phid']),
                            "pc_ph" => explode("♥☻☻♥", $result[$i]['pc_ph']),
                            "pc_pv1" => explode("♥☻☻♥", $result[$i]['pc_pv1']),
                            "pc_pv2" => explode("♥☻☻♥", $result[$i]['pc_pv2']),
                            "pc_pv3" => explode("♥☻☻♥", $result[$i]['pc_pv3']),
                            "pc_pv4" => explode("♥☻☻♥", $result[$i]['pc_pv4']),
                            "pc_pv5" => explode("♥☻☻♥", $result[$i]['pc_pv5']),
                            "pc_pic_flag" => explode("♥☻☻♥", $result[$i]['pc_pic_flag']),
                            "pc_time" => explode("♥☻☻♥", $result[$i]['pc_time']),
                            "pcp_id" => $this->multiExplode($delimiters, $result[$i]['pcp_id']),
                            "pcp_uid" => $this->multiExplode($delimiters, $result[$i]['pcp_uid']),
                            "pcp_time" => $this->multiExplode($delimiters, $result[$i]['pcp_time']),
                            "pcp_preid" => $this->multiExplode($delimiters, $result[$i]['pcp_preid']),
                            "pcp_pref" => $this->multiExplode($delimiters, $result[$i]['pcp_pref']),
                            "pcp_uname" => $this->multiExplode($delimiters, $result[$i]['pcp_uname']),
                            "lk_pc_ct" => explode("♥☻☻♥", $result[$i]['lk_pc_ct']),
                            "lk_pc_id" => $this->multiExplode($delimiters, $result[$i]['lk_pc_id']),
                            "lk_pc_uid" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uid']),
                            "lk_pc_time" => $this->multiExplode($delimiters, $result[$i]['lk_pc_time']),
                            "lk_pc_uname" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uname']),
                            "replys" => array(
                                "pcr_ct" => explode("♥☻☻♥", $result[$i]['pcr_ct']),
                                "pcr_id" => $this->multiExplode($delimiters, $result[$i]['pcr_id']),
                                "pcr_uid" => $this->multiExplode($delimiters, $result[$i]['pcr_uid']),
                                "reply" => $this->multiExplode($delimiters, $result[$i]['reply']),
                                "replyererid" => $this->multiExplode($delimiters, $result[$i]['replyererid']),
                                "replyername" => $this->multiExplode($delimiters, $result[$i]['replyername']),
                                "replyeremail" => $this->multiExplode($delimiters, $result[$i]['replyeremail']),
                                "replyercell" => $this->multiExplode($delimiters, $result[$i]['replyercell']),
                                "replyerpic" => $this->multiExplode($delimiters, $result[$i]['replyerpic']),
                                "pcr_time" => $this->multiExplode($delimiters, $result[$i]['pcr_time']),
                                "pcr_pic_flag" => $this->multiExplode($delimiters, $result[$i]['pcr_pic_flag']),
                                "pcr_phid" => $this->multiExplode($delimiters, $result[$i]['pcr_phid']),
                                "pcr_ph" => $this->multiExplode($delimiters, $result[$i]['pcr_ph']),
                                "pcr_pv1" => $this->multiExplode($delimiters, $result[$i]['pcr_pv1']),
                                "pcr_pv2" => $this->multiExplode($delimiters, $result[$i]['pcr_pv2']),
                                "pcr_pv3" => $this->multiExplode($delimiters, $result[$i]['pcr_pv3']),
                                "pcr_pv4" => $this->multiExplode($delimiters, $result[$i]['pcr_pv4']),
                                "pcr_pv5" => $this->multiExplode($delimiters, $result[$i]['pcr_pv5']),
                                "lk_rep_ct" => $this->multiExplode($delimiters, $result[$i]['lk_rep_ct']),
                                "pcrp_id" => $this->multiExplode($delimiters1, $result[$i]['pcrp_id']),
                                "pcrp_uid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uid']),
                                "pcrp_time" => $this->multiExplode($delimiters1, $result[$i]['pcrp_time']),
                                "pcrp_preid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_preid']),
                                "pcrp_pref" => $this->multiExplode($delimiters1, $result[$i]['pcrp_pref']),
                                "pcrp_uname" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uname']),
                                "lk_rep_id" => $this->multiExplode($delimiters1, $result[$i]['lk_rep_id']),
                                "lk_replyer_id" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_id']),
                                "lk_replytime" => $this->multiExplode($delimiters1, $result[$i]['lk_replytime']),
                                "lk_replyer_name" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_name']),
                            ),
                        ),
                    )
                ));
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        if (count($newRes) > 0) {
            $_SESSION["ListNewPost"] = $newRes;
            //echo print_r($newRes[2]);
        }
        return $newRes;
    }
    public function getChannelDirectory($id = false) {
        $dir = '';
        if ($id) {
            $query = 'SELECT `channel_directory` FROM `channel` WHERE  `id`=:id2';
            $stm = $this->db->prepare($query);
            $stm->execute(array(
                ":id2" => $id
            ));
            $dir = $stm->fetchColumn();
        }
        return $dir;
    }
    public function getUserDirectory($id = false) {
        $dir = '';
        if ($id) {
            $query = 'SELECT `directory` FROM `user_profile` WHERE `id`=:id2';
            $stm = $this->db->prepare($query);
            $stm->execute(array(
                ":id2" => $id
            ));
            $dir = $stm->fetchColumn();
        }
        return $dir;
    }
}
?>