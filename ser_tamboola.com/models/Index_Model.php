<?php
class Index_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
    public function updateTrafficLT() {
        $this->setIPInfo();
        if (isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
            $query = 'INSERT INTO `tamboola_traffic` (`id`,
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
                    `isp`)  VALUES ('
                    . ' :id1,
                        :id2,
                        :id3,
                        :id4,
                        :id5,
                        :id6,
                        :id7,
                        :id8,
                        :id9,
                        :id10,
                        :id11,
                        :id12,
                        :id13,
                        :id14)';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => ($_SESSION["IP_INFO"]["query"]),
                ":id3" => ($_SERVER['SERVER_ADDR']),
                ":id4" => ($_SESSION["IP_INFO"]["city"]),
                ":id5" => ($_SESSION["IP_INFO"]["zip"]),
                ":id6" => ($_SESSION["IP_INFO"]["regionName"]),
                ":id7" => ($_SESSION["IP_INFO"]["region"]),
                ":id8" => ($_SESSION["IP_INFO"]["country"]),
                ":id9" => ($_SESSION["IP_INFO"]["countryCode"]),
                ":id10" => ($_SESSION["IP_INFO"]["lat"]),
                ":id11" => ($_SESSION["IP_INFO"]["lon"]),
                ":id12" => ($_SESSION["IP_INFO"]["timezone"]),
                ":id13" => ($_SESSION["IP_INFO"]["org"]),
                ":id14" => ($_SESSION["IP_INFO"]["isp"])
            ));
        }
    }
}
?>