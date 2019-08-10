<?php

class Index_Model extends BaseModel {

    private $para;

    function __construct($para = false) {
        parent::__construct();

        $this->para = $para;
    }

    public function updateTrafficLT() {
        $this->setIPInfo();
        if (isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
            $query = 'INSERT INTO `portal_traffic` (`portal_traffic_id`,
			`portal_traffic_ip`,
			`portal_traffic_host`,
			`portal_traffic_city`,
			`portal_traffic_zipcode`,
			`portal_traffic_province`,
			`portal_traffic_province_code`,
			`portal_traffic_country`,
			`portal_traffic_country_code`,
			`portal_traffic_latitude`,
			`portal_traffic_longitude`,
			`portal_traffic_timezone`,
			`portal_traffic_organization`,
			`portal_traffic_isp`)  VALUES ('
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