<?php

class BaseModel extends configure {

    protected $db, $postBaseData, $postBaseFile, $configBase;
    protected $order;
    protected $replace;

    public function __construct() {
        parent::__construct();
        $this->order = array("\r\n", "\n", "\r");
        $this->replace = '<br />';
        $this->db = new dataBase();
        $this->db->query('SET SESSION group_concat_max_len=18446744073709551615');
        $this->postBaseData = NULL;
    }

    public function setPostData($para) {
        if (isset($para))
            $this->postBaseData = $para;
    }

    public function setPostFile($para) {
        if (isset($para))
            $this->postBaseFile = $para;
    }

    public function setIdHolders($para = false) {
        $this->idHolders = $para;
    }

    public function checkUserNameDB($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'failed',
            "userdata" => array(),
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $stm = $this->db->prepare('SELECT `user_name` FROM `users` WHERE `user_name`= :email');
            $res = $stm->execute(array(
                ":email" => ($email),
            ));
            if ($res) {
                if ($stm->rowCount() > 0) {
                    $data["count"] = $stm->rowCount();
                    $stm = $this->db->prepare('SELECT
                                                    t1.*,
                                                    t2.*,
                                                    IF(t1.`user_photo_id` IS NOT NULL OR t1.`user_photo_id` != NULL,   (SELECT
                                                            CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                                                            THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                                                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                                                            END AS pic
                                                        FROM `portal_photo` AS ph1
                                                        WHERE t1.`user_photo_id` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
                                                    ) AS profic,
                                                    t4.`company_name`
                                                FROM `users` AS t1
                                                /* User Type 1:1 */
                                                LEFT JOIN `users_type` AS t2 ON t1.`user_type_id` = t2.`users_type_id`
                                                /* User Company 1:1 */
                                                LEFT JOIN `users_company` AS t3 ON t1.`users_pk` = t3.`users_company_users_pk`
                                                /* Company 1:1 */
                                                LEFT JOIN `company` AS t4 ON t3.`users_company_company_id` =  t4.`company_id`
                                                WHERE `user_name`= :email
                                                AND t2.`users_type_status_id`= 4
                                                AND t3.`users_company_status_id`= 4
                                                AND t4.`company_status_id`= 4');
                    $res = $stm->execute(array(
                        ":email" => ($email),
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

    public function checkEmailDB($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'failed',
            "userdata" => array(),
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $stm = $this->db->prepare('SELECT `users_email_ids_email` FROM `users_email_ids` WHERE `users_email_ids_email`= :email');
            $res = $stm->execute(array(
                ":email" => ($email),
            ));
            if ($res) {
                if ($stm->rowCount() > 0) {
                    $data["count"] = $stm->rowCount();
                    $data["status"] = 'success';
                }
            }
        }
        return $data;
    }

    public function checkEmailCompanyDB($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'failed',
            "userdata" => array(),
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $stm = $this->db->prepare('SELECT `company_email_ids_email` FROM `company_email_ids` WHERE `company_email_ids_email`= :email');
            $res = $stm->execute(array(
                ":email" => ($email),
            ));
            if ($res) {
                if ($stm->rowCount() > 0) {
                    $data["count"] = $stm->rowCount();
                    $data["status"] = 'success';
                }
            }
        }
        return $data;
    }

    public function checkEmailGatewayDB($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'failed',
            "userdata" => array(),
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $stm = $this->db->prepare('SELECT `gateway_email_ids_email` FROM `gateway_email_ids` WHERE `gateway_email_ids_email`= :email');
            $res = $stm->execute(array(
                ":email" => ($email),
            ));
            if ($res) {
                if ($stm->rowCount() > 0) {
                    $data["count"] = $stm->rowCount();
                    $data["status"] = 'success';
                }
            }
        }
        return $data;
    }

    public function getPostData() {
        return $this->postBaseData;
    }

    public function getPostFile() {
        return $this->postBaseFile;
    }

    public function getIdHolders() {
        return $this->idHolders;
    }

    public function getUser($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
                ad.*,
                ue.`users_email_ids_email`,
                ug.`users_gender_name`,
                pp.`portal_proof_name`,
                ut.`users_type_type`,
                up.*,
                IF(up.`users_proof_pic` IS NOT NULL OR up.`users_proof_pic` != NULL,   (SELECT
                    CASE WHEN ph1.`original_pic` IS NULL OR ph1.`original_pic` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`original_pic`)
                    END AS pic
                FROM `portal_photo` AS ph1
                WHERE up.`users_proof_pic` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS ppic,
                ucn.`users_cell_numbers_cell_number` AS mobile1,
                CASE WHEN (SELECT COUNT(`users_cell_numbers_cell_number`) FROM `users_cell_numbers` WHERE `users_cell_numbers_users_pk`=ad.`users_pk`)=2
		THEN (SELECT `users_cell_numbers_cell_number`
		FROM `users_cell_numbers`
		WHERE `users_cell_numbers_id` IN (SELECT `users_cell_numbers_id` FROM `users_cell_numbers` WHERE `users_cell_numbers_users_pk`= ad.`users_pk` AND users_cell_numbers_id!=ucn.`users_cell_numbers_id`))
		ELSE NULL
		END AS mobile2
		FROM users AS ad
                LEFT JOIN `users_email_ids` AS ue ON ad.`users_pk` = ue.`users_email_ids_users_pk`
                LEFT JOIN `users_cell_numbers` AS ucn ON ad.`users_pk` = ucn.`users_cell_numbers_users_pk`
                LEFT JOIN `users_type` AS ut ON ad.`user_type_id` = ut.`users_type_id`
                LEFT JOIN `users_proof` AS up ON ad.`user_proof_id` = up.`users_proof_id`
                LEFT JOIN `users_gender` AS ug ON ad.`user_gender` = ug.`users_gender_id`
                LEFT JOIN `portal_proof` AS pp ON up.`users_proof_portal_proof_id` = pp.`portal_proof_id`
                WHERE ad.`users_pk` = :uid
                AND ad.`user_type_id`=ut.`users_type_id`
                AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_users_pk`= ad.`users_pk`)
                AND ad.`user_status_id` = :stat');
        $res = $stm->execute(array(
            ":uid" => ($id),
            ":stat" => 4
        ));
        $res = $stm->execute();
        if ($res) {
            $data["data"] = $stm->fetch(PDO::FETCH_ASSOC);
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        return $data;
    }

    public function getProduct($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT ad.*
                        FROM `product` AS ad
                        WHERE ad.`id` = :uid AND ad.`status` = :stat');
        $res = $stm->execute(array(
            ":uid" => ($id),
            ":stat" => 4,
        ));
        $res = $stm->execute();
        if ($res) {
            $data["data"] = $stm->fetch(PDO::FETCH_ASSOC);
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        return $data;
    }

    /* Query Builder */

    public function fetchProductDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `product` WHERE `status` = :stat ORDER BY `id`');
        $res = $stm->execute(array(
            ":stat" => 4
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            //$data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
            switch ($listtype) {
                case "checkbox":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="checkbox" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }

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
        $delimiters = array("????", "???");
        $delimiters1 = array("????", "???", "??");
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
                            "pcont_id" => explode("????", $result[$i]['pcont_id']),
                            "pcont_time" => explode("????", $result[$i]['pcont_time']),
                            "pcont_contid" => explode("????", $result[$i]['pcont_contid']),
                            "pcont_contname" => explode("????", $result[$i]['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => explode("????", $result[$i]['pr_uname']),
                            "pr_id" => explode("????", $result[$i]['pr_id']),
                            "pr_uid" => explode("????", $result[$i]['pr_uid']),
                            "pr_time" => explode("????", $result[$i]['pr_time']),
                            "pr_repid" => explode("????", $result[$i]['pr_repid']),
                            "pr_repname" => explode("????", $result[$i]['pr_repname']),
                        ),
                        "preference" => array(
                            "pp_uname" => explode("????", $result[$i]['pp_uname']),
                            "pp_id" => explode("????", $result[$i]['pp_id']),
                            "pp_uid" => explode("????", $result[$i]['pp_uid']),
                            "pp_time" => explode("????", $result[$i]['pp_time']),
                            "pp_preid" => explode("????", $result[$i]['pp_preid']),
                            "pp_pref" => explode("????", $result[$i]['pp_pref']),
                        ),
                        "likes" => array(
                            "lk_p_uname" => explode("????", $result[$i]['lk_p_uname']),
                            "lk_p_id" => explode("????", $result[$i]['lk_p_id']),
                            "lk_p_uid" => explode("????", $result[$i]['lk_p_uid']),
                            "lk_p_time" => explode("????", $result[$i]['lk_p_time']),
                        ),
                        "sections" => array(
                            "ps_id" => $result[$i]['ps_id'],
                            "ps_time" => $result[$i]['ps_time'],
                            "ps_secid" => $result[$i]['ps_secid'],
                            "pr_secname" => $result[$i]['pr_secname'],
                        ),
                        "languages" => array(
                            "plng_id" => explode("????", $result[$i]['plng_id']),
                            "plng_time" => explode("????", $result[$i]['plng_time']),
                            "plng_lngid" => explode("????", $result[$i]['plng_lngid']),
                            "plng_lngname" => explode("????", $result[$i]['plng_lngname']),
                        ),
                        "comments" => array(
                            "pc_id" => explode("????", $result[$i]['pc_id']),
                            "pc_uid" => explode("????", $result[$i]['pc_uid']),
                            "commentererid" => explode("????", $result[$i]['commentererid']),
                            "commentername" => explode("????", $result[$i]['commentername']),
                            "commenteremail" => explode("????", $result[$i]['commenteremail']),
                            "commentercell" => explode("????", $result[$i]['commentercell']),
                            "commenterpic" => explode("????", $result[$i]['commenterpic']),
                            "comments" => explode("????", $result[$i]['comments']),
                            "pc_phid" => explode("????", $result[$i]['pc_phid']),
                            "pc_ph" => explode("????", $result[$i]['pc_ph']),
                            "pc_pv1" => explode("????", $result[$i]['pc_pv1']),
                            "pc_pv2" => explode("????", $result[$i]['pc_pv2']),
                            "pc_pv3" => explode("????", $result[$i]['pc_pv3']),
                            "pc_pv4" => explode("????", $result[$i]['pc_pv4']),
                            "pc_pv5" => explode("????", $result[$i]['pc_pv5']),
                            "pc_pic_flag" => explode("????", $result[$i]['pc_pic_flag']),
                            "pc_time" => explode("????", $result[$i]['pc_time']),
                            "pcp_id" => $this->multiExplode($delimiters, $result[$i]['pcp_id']),
                            "pcp_uid" => $this->multiExplode($delimiters, $result[$i]['pcp_uid']),
                            "pcp_time" => $this->multiExplode($delimiters, $result[$i]['pcp_time']),
                            "pcp_preid" => $this->multiExplode($delimiters, $result[$i]['pcp_preid']),
                            "pcp_pref" => $this->multiExplode($delimiters, $result[$i]['pcp_pref']),
                            "pcp_uname" => $this->multiExplode($delimiters, $result[$i]['pcp_uname']),
                            "lk_pc_ct" => explode("????", $result[$i]['lk_pc_ct']),
                            "lk_pc_id" => $this->multiExplode($delimiters, $result[$i]['lk_pc_id']),
                            "lk_pc_uid" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uid']),
                            "lk_pc_time" => $this->multiExplode($delimiters, $result[$i]['lk_pc_time']),
                            "lk_pc_uname" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uname']),
                            "replys" => array(
                                "pcr_ct" => explode("????", $result[$i]['pcr_ct']),
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

    public function uploadFileToServer($fileparam) {
        $errors = array();
        $verImages = array(
            "error" => NULL,
            "status" => "error",
        );
        $file = '';
        $path1 = '';
        $relativepath = '';
        $absolutepath = '';
        $target = $fileparam["target"];
        $directory = $fileparam["directory"];
        $pic_id = (integer) $fileparam["picid"];
        $file_name = $fileparam['file_name'];
        $file_size = $fileparam['file_size'];
        $file_tmp = $fileparam['file_tmp'];
        $file_type = $fileparam['file_type'];
        $file_ext = explode('.', $fileparam['file_name']);
        $file_ext = $file_ext[count($file_ext) - 1];
        $file_ext = strtolower($file_ext);
        $extensions = array("jpeg", "jpg", "jpe", "gif", "wbmp", "xbm", "png");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
        }
        if ($file_size > 20971520) {
            $errors[] = 'File size must be less than or equal to 2 MB';
        }
        if (empty($errors) == true) {
            $path1 = $this->config["DOC_ROOT"] . $directory . '/' . $target;
            $relativepath = $directory . '/' . $target;
            $file = 'ori_pic' . time() . '.' . $file_ext;
            $absolutepath = $path1 . '/' . $file;
            if (move_uploaded_file($file_tmp, $absolutepath)) {
                $temp = $this->ProcessImg($path1, $file);
                if (is_array($temp) && count($temp) > 0) {
                    foreach ($temp as &$value) {
                        $value = $relativepath . '/' . $value;
                    }
                    $temp["original_pic"] = $relativepath . '/' . $file;
                    if ($this->updatePortalPhotoDetails($temp, $pic_id)) {
                        $verImages["status"] = "success";
                    }
                }
            }
        }
        $verImages["error"] = (array) $errors;
        return $verImages;
    }

    public function updatePortalPhotoDetails($photo = false, $picid = 0, $where = false) {
        $res3 = false;
        if (is_array($photo) && $picid > 0) {
            if (count($photo) > 0) {
                $query3 = 'UPDATE `' . $where . '` SET `pic` = :name,
                        `ver1` = :des,
                        `ver2` = :now,
                        `ver3` = :web,
                        `ver4` = :fb,
                        `ver5` = :gp
                    WHERE `id` = :id;';
                $stm = $this->db->prepare($query3);
                $res3 = $stm->execute(array(
                    ":name" => ($photo['pic']),
                    ":des" => ($photo["ver1"]),
                    ":now" => ($photo["ver2"]),
                    ":web" => ($photo["ver3"]),
                    ":fb" => ($photo["ver4"]),
                    ":gp" => ($photo["ver5"]),
                    ":id" => ($picid),
                ));
            }
        }
        return $res3;
    }

    public function searchUserDB() {
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
            t1.`users_pk` AS pk,
            CONCAT(t1.`user_name`)AS name,
            ue.`users_email_ids_email` AS email,
            ucn.`users_cell_numbers_cell_number` AS cell,
            IF(t1.`user_photo_id` IS NOT NULL OR t1.`user_photo_id` != NULL,   (SELECT
                    CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                    END AS pic
                FROM `portal_photo` AS ph1
                WHERE t1.`user_photo_id` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS photos,
            (SELECT `users_money_available_cash` FROM `users_money` AS t2 WHERE t1.`users_pk` = t2.`users_money_users_pk` AND t2.`users_money_status_id` = 4) AS ch_count
        FROM `users_cell_numbers` AS ucn
            LEFT JOIN `users_email_ids` AS ue ON ue.`users_email_ids_users_pk` = ucn.`users_cell_numbers_users_pk`
        LEFT JOIN `users` AS t1 ON t1.`users_pk` = ue.`users_email_ids_users_pk`
        WHERE (t1.`user_name` LIKE "%' . ($this->postBaseData["q"]) . '%"
        OR ue.`users_email_ids_email` LIKE "%' . ($this->postBaseData["q"]) . '%"
        OR ucn.`users_cell_numbers_cell_number` LIKE "%' . ($this->postBaseData["q"]) . '%")
        AND t1.`user_status_id` = 4
        AND t1.`user_type_id`=8');
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            //$data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
            for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["name"]; $i++) {
                $result[$i]["ch_count"] = $result[$i]["ch_count"] ? (integer) $result[$i]["ch_count"] : 0;
                array_push($data["items"], array(
                    "index" => ($i + 1),
                    "text" => $result[$i]["name"],
                    "id" => (integer) $result[$i]["pk"],
                    "name" => $result[$i]["name"],
                    "avatar_url" => $result[$i]["photos"],
                    "email" => $result[$i]["email"],
                    "cell" => $result[$i]["cell"],
                    "ch_count" => (integer) $result[$i]["ch_count"]
                ));
            }
        }
        return $data;
    }

    public function forgotPassword() {
        $jsondata = array(
            "email" => $this->postBaseData["email"],
            "loggedin" => 0,
            "status" => 'error'
        );
        if ($this->validateEmail($jsondata["email"]) === $jsondata["email"]) {
            if ($this->checkEmailDB($jsondata["email"])) {
                $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE `email`= :email LIMIT 1');
                $res = $stm->execute(array(
                    ":email" => ($jsondata["email"]),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $jsondata["status"] = "success";
                    $jsondata["loggedin"] = 1;
                    $_SESSION["PASSWD"] = $jsondata;
                    $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION["PASSWD"]["logindata"] = $temp[0];
                }
            }
        }
        return $jsondata;
    }

    public function updateUserlog() {
        $query = 'INSERT INTO `user_logs` (`id`,
					`ip`,
					`host`,
					`city`,
					`zipcode`,
					`province`,
					`province_code`,
					`country`,
					`country_code`,
					`latitude`,
					`longitude`,
					`timezone`,
					`organization`,
					`isp`,
					`browser`,
					`user_pk`,
					`in_time`)  VALUES(
				NULL,
				\'' . ($_SESSION["IP_INFO"]["query"]) . '\',
				\'' . ($_SERVER["SERVER_ADDR"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["city"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["zip"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["regionName"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["region"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["country"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["countryCode"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["lat"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["lon"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["timezone"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["org"] . '???' . $_SESSION["IP_INFO"]["as"] . '???' . $_SESSION["IP_INFO"]["isp"]) . '\',
				\'' . ($_SESSION["IP_INFO"]["isp"]) . '\',
				\'' . ($this->postBaseData["browser"]) . '\',
				\'' . ($_SESSION["USERDATA"]["logindata"]["id"]) . '\',
				default);';
        $stm = $this->db->prepare($query);
        $res = $stm->execute();
    }

    public function getDirectory($id = false, $where = false, $attr = false) {
        $dir = '';
        if ($id) {
            $query = 'SELECT `directory` FROM `' . $where . '` WHERE `' . $attr . '`=:id2';
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