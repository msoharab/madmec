<?php
class BaseModel extends configure {

    protected $db, $postBaseData, $postBaseFile, $configBase;
    public $LogId;
    private $GymId, $GymData;

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
        if (isset($_SESSION["GYM_DETAILS"])) {
            $this->GymData = $_SESSION["GYM_DETAILS"];
            $this->GymId = $this->GymData["gymid"];
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
            "userdata" => array(),
        );
        $email = isset($this->postBaseData["email"]) && !empty($this->postBaseData["email"]) ?
                $this->postBaseData["email"] :
                isset($email) && !empty($email) ?
                        $email : '';
        if ($email) {
            $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE `email_id`= :email');
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
            "status" => 'error',
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
            "status" => 'error',
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
    public function getUserBusiness($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `users_business` AS ad
                LEFT JOIN `users_bank_accounts` AS t2 ON t2.`users_bank_accounts_users_business_id` = ad.`users_business_id`
                LEFT JOIN `users_business_address` AS t3 ON t3.`users_business_address_users_business_id` = ad.`users_business_id`
                WHERE `users_business_id` = :uid AND `users_business_status_id` = :stat');
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
    public function getUserCommission($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `users_commission` WHERE `users_commission_id` = :uid AND `users_commission_status_id` = :stat');
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
    public function getBusiness($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company` WHERE `company_id` = :uid AND `company_status_id` = :stat');
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
    public function getBusinessAddr($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company` WHERE `company_id` = :bid AND `company_status_id` = :stat');
        $res = $stm->execute(array(
            ":bid" => ($id),
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
    public function getBank($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company_bank_accounts` WHERE `company_bank_accounts_id` = :uid AND `company_bank_accounts_status_id` = :stat');
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
    public function getCurSet($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT ad.*,com.*,pc.*
                FROM `company_currency` AS ad
                LEFT JOIN `company` AS com ON com.`company_id`=ad.`company_currency_company_id`
                LEFT JOIN `portal_currencies` AS pc ON pc.`portal_currencies_id`=ad.`company_currency_portal_currencies_id`
                WHERE `company_currency_id` = :uid AND `company_currency_status_id` = :stat');
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
    public function getService($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `services` WHERE `services_id` = :uid AND `services_status_id` = :stat');
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
    public function getOperator($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT *,t2.`services_name` FROM `operators` AS ad
                LEFT JOIN `services` AS t2 ON t2.`services_id` = ad.`operator_services_id`
                WHERE `operator_id` = :uid AND `operator_status_id` = 4 AND `services_status_id` = :stat');
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
    public function getOperatorType($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `operators_type` WHERE `operator_type_id` = :uid AND `operator_type_status_id` = :stat');
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
    public function getBty($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT bt.*,pc.`portal_countries_Country`
                FROM `portal_business_type` AS bt
                LEFT JOIN `portal_countries` AS pc ON bt.`portal_business_type_portal_countries_id` = pc.`portal_countries_id`
                WHERE `portal_business_type_id` = :uid AND `portal_business_type_status_id` = :stat');
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
    public function getRestParam($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_rest_parameters` WHERE `portal_rest_parameters_id` = :uid AND `portal_rest_parameters_status_id` = :stat');
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
    public function getUserProof($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_proof` WHERE `portal_proof_id` = :uid AND `portal_proof_status_id` = :stat');
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
    public function getCur($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT bt.*,pc.*
                FROM `portal_currencies` AS bt
                LEFT JOIN `portal_countries` AS pc ON bt.`portal_currencies_portal_countries_id` = pc.`portal_countries_id`
                WHERE `portal_currencies_id` = :uid AND `portal_currencies_status_id` = :stat');
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
    public function getGateway($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT *,
              t2.`gateway_email_ids_email`,
              t3.`gateway_cell_numbers_cell_number`,
              t4.* FROM `gateway` AS ad
                LEFT JOIN `gateway_email_ids` AS t2 ON t2.`gateway_email_ids_gateway_id` = ad.`gateway_id`
                LEFT JOIN `gateway_cell_numbers` AS t3 ON t3.`gateway_cell_numbers_gateway_id` = ad.`gateway_id`
                LEFT JOIN `gateway_proof` AS t4 ON t4.`gateway_proof_id` = ad.`gateway_business_proof_id`
                WHERE `gateway_id` = :uid
                AND t2.`gateway_email_ids_status_id` = 4
                AND t3.`gateway_cell_numbers_status_id` = 4
                AND t4.`gateway_proof_status_id` = 4
                AND ad.`gateway_status_id` = :stat');
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
    public function getGatewayOperator($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT *,t2.`gateway_name` FROM `gateway_operators` AS ad
                LEFT JOIN `gateway` AS t2 ON t2.`gateway_id` = ad.`gateway_operator_gateway_id`
                WHERE `gateway_operator_id` = :uid AND `gateway_operator_status_id` = 4 AND `gateway_status_id` = :stat');
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
    public function getGatewayOperatorType($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators_type` WHERE `gateway_operator_type_id` = :uid AND `gateway_operator_type_status_id` = :stat');
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
    public function getGym($id = false) {
        //$_SESSION["GYM_DETAILS"] = NULL;
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error',
            "loggedin" => 0
        );
        $query = 'SELECT
            ad.`id` AS gymid,
            ad.`gym_name` AS gymname,
            ad.`gym_type` AS gymtype,
            ad.`db_name` AS db_name,
            ue.`ge_id`,
            ue.`gymemail`,
            ad.`directory` AS gdir,
            ad.`telephone` AS gymphone,
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
            ucn.`gymcell`,
            ad.`reg_fee` AS gymregfee,
            CONCAT(ad.`addressline`,"\n\r",ad.`town`,"\n\r",ad.`city`,"\n\r",ad.`district`,"\n\r",ad.`province`,"\n\r",ad.`country`,"\n\r",ad.`zipcode`) AS gymaddr,
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
        FROM `gym_profile` AS ad
        LEFT JOIN
         (
              SELECT 
              GROUP_CONCAT(`id`) AS ge_id,
              `gym_id`, 
              GROUP_CONCAT(`email`) AS gymemail
              FROM `gym_email_ids` 
              GROUP BY (`gym_id`)
         ) AS ue ON  ue.`gym_id` = ad.`id`
        LEFT JOIN
          (
              SELECT 
              GROUP_CONCAT(`id`) AS gcn_id,
              `gym_id`, 
              GROUP_CONCAT(CONCAT(`cell_code`,"-",`cell_number` )) AS gymcell
              FROM `gym_cell_numbers` 
              GROUP BY (`gym_id`)
          ) AS ucn ON  ucn.`gym_id` = ad.`id`
         LEFT JOIN `gym_photo` AS ph1 ON ad.`short_logo` = ph1.`id`
         INNER JOIN `user_profile_gym_profile` AS up_gp ON (ad.`id` = up_gp.`gym_id` AND up_gp.`status` = 4)
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4 
        AND up_gp.`user_pk` = :uid 
        AND ad.`id` = :gid
        GROUP BY (ad.`id`)
        ORDER BY (ad.`id`) DESC';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":uid" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["user_pk"]),
            ":gid" => mysql_real_escape_string($id)
        ));
        $data["count"] = $stm->rowCount();
        if ($data["count"] > 0) {
            $data["status"] = "success";
            $data["data"] = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["GYM_DETAILS"] = $data["data"][0];
            $data["data"] = $_SESSION["GYM_DETAILS"];
        }
        return $data;
    }
    public function getFacility($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `' . $this->GymData["db_name"] . '`.  `gym_facility` WHERE `id` = :uid AND `status` = :stat');
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
    public function getOffer($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $query = 'SELECT
            ad.`id` AS offid,
            ad.`name` AS offname,
            ad.`facility_id` AS offfaci,
            ad.`duration_id` AS offdura,
            ad.`min_members_id` AS offmem,
            /*
            (SELECT fc.`name` FROM `' . $this->GymData["db_name"] . '`.`gym_facility` AS fc WHERE  fc.`id` = ad.`facility_id`) AS offfaci,
            (SELECT fd.`duration` FROM `' . $this->GymData["db_name"] . '`.`master_offer_duration` AS fd WHERE  fd.`id` = ad.`duration_id`) AS offdura,
            (SELECT CONCAT(fm.`name`," - ",fm.`min_members`) AS mmm FROM `' . $this->GymData["db_name"] . '`.`master_min_members` AS fm WHERE  fm.`id` = ad.`min_members_id`) AS offmem,
             */
            ad.`description` AS offdesc,
            ad.`cost` AS offcost
            FROM `' . $this->GymData["db_name"] . '`.`gym_offers` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL) AND ad.`id` =  :uid';
        //var_dump($query);
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":uid" => ($id),
        ));
        $res = $stm->execute();
        if ($res) {
            $data["data"] = $stm->fetch(PDO::FETCH_ASSOC);
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        return $data;
    }
    public function getPackage($id = false) {
        $data = array(
            "data" => array(),
            "count" => 0,
            "status" => 'error'
        );
        $query = 'SELECT
            ad.`id` AS offid,
            ad.`package_type_id` AS ptype,
            ad.`name` AS offname,
            ad.`facility_id` AS offfaci,
            ad.`min_members_id` AS offmem,
            ad.`number_of_sessions` AS facsess,
            ad.`description` AS offdesc,
            ad.`cost` AS offcost
            FROM `' . $this->GymData["db_name"] . '`.`gym_packages` AS ad
        WHERE (ad.`id` != NULL OR ad.`id` IS NOT NULL) AND  ad.`id` = :uid';
        $stm = $this->db->prepare( $query);
        $res = $stm->execute(array(
            ":uid" => ($id),
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
                    LEFT JOIN `user_profile` AS t2 ON t2.`id` = t1.`user_pk`
                    WHERE `usertype_id` IN (' . $usertypes . ')
                    AND t1.`status` = :stat
                    AND t2.`status` = :stat
                    ORDER BY `id`');
//        $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE id =(SELECT id FROM `user_profile_type` WHERE `usertype_id` IN (' . $usertypes . ')) AND `status` = :stat ORDER BY `id`');
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
    public function fetchGymsDB($listtype = false) {
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
    public function fetchDocTypesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_proof` WHERE `status` = :stat ORDER BY `id`');
        $res = $stm->execute(array(
            ":stat" => 4,
            ":country" => 105
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["document_type"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["document_type"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["document_type"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchMediumAdsDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgutn_' . mt_rand(99, 9999),
            "class" => 'litgutcla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `medium_ads` WHERE `status` = :stat ORDER BY `id`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["ads_type"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["ads_type"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["ads_type"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchFacilityDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `' . $this->GymData["db_name"] . '`. `gym_facility` WHERE `status` = 4 ORDER BY `name`');
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
    public function fetchPackagesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `' . $this->GymData["db_name"] . '`. `master_package_name` WHERE `status` = :stat ORDER BY `package_name`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["package_name"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["package_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["package_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchDurationDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `' . $this->GymData["db_name"] . '`. `master_offer_duration` WHERE `status` = :stat ORDER BY `duration`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["duration"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["duration"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["duration"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchMinMemberDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `' . $this->GymData["db_name"] . '`. `master_min_members` WHERE `status` = :stat ORDER BY `min_members`');
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["duration"])) . '</li>';
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
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["duration"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"] . '">' .
                                ucfirst(trim($result[$i]["name"])) . ' - ' . ucfirst(trim($result[$i]["min_members"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchServicesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgmn_' . mt_rand(99, 9999),
            "class" => 'litgmncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `services` WHERE `services_status_id` = :stat ORDER BY `services_id`');
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
                                'value="' . $result[$i]["services_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["services_name"])) . ' ~ ' . ucfirst(trim($result[$i]["services_lt_code"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["services_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["services_name"])) . ' ~ ' . ucfirst(trim($result[$i]["services_lt_code"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["services_id"] . '">' .
                                ucfirst(trim($result[$i]["services_name"])) . ' ~ ' . ucfirst(trim($result[$i]["services_lt_code"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchOperatorDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgopn_' . mt_rand(99, 9999),
            "class" => 'litopncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
                    t1.*,
                    t2.`services_name`
                    FROM `operators` AS t1
                    LEFT JOIN `services` AS t2 ON t2.`services_id` = t1.`operator_services_id`
                    WHERE t1.`operator_status_id` = :stat1
                    AND t2.`services_status_id` = :stat2
                    ORDER BY `operator_id`');
        $res = $stm->execute(array(
            ":stat1" => 4,
            ":stat2" => 4,
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
                                'value="' . $result[$i]["operator_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["services_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_lt_code"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_alias"])) .
                                '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["operator_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["services_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_lt_code"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_alias"])) .
                                '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["operator_id"] . '">' . ucfirst(trim($result[$i]["services_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_lt_code"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_alias"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchOperatorTypeDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `operators_type` WHERE `operator_type_status_id` = :stat AND `operator_type_operator_id` = :opt ORDER BY `operator_type_id`');
        $res = $stm->execute(array(
            ":stat" => 4,
            ":opt" => ($this->postBaseData["operator"]),
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
                                'value="' . $result[$i]["operator_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["operator_type_type"])) . ' ~ ' . ucfirst(trim($result[$i]["operator_type_lt_code"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["operator_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["operator_type_type"])) . ' ~ ' . ucfirst(trim($result[$i]["operator_type_lt_code"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["operator_type_id"] . '">' . ucfirst(trim($result[$i]["operator_type_type"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["operator_type_lt_code"])) .
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
    public function fetchBusinessTypesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgutnb_' . mt_rand(99, 9999),
            "class" => 'litgutnbcla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_business_type` WHERE `portal_business_type_status_id` = :stat ORDER BY `portal_business_type_id`');
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
                                'value="' . $result[$i]["portal_business_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_business_type_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_business_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_business_type_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_business_type_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_business_type_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchCompanyDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `company` WHERE `company_status_id` = :stat ORDER BY `company_id`');
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
                                'value="' . $result[$i]["company_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["company_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["company_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["company_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["company_id"] . '">' .
                                ucfirst(trim($result[$i]["company_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchCurrencyDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
            ad.*,
            cont.`portal_countries_Country` AS contname
            FROM `portal_currencies` AS ad
            LEFT JOIN `portal_countries` AS cont ON cont.`portal_countries_id` = ad.`portal_currencies_portal_countries_id`
            WHERE ad.`portal_currencies_status_id` = :stat1
            AND cont.`portal_countries_status_id` = :stat2
            ORDER BY ad.`portal_currencies_CurrencyName`');
        $res = $stm->execute(array(
            ":stat1" => 4,
            ":stat2" => 4,
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
                                'value="' . $result[$i]["portal_currencies_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_currencies_CurrencyName"])) . '  ~  ' .
                                ucfirst(trim($result[$i]["contname"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_currencies_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_currencies_CurrencyName"])) . '  ~  ' .
                                ucfirst(trim($result[$i]["contname"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_currencies_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_currencies_CurrencyName"])) . '  ~  ' .
                                ucfirst(trim($result[$i]["contname"]))
                                . '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchListCountriesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
            ad.*,
            cont.`portal_continents_continent_name` AS contname
            FROM `portal_countries` AS ad
            LEFT JOIN `portal_continents` AS cont ON cont.`portal_continents_id` = ad.`portal_countries_portal_continents_id`
            WHERE ad.`portal_countries_status_id` = :stat1
            AND cont.`portal_continents_status_id` = :stat2
            ORDER BY cont.`portal_continents_continent_name`');
        $res = $stm->execute(array(
            ":stat1" => 4,
            ":stat2" => 4,
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
                                'value="' . $result[$i]["portal_countries_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["contname"])) . ' ~ ' .
                                ucfirst(trim($result[$i]["portal_countries_Country"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_countries_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["contname"])) . ' ~ ' .
                                ucfirst(trim($result[$i]["portal_countries_Country"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_countries_id"] . '">' .
                                ucfirst(trim($result[$i]["contname"])) . ' ~ ' .
                                ucfirst(trim($result[$i]["portal_countries_Country"]))
                                . '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchListContinentsDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemno_' . mt_rand(99, 9999),
            "class" => 'litgemnocla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_continents` WHERE `portal_continents_status_id` = :stat ORDER BY `portal_continents_id`');
        $res = $stm->execute(array(
            ":stat" => 4,
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
                                'value="' . $result[$i]["portal_continents_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_continents_continent_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_continents_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_continents_continent_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_continents_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_continents_continent_name"])) . '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchListGatewaysDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway` WHERE `gateway_status_id` = :stat ORDER BY `gateway_id`');
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
                                'value="' . $result[$i]["gateway_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["gateway_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["gateway_id"] . '">' .
                                ucfirst(trim($result[$i]["gateway_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchGatewayOperatorDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgopne_' . mt_rand(99, 9999),
            "class" => 'litopnecla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT
                    t1.*,
                    t2.`gateway_name`
                    FROM `gateway_operators` AS t1
                    LEFT JOIN `gateway` AS t2 ON t2.`gateway_id` = t1.`gateway_operator_gateway_id`
                    WHERE t1.`gateway_operator_status_id` = :stat1
                    AND t2.`gateway_status_id` = :stat2
                    ORDER BY `gateway_operator_id`');
        $res = $stm->execute(array(
            ":stat1" => 4,
            ":stat2" => 4,
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
                                'value="' . $result[$i]["gateway_operator_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["gateway_operator_name"])) .
                                '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["gateway_operator_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["gateway_operator_name"])) .
                                '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["gateway_operator_id"] . '">' . ucfirst(trim($result[$i]["gateway_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["gateway_operator_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchGatewayOperatorTypeDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `gateway_operators_type` WHERE `gateway_operator_type_status_id` = :stat ORDER BY `gateway_operator_type_id`');
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
                                'value="' . $result[$i]["gateway_operator_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_operator_type_type"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["gateway_operator_type_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["gateway_operator_type_type"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["gateway_operator_type_id"] . '">' .
                                ucfirst(trim($result[$i]["gateway_operator_type_type"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchProtocolTypesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litpgemn_' . mt_rand(99, 9999),
            "class" => 'litpgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_protocols` WHERE `portal_protocols_status_id` = :stat ORDER BY `portal_protocols_id`');
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
                                'value="' . $result[$i]["portal_protocols_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_protocols_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_protocols_base_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_protocols_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_protocols_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_protocols_base_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_protocols_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_protocols_name"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_protocols_base_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchRestMethodsDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'litgemn_' . mt_rand(99, 9999),
            "class" => 'litgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `portal_rest_methods` WHERE `portal_rest_methods_status_id` = :stat ORDER BY `portal_rest_methods_id`');
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
                                'value="' . $result[$i]["portal_rest_methods_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_methods_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_rest_methods_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_methods_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $data["html"] .= '<option value="' . $result[$i]["portal_rest_methods_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_rest_methods_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        return $data;
    }
    public function fetchRestTypesDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'littgemn_' . mt_rand(99, 9999),
            "class" => 'littgemncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $html = '';
        $stm = $this->db->prepare('SELECT * FROM `portal_rest_types` WHERE `portal_rest_types_status_id` = :stat ORDER BY `portal_rest_types_id`');
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
                        $html .= '<li style="cursor:pointer">' .
                                '<input type="checkbox" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_rest_types_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_types_name"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $html .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_rest_types_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_types_name"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $html .= '<option value="' . $result[$i]["portal_rest_types_id"] . '">' .
                                ucfirst(trim($result[$i]["portal_rest_types_name"])) .
                                '</option>';
                    }
                    break;
            }
        }
        $data["html"] = (string) $html;
        return (array) $data;
    }
    public function fetchRestParametersDB($listtype = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'littdgemsn_' . mt_rand(99, 9999),
            "class" => 'littgfesmncla_' . mt_rand(99, 9999),
            "status" => 'error'
        );
        $html = '';
        $stm = $this->db->prepare('SELECT * FROM `portal_rest_parameters` WHERE `portal_rest_parameters_status_id` = :stat ORDER BY `portal_rest_parameters_id`');
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
                        $html .= '<li style="cursor:pointer">' .
                                '<input type="checkbox" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_rest_parameters_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_parameters_field"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_rest_parameters_meaning"])) . '</li>';
                    }
                    break;
                case "radio":
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $html .= '<li style="cursor:pointer">' .
                                '<input type="radio" ' .
                                'name="' . $data["id"] . '" ' .
                                'class="' . $data["class"] . '" ' .
                                'id="' . $data["id"] . '_' . $i . '" ' .
                                'value="' . $result[$i]["portal_rest_parameters_id"] . '" />' .
                                '&nbsp;&nbsp;' . ucfirst(trim($result[$i]["portal_rest_parameters_field"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_rest_parameters_meaning"])) . '</li>' .
                                '<li class="divider">&nbsp;</li>';
                    }
                    break;
                default:
                    for ($i = 0; $i < $data["count"]; $i++) {
                        $html .= '<option value="' . $result[$i]["portal_rest_parameters_id"] . '">' . ucfirst(trim($result[$i]["portal_rest_parameters_field"])) .
                                ' ~ ' . ucfirst(trim($result[$i]["portal_rest_parameters_meaning"])) .
                                '</option>';
                    }
                    break;
            }
        }
        $data["html"] = (string) $html;
        return (array) $data;
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
        if (isset($_SESSION["LogId"])) {
            $this->LogId = $_SESSION["LogId"];
            $query = 'UPDATE `user_logs` SET `out_time` = NOW() WHERE `id`= :id2;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id2" => mysql_real_escape_string($this->LogId),
            ));
        } else {
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
                        \'' . ($_SESSION["USERDATA"]["logindata"]["user_pk"]) . '\',
                        default);';
            $stm = $this->db->prepare($query);
            $res = $stm->execute();
            $this->LogId = $this->db->lastInsertId();
            $_SESSION["LogId"] = $this->LogId;
        }
    }
}
?>