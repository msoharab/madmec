<?php

class dashboardUser {

    protected $param;
    protected $query;
    protected $appointmentQuery;
    protected $jsondata;
    protected $userid;
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    public function __construct($param = false) {
        $this->param = $param;
        if (isset($_SESSION["USER_LOGIN_DATA"]["USER_ID"])) {
            $this->userid = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        } elseif (is_array($param) && isset($param["userid"]) && $param["userid"] > 0) {
            $this->userid = $param["userid"];
        } else {
            $this->userid = 0;
        }
        $this->query = array(
            "customers" => 'SELECT COUNT(`id`) FROM `user_vehicle` WHERE `user_id` = "'.$this->userid.'" AND `status_id` = 4;',
            "upcomming" => 'SELECT COUNT(`id`) FROM `bookinghistory` WHERE `patientid` = "'.$this->userid.'" AND `status_id` = 4;',
            "inline" => 'SELECT COUNT(`id`) FROM `bookinghistory` WHERE `patientid` = "'.$this->userid.'" AND `status_id` = 35;',
            "completed" => 'SELECT COUNT(DISTINCT(`preferred_service_center`)) FROM `user_vehicle` WHERE `user_id` = "'.$this->userid.'" AND `status_id` = 4;',
            "todayslot" => 'SELECT
                            CONCAT(vmk.name," - ", vm.name ) AS model,
                            up.user_name AS vendor,
                            vh.*
                          FROM `user_vehicle` AS vh
                            INNER JOIN `vehicle_model` AS vm
                              ON vm.id = vh.vehicle_model
                            INNER JOIN `vehicle_make` AS vmk
                              ON vmk.id = vm.vehicle_make_id
                            INNER JOIN `user_profile` AS up
                              ON up.id = vh.preferred_service_center
                          WHERE `user_id` = "'.$this->userid.'"
                              AND vh.`status_id` = 4
                              AND vm.`status_id` = 4
                              AND vmk.`status_id` = 4
                              AND up.`status` = 4
                          ORDER BY (CONCAT(vmk.name," - ", vm.name));'
        );
        $this->jsondata = array(
            "customers" => 0,
            "customersdata" => 'No Data Found.',
            "customershtml" => '<stong>0 Customers.</strong>',
            "upcomming" => 0,
            "upcommingdata" => array(),
            "upcomminghtml" => '<stong>0 Vendors.</strong>',
            "inline" => 0,
            "inlinedata" => array(),
            "inlinehtml" => '<stong>0 Vehicles.</strong>',
            "completed" => 0,
            "completeddata" => array(),
            "completedhtml" => '<stong>0 Vehicles Make.</strong>',
            "todayslot" => 0,
            "todayslotdata" => array(),
            "todayslothtml" => '<tr><td colspan="5"><stong>You have not added any vendors.</strong></td></tr>'
        );
    }


    public function getNoCustomers() {
        $param = $this->param;
        $res1 = executeQuery($this->query["customers"]);
        if ($res1) {
            if (mysql_num_rows($res1) > 0) {
                $this->jsondata["customers"] = mysql_result($res1, 0)-1;
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
        $res2 = executeQuery($this->query["upcomming"]);
        if ($res2) {
            if (mysql_num_rows($res2) > 0) {
                $this->jsondata["upcomming"] = mysql_result($res2, 0);
                $this->jsondata["upcommingdata"] = mysql_fetch_assoc($res2);
                $this->jsondata["upcomminghtml"] = '<strong>' . mysql_result($res2, 0) . '</strong>';
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
        $res3 = executeQuery($this->query["inline"]);
        if ($res3) {
            if (mysql_num_rows($res3) > 0) {
                $this->jsondata["inline"] = mysql_result($res3, 0);
                $this->jsondata["inlinedata"] = mysql_fetch_assoc($res3);
                $this->jsondata["inlinehtml"] = '<strong>' . mysql_result($res3, 0) . '</strong>';
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
        $res4 = executeQuery($this->query["completed"]);
        if ($res4) {
            if (mysql_num_rows($res4) > 0) {
                $this->jsondata["completed"] = mysql_result($res4, 0);
                $this->jsondata["completeddata"] = mysql_fetch_assoc($res4);
                $this->jsondata["completedhtml"] = '<strong>' . mysql_result($res4, 0) . '</strong>';
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
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' .$this->jsondata["todayslotdata"][$i]["id"] .'">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["model"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vendor"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vehicle_nickname"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vehicle_number"] . '</td>
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
        $res2 = executeQuery($this->query["upcomming"]);
        $res3 = executeQuery($this->query["inline"]);
        $res4 = executeQuery($this->query["completed"]);
        $res5 = executeQuery($this->query["todayslot"]);
        if ($res1) {
            if (mysql_num_rows($res1) > 0) {
                $this->jsondata["customers"] = mysql_result($res1, 0)-1;
                $this->jsondata["customersdata"] = mysql_fetch_assoc($res1);
                $this->jsondata["customershtml"] = '<strong>' . mysql_result($res1, 0) . '</strong>';
            }
        }
        if ($res2) {
            if (mysql_num_rows($res2) > 0) {
                $this->jsondata["upcomming"] = mysql_result($res2, 0);
                $this->jsondata["upcommingdata"] = mysql_fetch_assoc($res2);
                $this->jsondata["upcomminghtml"] = '<strong>' . mysql_result($res2, 0) . '</strong>';
            }
        }
        if ($res3) {
            if (mysql_num_rows($res3) > 0) {
                $this->jsondata["inline"] = mysql_result($res3, 0);
                $this->jsondata["inlinedata"] = mysql_fetch_assoc($res3);
                $this->jsondata["inlinehtml"] = '<strong>' . mysql_result($res3, 0) . '</strong>';
            }
        }
        if ($res4) {
            if (mysql_num_rows($res4) > 0) {
                $this->jsondata["completed"] = mysql_result($res4, 0);
                $this->jsondata["completeddata"] = mysql_fetch_assoc($res4);
                $this->jsondata["completedhtml"] = '<strong>' . mysql_result($res4, 0) . '</strong>';
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
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' .$this->jsondata["todayslotdata"][$i]["id"] .'">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["model"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vendor"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vehicle_nickname"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["vehicle_number"] . '</td>
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