<?php

class BaseModel extends configure {

    protected $db, $postBaseData, $postBaseFile, $configBase;
    public $LogId;
    private $RestaurantId, $RestaurantData;

    public function __construct() {
        parent::__construct();
        $this->db = new dataBase();
        $this->db->query('SET SESSION group_concat_max_len=18446744073709551615');
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
        $this->db->exec("SET time_zone='$offset';");
        $this->postBaseData = NULL;
        $this->LogId = '';
        if (isset($_SESSION["Restaurant_DETAILS"])) {
            $this->RestaurantData = $_SESSION["Restaurant_DETAILS"];
            $this->RestaurantId = $this->RestaurantData["Restaurantid"];
        }
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
            "status" => 'error',
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
                                                LEFT JOIN `user_type` AS t2 ON t1.`user_type_id` = t2.`id`
                                                /* User Company 1:1 */
                                                LEFT JOIN `users_company` AS t3 ON t1.`user_pk` = t3.`users_company_user_pk`
                                                /* Company 1:1 */
                                                LEFT JOIN `company` AS t4 ON t3.`users_company_company_id` =  t4.`company_id`
                                                WHERE `user_name`= :email
                                                AND t2.`status`= 4
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
            "status" => 'error',
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $query = 'SELECT 
                    TRUE 
                    FROM (SELECT `user_email` AS email FROM `users`
                    UNION
                    SELECT `users_email_ids_email` AS email FROM `users_email_ids`
                    UNION
                    SELECT `company_email_ids_email` AS email FROM`company_email_ids`) AS a
                    WHERE a.email = :email ';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":email" => $email,
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

    public function CustomerLoginByEmail($email = false) {
        $data = array(
            "count" => 0,
            "loggedin" => 0,
            "status" => 'error',
            "userdata" => array(),
        );
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
            ) AS profic
            FROM `users` AS t1
            LEFT JOIN `users_type` AS t2 ON t1.`user_type_id` = t2.`users_type_id`
            WHERE `user_email`   = :name
            AND `user_status_id` = :stat
            ');
        $res = $stm->execute(array(
            ":name" => ($email),
            ":stat" => 4,
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $data["loggedin"] = 1;
            $_SESSION["USERDATA"] = $data;
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["USERDATA"]["logindata"] = $temp[0];
            $data["userdata"] = (array) $_SESSION["USERDATA"]["logindata"];
            $data["status"] = 'success';
        }
        return $data;
    }

    public function checkEmailCompanyDB($email = false) {
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
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
                ad.*,
                ue.`users_email_ids_email`,
                ug.`users_gender_name`,
                pp.`portal_proof_name`,
                ut.`type`,
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
                CASE WHEN (SELECT COUNT(`users_cell_numbers_cell_number`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`=ad.`user_pk`)=2
		THEN (SELECT `users_cell_numbers_cell_number`
		FROM `users_cell_numbers`
		WHERE `users_cell_numbers_id` IN (SELECT `users_cell_numbers_id` FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk` AND users_cell_numbers_id!=ucn.`users_cell_numbers_id`))
		ELSE NULL
		END AS mobile2
		FROM users AS ad
                LEFT JOIN `users_email_ids` AS ue ON ad.`user_pk` = ue.`users_email_ids_user_pk`
                LEFT JOIN `users_cell_numbers` AS ucn ON ad.`user_pk` = ucn.`users_cell_numbers_user_pk`
                LEFT JOIN `user_type` AS ut ON ad.`user_type_id` = ut.`id`
                LEFT JOIN `users_proof` AS up ON ad.`user_proof_id` = up.`users_proof_id`
                LEFT JOIN `users_gender` AS ug ON ad.`user_gender` = ug.`users_gender_id`
                LEFT JOIN `portal_proof` AS pp ON up.`users_proof_portal_proof_id` = pp.`portal_proof_id`
                WHERE ad.`user_pk` = :uid
                AND ad.`user_type_id`=ut.`id`
                AND ucn.`users_cell_numbers_id` IN (SELECT MIN(`users_cell_numbers_id`) FROM `users_cell_numbers` WHERE `users_cell_numbers_user_pk`= ad.`user_pk`)
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

    public function getCountry($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT *, t2.`portal_continents_continent_name` FROM `portal_countries` AS ad
                 LEFT JOIN `portal_continents` AS t2 ON t2.`portal_continents_id` = ad.`portal_countries_portal_continents_id`
                 WHERE `portal_countries_id` = :uid AND `portal_countries_status_id` = 4 AND `portal_continents_status_id` = :stat');
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

    public function getMOP($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_mode_of_payment` WHERE `portal_mode_of_payment_id` = :uid AND `portal_mode_of_payment_status_id` = :stat');
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

    public function getMOS($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_mode_of_services` WHERE `portal_mode_of_services_id` = :uid AND `portal_mode_of_services_status_id` = :stat');
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

    public function getUserTypes($id = true) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `user_type` WHERE `id` = :uid AND `status` = :stat');
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

    public function getStatusId($statname = false) {
        $statname = ucfirst($statname);
        $stm = $this->db->prepare('SELECT `id` FROM `status` WHERE `statu_name` =\'' . $statname . '\';');
        $stm->execute();
        $dir = $stm->fetchColumn();
        return $dir;
    }

    public function getRestaurant($id = false) {
        //$_SESSION["Restaurant_DETAILS"] = NULL;
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error',
            "loggedin" => 0
        );
        $query = 'SELECT
            ad.`id` AS Restaurantid,
            ad.`Restaurant_name` AS Restaurantname,
            ad.`Restaurant_type` AS Restauranttype,
            ad.`db_name` AS db_name,
            ue.`ge_id`,
            ue.`Restaurantemail`,
            ad.`directory` AS gdir,
            ad.`telephone` AS Restaurantphone,
            ad.`short_logo` AS slogoid,
            ad.`header_logo` AS hlogoid,
            ad.`photo_id` AS vlogoid,
            ad.`service_tax`,
            ad.`addressline`,
            ad.`town`,
            ad.`city`,
            ad.`district`,
            ad.`province`,
            ad.`country`,
            ad.`zipcode`,
            ad.`postal_code`,
            ad.`telephone`,
            ad.`gmaphtml`,
            ucn.`gcn_id`,
            ucn.`Restaurantcell`,
            ad.`reg_fee` AS Restaurantregfee,
            CONCAT(ad.`addressline`,"\n\r",ad.`town`,"\n\r",ad.`city`,"\n\r",ad.`district`,"\n\r",ad.`province`,"\n\r",ad.`country`,"\n\r",ad.`zipcode`) AS Restaurantaddr,
            ad.`website`,
            CASE WHEN ad.`short_logo` IS NULL OR ad.`short_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS short_logo,
            CASE WHEN ad.`header_logo` IS NULL OR ad.`header_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
            END AS header_logo,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS photo
        FROM `Restaurant_profile` AS ad
        LEFT JOIN
         (
              SELECT
              GROUP_CONCAT(`id`) AS ge_id,
              `Restaurant_id`,
              GROUP_CONCAT(`email`) AS Restaurantemail
              FROM `Restaurant_email_ids`
              GROUP BY (`Restaurant_id`)
         ) AS ue ON  ue.`Restaurant_id` = ad.`id`
        LEFT JOIN
          (
              SELECT
              GROUP_CONCAT(`id`) AS gcn_id,
              `Restaurant_id`,
              GROUP_CONCAT(CONCAT(`cell_code`,"-",`cell_number` )) AS Restaurantcell
              FROM `Restaurant_cell_numbers`
              GROUP BY (`Restaurant_id`)
          ) AS ucn ON  ucn.`Restaurant_id` = ad.`id`
         LEFT JOIN `Restaurant_photo` AS ph1 ON ad.`short_logo` = ph1.`id`
         INNER JOIN `user_profile_Restaurant_profile` AS up_gp ON (ad.`id` = up_gp.`Restaurant_id` AND up_gp.`status` = 4)
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND up_gp.`user_pk` = :uid
        AND ad.`id` = :gid
        GROUP BY (ad.`id`)
        ORDER BY (ad.`id`) DESC';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":uid" => ($_SESSION["USERDATA"]["logindata"]["users_pk"]),
            ":gid" => ($id)
        ));
        $data["count"] = $stm->rowCount();
        if ($data["count"] > 0) {
            $data["status"] = "success";
            $data["data"] = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["Restaurant_DETAILS"] = $data["data"][0];
            $data["data"] = $_SESSION["Restaurant_DETAILS"];
        }
        return $data;
    }

    public function getIndexRestaurant($id = false) {
        //$_SESSION["Restaurant_DETAILS"] = NULL;
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error',
            "loggedin" => 0
        );
        $query = 'SELECT
            ad.`id` AS Restaurantid,
            ad.`Restaurant_name` AS Restaurantname,
            ad.`Restaurant_type` AS Restauranttype,
            ad.`db_name` AS db_name,
            ue.`ge_id`,
            ue.`Restaurantemail`,
            ad.`directory` AS gdir,
            ad.`telephone` AS Restaurantphone,
            ad.`short_logo` AS slogoid,
            ad.`header_logo` AS hlogoid,
            ad.`photo_id` AS vlogoid,
            ad.`service_tax`,
            ad.`addressline`,
            ad.`town`,
            ad.`city`,
            ad.`district`,
            ad.`province`,
            ad.`country`,
            ad.`zipcode`,
            ad.`postal_code`,
            ad.`telephone`,
            ad.`gmaphtml`,
            ucn.`gcn_id`,
            ucn.`Restaurantcell`,
            ad.`reg_fee` AS Restaurantregfee,
            CONCAT(ad.`addressline`,"\n\r",ad.`town`,"\n\r",ad.`city`,"\n\r",ad.`district`,"\n\r",ad.`province`,"\n\r",ad.`country`,"\n\r",ad.`zipcode`) AS Restaurantaddr,
            ad.`website`,
            CASE WHEN ad.`short_logo` IS NULL OR ad.`short_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS short_logo,
            CASE WHEN ad.`header_logo` IS NULL OR ad.`header_logo`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
            END AS header_logo,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_LOGO"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS photo
        FROM `Restaurant_profile` AS ad
        LEFT JOIN
         (
              SELECT
              GROUP_CONCAT(`id`) AS ge_id,
              `Restaurant_id`,
              GROUP_CONCAT(`email`) AS Restaurantemail
              FROM `Restaurant_email_ids`
              GROUP BY (`Restaurant_id`)
         ) AS ue ON  ue.`Restaurant_id` = ad.`id`
        LEFT JOIN
          (
              SELECT
              GROUP_CONCAT(`id`) AS gcn_id,
              `Restaurant_id`,
              GROUP_CONCAT(CONCAT(`cell_code`,"-",`cell_number` )) AS Restaurantcell
              FROM `Restaurant_cell_numbers`
              GROUP BY (`Restaurant_id`)
          ) AS ucn ON  ucn.`Restaurant_id` = ad.`id`
         LEFT JOIN `Restaurant_photo` AS ph1 ON ad.`short_logo` = ph1.`id`
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ad.`id` = :gid
        GROUP BY (ad.`id`)
        ORDER BY (ad.`id`) DESC';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":gid" => ($id)
        ));
        $data["count"] = $stm->rowCount();
        if ($data["count"] > 0) {
            $data["status"] = "success";
            $data["data"] = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["Restaurant_DETAILS"] = $data["data"][0];
            $data["data"] = $_SESSION["Restaurant_DETAILS"];
        }
        return $data;
    }

    /* Query Builder */

    public function fetchAdminDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $usertypes = isset($this->postBaseData["usertype_ids"]) && is_array($this->postBaseData["usertype_ids"]) ? implode(",", $this->postBaseData["usertype_ids"]) :
                "2,3";
        $stm = $this->db->prepare('SELECT
                    t1.*,
                    t2.*,user_name
                    FROM `user_profile_type` AS t1
                    LEFT JOIN `users` AS t2 ON t2.`id` = t1.`user_pk`
                    WHERE `usertype_id` IN (' . $usertypes . ')
                    AND t1.`status` = :stat
                    AND t2.`status` = :stat
                    ORDER BY `id`');
//        $stm = $this->db->prepare('SELECT * FROM `users` WHERE id =(SELECT id FROM `user_profile_type` WHERE `usertype_id` IN (' . $usertypes . ')) AND `status` = :stat ORDER BY `id`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["user_name"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["user_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["user_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }

    public function fetchRestaurantsDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `master_gender` WHERE `status` = :stat ORDER BY `id`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gender_name"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gender_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["gender_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }

    public function fetchGenderDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `master_gender` WHERE `status` = :stat ORDER BY `id`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gender_name"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gender_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["gender_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }

    public function fetchUserTypesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgutn_' . mt_rand(99, 9999),
            "class" => 'litgutcla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $usertypes = isset($this->postBaseData["usertype_ids"]) && is_array($this->postBaseData["usertype_ids"]) ? implode(",", $this->postBaseData["usertype_ids"]) :
                "1,3,4,5,6,7,8,9";
        $stm = $this->db->prepare('SELECT * FROM `user_type` WHERE `status` = :stat AND `id` IN (' . $usertypes . ') ORDER BY `id` ');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["type"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["type"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["type"])) .
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
                $query3 = 'UPDATE `' . $where . '` SET `original_pic` = :name,
                        `ver1` = :des,
                        `ver2` = :now,
                        `ver3` = :web,
                        `ver4` = :fb,
                        `ver5` = :gp
                    WHERE `id` = :id;';
                $stm = $this->db->prepare($query3);
                $res3 = $stm->execute(array(
                    ":name" => ($photo['original_pic']),
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

    public function updatePhotoDetails($id = false, $table = false, $attr = false) {
        $res3 = false;
        if (is_array($photo) && $picid > 0) {
            if (count($photo) > 0) {
                $query3 = 'UPDATE `' . $table . '` SET `' . $attr . '` = :name,
                        `ver1` = :des,
                        `ver2` = :now,
                        `ver3` = :web,
                        `ver4` = :fb,
                        `ver5` = :gp
                    WHERE `id` = :id;';
                $stm = $this->db->prepare($query3);
                $res3 = $stm->execute(array(
                    ":name" => ($photo['original_pic']),
                    ":id" => ($id),
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
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
            t1.`user_pk` AS pk,
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
            (SELECT `users_money_available_cash` FROM `users_money` AS t2 WHERE t1.`user_pk` = t2.`users_money_user_pk` AND t2.`users_money_status_id` = 4) AS ch_count
        FROM `users_cell_numbers` AS ucn
            LEFT JOIN `users_email_ids` AS ue ON ue.`users_email_ids_user_pk` = ucn.`users_cell_numbers_user_pk`
        LEFT JOIN `users` AS t1 ON t1.`user_pk` = ue.`users_email_ids_user_pk`
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

    public function updateUserlog() {
        if (isset($_SESSION["LogId"])) {
            $this->LogId = $_SESSION["LogId"];
            $query = 'UPDATE `user_logs` SET `out_time` = NOW() WHERE `id`= :id2;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id2" => ($this->LogId),
            ));
        } else {
            $query = 'INSERT INTO `users_logs` (`users_logs_id`,
					`users_logs_ip`,
					`users_logs_host`,
					`users_logs_city`,
					`users_logs_zipcode`,
					`users_logs_province`,
					`users_logs_province_code`,
					`users_logs_country`,
					`users_logs_country_code`,
					`users_logs_latitude`,
					`users_logs_longitude`,
					`users_logs_timezone`,
					`users_logs_organization`,
					`users_logs_isp`,
					`users_logs_browser`,
					`users_logs_users_pk`,
					`users_logs_in_time`)  VALUES(
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
				\'' . ($_SERVER['HTTP_USER_AGENT']) . '\',
				\'' . ($_SESSION["USERDATA"]["logindata"]["users_pk"]) . '\',
				default);';
            $stm = $this->db->prepare($query);
            $res = $stm->execute();
        }
    }

}

?>