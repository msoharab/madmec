<?php

class dashboardVendor {

    protected $param;
    protected $query;
    protected $appointmentQuery;
    protected $jsondata;
    protected $vendorid;
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    public function __construct($param = false) {
        $this->param = $param;
        if (isset($_SESSION["USER_LOGIN_DATA"]["USER_ID"])) {
            $this->vendorid = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        } elseif (is_array($param) && isset($param["vendorid"]) && $param["vendorid"] > 0) {
            $this->vendorid = $param["vendorid"];
        } else {
            $this->vendorid = 0;
        }
        $this->query = array(
            "customers" => 'SELECT
                                COUNT(DISTINCT(apd.`user_id`))
                               FROM `appointment` ap
                                 LEFT JOIN (SELECT
                                                apd.`appoint_id`,
                                               book.`patientid` AS user_id
                                             FROM `appointment_descb` AS apd
                                               INNER JOIN `bookinghistory` AS book
                                                 ON book.apptdescb_id = apd.`id`
                                             WHERE apd.`status_id` = 4
                                                 AND book.status_id = 4
                                             ) AS apd
                                   ON ap.`id` = apd.`appoint_id`
                               WHERE ap.`status_id` = 4
                                   AND ap.`doctorid` = "' . $this->vendorid . '"
                                   AND ap.`status_id` = 4
                               ORDER BY (ap.`id`)ASC;',
            "upcomming" => 4,
            "inline" => 35,
            "completed" => 36,
            "todayslot" => 'SELECT
                            ap.`id`,
                            ap.`weekofday`,
                            ap.`doctorid` AS vendor_id,
                            apd.*
                          FROM `appointment` ap
                            INNER JOIN (SELECT
                                        apd.`id`         AS apptid,
                                        apd.`appoint_id`,
                                        CONCAT(apd.`date`," ",apd.`fromtime`) AS fromtime,
                                        CONCAT(apd.`date`," ",apd.`totime`) AS totime,
                                        apd.`date`       AS DATE,
                                        apd.`location`,
                                        apd.`frequency`,
                                        apd.`filled`
                                  FROM `appointment_descb` AS apd
                                  WHERE apd.`status_id` = 4
                                          AND DATE_FORMAT(apd.`date`, "%Y-%m-%d") = DATE_FORMAT(NOW(), "%Y-%m-%d")
                                  ORDER BY (apd.`id`)ASC) AS apd
                                  ON ap.`id` = apd.`appoint_id`
                                  AND ap.`status_id` = 4
                          WHERE ap.`status_id` = 4
                                  AND ap.`doctorid` = "' . $this->vendorid . '"
                          ORDER BY (ap.`id`)ASC;'
        );
        $this->jsondata = array(
            "customers" => 0,
            "customersdata" => 'No Data Found.',
            "customershtml" => '<stong>0 Customers.</strong>',
            "upcomming" => 0,
            "upcommingdata" => array(),
            "upcomminghtml" => '<stong>0 Upcoming Appointments.</strong>',
            "inline" => 0,
            "inlinedata" => array(),
            "inlinehtml" => '<stong>0 In Line Appointments.</strong>',
            "completed" => 0,
            "completeddata" => array(),
            "completedhtml" => '<stong>0 Completed Appointments.</strong>',
            "todayslot" => 0,
            "todayslotdata" => array(),
            "todayslothtml" => '<tr><td colspan="5"><stong>You have not schedule any appointments today.</strong></td></tr>'
        );
    }

    public function setAppointmentQuery($param) {
        $this->appointmentQuery = 'SELECT
            ap.`id`,
            ap.`weekofday`,
            ap.`doctorid`  AS vendor_id,
            apd.*
          FROM `appointment` ap
            INNER JOIN (SELECT
                          apd.`appoint_id`,
                          apd.`id`            AS apptid,
                          book.`apptdescb_id` AS book_apptid,
                          book.`id`           AS bookid,
                          CONCAT(apd.`date`," ",apd.`fromtime`) AS fromtime,
                          CONCAT(apd.`date`," ",apd.`totime`) AS totime,
                          book.`bookdetails`  AS bookdate,
                          apd.`date`          AS DATE,
                          book.`date`         AS book_apptDATE,
                          apd.`location`,
                          apd.`frequency`,
                          apd.`filled`,
                          book.`patientid`    AS user_id,
                          book.`vehicle_id`,
                          book.`servicetype`,
                          book.`bookservice`,
                          up.`user_name`,
                          vm.`name`,
                          vh.`vehicle_number`
                        FROM `appointment_descb` AS apd
                          INNER JOIN `bookinghistory` AS book
                            ON book.apptdescb_id = apd.`id`
                          INNER JOIN `user_profile` AS up
                            ON up.`id` = book.`patientid`
                          INNER JOIN `user_vehicle` AS vh
                            ON up.`id` = vh.`user_id`
                              AND book.`vehicle_id` = vh.`id`
                          INNER JOIN `vehicle_model` AS vm
                            ON vh.`vehicle_model` = vm.`id`
                        WHERE apd.`status_id` = 4
                            AND DATE_FORMAT(CONCAT(apd.`date`," ",apd.`fromtime`), "%Y-%m-%d %H:%m:%s") >= DATE_FORMAT(NOW(), "%Y-%m-%d %H:%m:%s")
                            AND book.status_id = "' . $param . '"
                            AND vh.`status_id` = 4
                            AND vm.`status_id` = 4
                            AND up.`status` = 4
                        ORDER BY (apd.`id`)ASC) AS apd
              ON ap.`id` = apd.`appoint_id`
          WHERE ap.`status_id` = 4
              AND ap.`doctorid` = "' . $this->vendorid . '"
          ORDER BY (ap.`id`)ASC;';
        return $this->appointmentQuery;
    }

    public function getNoCustomers() {
        $param = $this->param;
        $res1 = executeQuery($this->query["customers"]);
        if ($res1) {
            if (mysql_num_rows($res1) > 0) {
                $this->jsondata["customers"] = mysql_result($res1, 0);
                $this->jsondata["customersdata"] = mysql_fetch_assoc($res1);
                $this->jsondata["customershtml"] = '<strong>' . mysql_result($res1, 0) . '</strong>';
            }
        }
        return array(
            "count" => $this->jsondata["customers"],
            "html" => str_replace($this->order, $this->replace, $this->jsondata["customershtml"])
        );
    }

    public function getUpcomming() {
        $param = $this->param;
        $res2 = executeQuery($this->setAppointmentQuery($this->query["upcomming"]));
        if ($res2) {
            if (mysql_num_rows($res2) > 0) {
                $this->jsondata["upcomming"] = mysql_num_rows($res2);
                while ($row = mysql_fetch_assoc($res2)) {
                    array_push($this->jsondata["upcommingdata"], $row);
                }
                $this->jsondata["upcomminghtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["upcommingdata"]); $i++) {
                    $this->jsondata["upcomminghtml"] .= '<tr id="row-' .
                            $this->jsondata["upcommingdata"][$i]["id"] . '_' .
                            $this->jsondata["upcommingdata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["upcommingdata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($param == 'data') {
            return array(
                "count" => $this->jsondata["upcomming"],
                "data" => (array) $this->jsondata["upcommingdata"]
            );
        } else {
            return array(
                "count" => $this->jsondata["upcomming"],
                "html" => str_replace($this->order, $this->replace, $this->jsondata["upcomminghtml"])
            );
        }
    }

    public function getInline() {
        $param = $this->param;
        $res3 = executeQuery($this->setAppointmentQuery($this->query["inline"]));
        if ($res3) {
            if (mysql_num_rows($res3) > 0) {
                $this->jsondata["inline"] = mysql_num_rows($res3);
                while ($row = mysql_fetch_assoc($res3)) {
                    array_push($this->jsondata["inlinedata"], $row);
                }
                $this->jsondata["inlinehtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["inlinedata"]); $i++) {
                    $this->jsondata["inlinehtml"] .= '<tr id="row-' .
                            $this->jsondata["inlinedata"][$i]["id"] . '_' .
                            $this->jsondata["inlinedata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["inlinedata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($param == 'data') {
            return array(
                "count" => $this->jsondata["inline"],
                "data" => (array) $this->jsondata["inlinedata"]
            );
        } else {
            return array(
                "count" => $this->jsondata["inline"],
                "html" => str_replace($this->order, $this->replace, $this->jsondata["inlinehtml"])
            );
        }
    }

    public function getCompleted() {
        $param = $this->param;
        $res4 = executeQuery($this->setAppointmentQuery($this->query["completed"]));
        if ($res4) {
            if (mysql_num_rows($res4) > 0) {
                $this->jsondata["completed"] = mysql_num_rows($res4);
                while ($row = mysql_fetch_assoc($res4)) {
                    array_push($this->jsondata["completeddata"], $row);
                }
                $this->jsondata["completedhtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["completeddata"]); $i++) {
                    $this->jsondata["completedhtml"] .= '<tr id="row-' .
                            $this->jsondata["completeddata"][$i]["id"] . '_' .
                            $this->jsondata["completeddata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["completeddata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($param == 'data') {
            return array(
                "count" => $this->jsondata["completed"],
                "data" => (array) $this->jsondata["completeddata"]
            );
        } else {
            return array(
                "count" => $this->jsondata["completed"],
                "html" => str_replace($this->order, $this->replace, $this->jsondata["completedhtml"])
            );
        }
    }

    public function getTodaysSolts() {
        $param = $this->param;
        $res5 = executeQuery($this->query["todayslot"]);
        if ($res5) {
            if (mysql_num_rows($res5) > 0) {
                $this->jsondata["todayslot"] = mysql_num_rows($res5);
                while ($row = mysql_fetch_assoc($res5)) {
                    array_push($this->jsondata["todayslotdata"], $row);
                }
                $this->jsondata["todayslothtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["todayslotdata"]); $i++) {
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' .
                            $this->jsondata["todayslotdata"][$i]["id"] . '_' .
                            $this->jsondata["todayslotdata"][$i]["apptid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . date("g:i a", strtotime($this->jsondata["todayslotdata"][$i]["fromtime"])) . '</td>
                        <td>' . date("g:i a", strtotime($this->jsondata["todayslotdata"][$i]["totime"])) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["location"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["filled"] . '</td>
                        </tr>';
                }
            }
        }
        if ($param == 'data') {
            return array(
                "count" => $this->jsondata["todayslot"],
                "data" => (array) $this->jsondata["todayslotdata"]
            );
        } else {
            return array(
                "count" => $this->jsondata["todayslot"],
                "html" => str_replace($this->order, $this->replace, $this->jsondata["completedhtml"])
            );
        }
    }

    public function dashMe() {
        $param = $this->param;
        $res1 = executeQuery($this->query["customers"]);
        $res2 = executeQuery($this->setAppointmentQuery($this->query["upcomming"]));
        $res3 = executeQuery($this->setAppointmentQuery($this->query["inline"]));
        $res4 = executeQuery($this->setAppointmentQuery($this->query["completed"]));
        $res5 = executeQuery($this->query["todayslot"]);
        if ($res1) {
            if (mysql_num_rows($res1) > 0) {
                $this->jsondata["customers"] = mysql_result($res1, 0);
                $this->jsondata["customersdata"] = mysql_fetch_assoc($res1);
                $this->jsondata["customershtml"] = '<strong>' . mysql_result($res1, 0) . '</strong>';
            }
        }
        if ($res2) {
            if (mysql_num_rows($res2) > 0) {
                $this->jsondata["upcomming"] = mysql_num_rows($res2);
                while ($row = mysql_fetch_assoc($res2)) {
                    array_push($this->jsondata["upcommingdata"], $row);
                }
                $this->jsondata["upcomminghtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["upcommingdata"]); $i++) {
                    $this->jsondata["upcomminghtml"] .= '<tr id="row-' .
                            $this->jsondata["upcommingdata"][$i]["id"] . '_' .
                            $this->jsondata["upcommingdata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["upcommingdata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["upcommingdata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($res3) {
            if (mysql_num_rows($res3) > 0) {
                $this->jsondata["inline"] = mysql_num_rows($res3);
                while ($row = mysql_fetch_assoc($res3)) {
                    array_push($this->jsondata["inlinedata"], $row);
                }
                $this->jsondata["inlinehtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["inlinedata"]); $i++) {
                    $this->jsondata["inlinehtml"] .= '<tr id="row-' .
                            $this->jsondata["inlinedata"][$i]["id"] . '_' .
                            $this->jsondata["inlinedata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["inlinedata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["inlinedata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($res4) {
            if (mysql_num_rows($res4) > 0) {
                $this->jsondata["completed"] = mysql_num_rows($res4);
                while ($row = mysql_fetch_assoc($res4)) {
                    array_push($this->jsondata["completeddata"], $row);
                }
                $this->jsondata["completedhtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["completeddata"]); $i++) {
                    $this->jsondata["completedhtml"] .= '<tr id="row-' .
                            $this->jsondata["completeddata"][$i]["id"] . '_' .
                            $this->jsondata["completeddata"][$i]["book_apptid"] . '_' .
                            $this->jsondata["completeddata"][$i]["bookid"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["vehicle_number"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["name"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["fromtime"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["totime"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["bookdate"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["servicetype"] . '</td>
                        <td>' . $this->jsondata["completeddata"][$i]["bookservice"] . '</td>
                        </tr>';
                }
            }
        }
        if ($res5) {
            if (mysql_num_rows($res5) > 0) {
                $this->jsondata["todayslot"] = mysql_num_rows($res5);
                while ($row = mysql_fetch_assoc($res5)) {
                    array_push($this->jsondata["todayslotdata"], $row);
                }
                $this->jsondata["todayslothtml"] = '';
                for ($i = 0; $i < sizeof($this->jsondata["todayslotdata"]); $i++) {
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' .
                            $this->jsondata["todayslotdata"][$i]["id"] . '_' .
                            $this->jsondata["todayslotdata"][$i]["apptid"] . '
                            ">
                        <td>' . ($i + 1) . '</td>
                        <td>' . date("g:i a", strtotime($this->jsondata["todayslotdata"][$i]["fromtime"])) . '</td>
                        <td>' . date("g:i a", strtotime($this->jsondata["todayslotdata"][$i]["totime"])) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["location"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["filled"] . '</td>
                        </tr>';
                }
            }
        }
        return array(
            "ccount" => $this->jsondata["customers"],
            "chtml" => str_replace($this->order, $this->replace, $this->jsondata["customershtml"]),
            "ucount" => $this->jsondata["upcomming"],
            "uhtml" => str_replace($this->order, $this->replace, $this->jsondata["upcomminghtml"]),
            "icount" => $this->jsondata["inline"],
            "ihtml" => str_replace($this->order, $this->replace, $this->jsondata["inlinehtml"]),
            "comcount" => $this->jsondata["completed"],
            "comhtml" => str_replace($this->order, $this->replace, $this->jsondata["completedhtml"]),
            "scount" => $this->jsondata["todayslot"],
            "shtml" => str_replace($this->order, $this->replace, $this->jsondata["todayslothtml"])
        );
    }

}

?>