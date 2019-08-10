<?php
class dashboardVendor{
    protected $param;
    protected $dashMe;
    protected  $query;
    protected  $jsondata;
    public function __construct($param) {
        $this->param = $param;
        $this->query = array(
            "customers" => 'SELECT COUNT(`id`) FROM `bookinghistory` WHERE `apptdescb_id` IN () AND `status`= ',
            "upcomming" => 'SELECT
                                ap.`id`,
                                ap.`weekofday`,
                                ap.`doctorid`,
                                apd.*
                              FROM `appointment` ap
                                INNER JOIN (SELECT
                                             apd.`appoint_id`,
                                             GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                                             GROUP_CONCAT(apd.`totime`) AS totime,
                                             GROUP_CONCAT(apd.`location`) AS location,
                                             GROUP_CONCAT(apd.`frequency`) AS frequency,
                                             GROUP_CONCAT(apd.`filled`) AS filled,
                                             GROUP_CONCAT(apd.`date`) AS DATE,
                                             GROUP_CONCAT(apd.`id`) AS apptid
                                           FROM `appointment_descb` AS apd
                                           WHERE apd.`status_id` = 4
                                               AND DATE_FORMAT(apd.`date`, "%Y-%m-%d") = DATE_FORMAT(NOW(), "%Y-%m-%d")
                                           GROUP BY (apd.`appoint_id`)
                                           ORDER BY (apd.`id`) ASC) AS apd
                                  ON ap.`id` = apd.`appoint_id`
                              WHERE ap.`status_id` = 4
                                  AND ap.`doctorid` = "'.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].'"
                              ORDER BY (ap.`id`)ASC;',
            "inline" => 'SELECT
                            ap.`id`,
                            ap.`weekofday`,
                            ap.`doctorid`,
                            apd.*
                          FROM `appointment` ap
                            INNER JOIN (SELECT
                                         apd.`appoint_id`,
                                         GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                                         GROUP_CONCAT(apd.`totime`) AS totime,
                                         GROUP_CONCAT(apd.`location`) AS location,
                                         GROUP_CONCAT(apd.`frequency`) AS frequency,
                                         GROUP_CONCAT(apd.`filled`) AS filled,
                                         GROUP_CONCAT(apd.`date`) AS DATE,
                                         GROUP_CONCAT(apd.`id`) AS apptid
                                       FROM `appointment_descb` AS apd
                                       INNER JOIN `bookinghistory` AS book ON book.apptdescb_id = apd.id
                                       WHERE apd.`status_id` = 4
                                           AND DATE_FORMAT(apd.`date`, "%Y-%m-%d") <= DATE_FORMAT(NOW(), "%Y-%m-%d")
                                           AND book.status_id = 35
                                       GROUP BY (apd.`appoint_id`)
                                       ORDER BY (apd.`id`) ASC) AS apd
                              ON ap.`id` = apd.`appoint_id`
                          WHERE ap.`status_id` = 4
                              AND ap.`doctorid` = 2
                          ORDER BY (ap.`id`)ASC;',
            "completed" => 'SELECT
                            ap.`id`,
                            ap.`weekofday`,
                            ap.`doctorid`,
                            apd.*
                          FROM `appointment` ap
                            INNER JOIN (SELECT
                                         apd.`appoint_id`,
                                         GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                                         GROUP_CONCAT(apd.`totime`) AS totime,
                                         GROUP_CONCAT(apd.`location`) AS location,
                                         GROUP_CONCAT(apd.`frequency`) AS frequency,
                                         GROUP_CONCAT(apd.`filled`) AS filled,
                                         GROUP_CONCAT(apd.`date`) AS DATE,
                                         GROUP_CONCAT(apd.`id`) AS apptid
                                       FROM `appointment_descb` AS apd
                                       INNER JOIN `bookinghistory` AS book ON book.apptdescb_id = apd.id
                                       WHERE apd.`status_id` = 4
                                           AND DATE_FORMAT(apd.`date`, "%Y-%m-%d") <= DATE_FORMAT(NOW(), "%Y-%m-%d")
                                           AND book.status_id = 36
                                       GROUP BY (apd.`appoint_id`)
                                       ORDER BY (apd.`id`) ASC) AS apd
                              ON ap.`id` = apd.`appoint_id`
                          WHERE ap.`status_id` = 4
                              AND ap.`doctorid` = 2
                          ORDER BY (ap.`id`)ASC;',
            "todayslot" => 'SELECT
                                ap.`id`,
                                ap.`weekofday`,
                                ap.`doctorid`,
                                apd.*
                              FROM `appointment` ap
                                INNER JOIN (SELECT
                                             apd.`appoint_id`,
                                             GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                                             GROUP_CONCAT(apd.`totime`) AS totime,
                                             GROUP_CONCAT(apd.`location`) AS location,
                                             GROUP_CONCAT(apd.`frequency`) AS frequency,
                                             GROUP_CONCAT(apd.`filled`) AS filled,
                                             GROUP_CONCAT(apd.`date`) AS DATE,
                                             GROUP_CONCAT(apd.`id`) AS apptid
                                           FROM `appointment_descb` AS apd
                                           WHERE apd.`status_id` = 4
                                               AND DATE_FORMAT(apd.`date`, "%Y-%m-%d") = DATE_FORMAT(NOW(), "%Y-%m-%d")
                                           GROUP BY (apd.`appoint_id`)
                                           ORDER BY (apd.`id`) ASC) AS apd
                                  ON ap.`id` = apd.`appoint_id`
                              WHERE ap.`status_id` = 4
                                  AND ap.`doctorid` = "'.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].'"
                              ORDER BY (ap.`id`)ASC;'
        ); 
        $this->$jsondata = array(
            "customers" => 0,
            "customersdata" => 'No Data Found.',
            "customershtml" => '<stong>0 Customers</strong>',
            "upcomming" => 0,
            "upcommingdata" => 'No Data Found.',
            "upcomminghtml" => '<stong>0 Upcoming Appointments.</strong>',
            "inline" => 0,
            "inlinedata" => 'No Data Found.',
            "inlinehtml" => '<stong>0 In Line Appointments.</strong>',
            "completed" => 0,
            "completeddata" => 'No Data Found.',
            "completedhtml" => '<stong>0 Completed Appointments.</strong>',
            "todayslot" => 0,
            "todayslotdata" => 'No Data Found.',
            "todayslothtml" => '<stong>You have not schedule any appointments today.</strong>'
        ); 
    }
    public function getNoCustomers() {
        $param = $this->param;
    }
    public function getUpcomming() {
        $param = $this->param;
    }
    public function getInline() {
        $param = $this->param;
    }
    public function getCompleted() {
        $param = $this->param;
    }
    public function getTodaysSolts() {
        $param = $this->param;
    }
    public function dashMe() {
        $param = $this->param;
    }
}

?>