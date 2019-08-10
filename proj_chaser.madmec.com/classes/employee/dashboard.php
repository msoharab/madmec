<?php
class empDashboard {

    protected $param, $query, $appointmentQuery, $jsondata, $adminid, $lastWeek;
    private $order = array("\r\n", "\n", "\r", "\t"), $userid;
    private $replace = '';

    public function __construct($param = false) {
        $this->param = $param;
        $this->lastWeek = getLastWeekDates();
        if (isset($_SESSION["USER_LOGIN_DATA"]["USER_ID"])) {
            $this->userid = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        } elseif (is_array($param) && isset($param["$adminid"]) && $param["$adminid"] > 0) {
            $this->userid = $param["$adminid"];
        } else {
            $this->userid = 0;
        }
        $this->query = array(
            "customers" => 'Return IP Address.',
            "upcomming" => 'SELECT COUNT(`id`) FROM `projects_activity` WHERE `created_by` = "'. $this->userid .'" AND `status_id` = 4 GROUP BY (`project_id`);',
            "inline" => 'SELECT COUNT(`id`) FROM `projects_activity` WHERE `created_by` = "'. $this->userid .'" AND `status_id` = 4;',
            "completed" => 'SELECT
                                FLOOR((SUM(engageData.seconds) / 60) / 60) AS TotalWorkingHrs
                        FROM (SELECT
                                en.id,
                                en.project_activity_id,
                                ((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60) AS hrsDEC,
                                FLOOR(((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60)) AS hrsNTR,
                                (TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) AS minDEC,
                                FLOOR((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60)) AS minNTR,
                                TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) AS seconds,
                                TIMEDIFF(en.out_time, en.in_time) AS timdiff
                              FROM engage AS en
                              WHERE en.status_id = 16
                              AND en.created_by = "'. $this->userid .'"
                              AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.in_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                              AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.out_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                                  AND (en.out_time != NULL
                                        OR en.out_time IS NOT NULL)
                              GROUP BY (en.project_activity_id)) AS engageData;',
            "todayslot" => 'SELECT up.id,up.emp_id,up.user_name,CONCAT(hr.TothrsNTR, " Hours") AS prd_hrs FROM user_profile AS up
                            INNER JOIN (
                            SELECT
                                    en.id,
                                    en.created_by,
                                    en.project_activity_id,
                                    (SELECT SUM(FLOOR(((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60))) FROM engage WHERE created_by = en.created_by GROUP BY (en.created_by)) AS TothrsNTR,
                                    ((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60) AS hrsDEC,
                                    FLOOR(((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60)) AS hrsNTR,
                                    (TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) AS minDEC,
                                    FLOOR((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60)) AS minNTR,
                                    TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) AS seconds,
                                    TIMEDIFF(en.out_time, en.in_time) AS timdiff
                                  FROM engage AS en
                                  WHERE en.status_id = 16
                                      AND en.created_by = "'. $this->userid .'"
                                      AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.in_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                                      AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.out_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                                      AND (en.out_time != NULL
                                            OR en.out_time IS NOT NULL)
                                  GROUP BY (en.created_by)
                                  ) AS hr ON hr.created_by = up.id
                                 WHERE up.status = 4;',
            "Graph" => 'SELECT
                        pr.id,
                        pr.project_name,
                        pr.created_at,
                        SUM(engageData.hrsNTR) AS TotalWorkingHrs
                      FROM (SELECT
                              en.id,
                              en.created_by,
                              en.project_activity_id,
                              pa.project_id,
                              ((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60) AS hrsDEC,
                              FLOOR(((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) / 60)) AS hrsNTR,
                              (TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60) AS minDEC,
                              FLOOR((TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) / 60)) AS minNTR,
                              TIME_TO_SEC(TIMEDIFF(en.out_time, en.in_time)) AS seconds,
                              TIMEDIFF(en.out_time, en.in_time) AS timdiff
                            FROM engage AS en
                              INNER JOIN projects_activity AS pa
                                ON pa.id = en.project_activity_id AND pa.status_id = 4
                            WHERE en.status_id = 16
                                 AND en.created_by = "'. $this->userid .'"
                                AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.in_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                                AND DATE_FORMAT("' . $this->lastWeek["start"] . '","%y-%m-%d %h:%i:%s") <= DATE_FORMAT(en.out_time,"%y-%m-%d %h:%i:%s") <= DATE_FORMAT("' . $this->lastWeek["end"] . '","%y-%m-%d %h:%i:%s")
                                AND (en.out_time != NULL
                                      OR en.out_time IS NOT NULL)
                            ) AS engageData
                        INNER JOIN projects AS pr
                          ON pr.id = engageData.project_id
                        WHERE pr.status_id = 4
                          GROUP BY (engageData.project_id);'
        );
        $this->jsondata = array(
            "customers" => 0,
            "customersdata" => 'No Data Found.',
            "customershtml" => '<stong>0 Employees.</strong>',
            "upcomming" => 0,
            "upcommingdata" => array(),
            "upcomminghtml" => '<stong>0 Projects.</strong>',
            "inline" => 0,
            "inlinedata" => array(),
            "inlinehtml" => '<stong>0 Active Employees.</strong>',
            "completed" => 0,
            "completeddata" => array(),
            "completedhtml" => '<stong>0 Last Week Productive Hrs.</strong>',
            "todayslot" => 0,
            "todayslotdata" => array(),
            "todayslothtml" => '<tr><td colspan="4"><stong>Empty data.</strong></td></tr>',
            "graph" => 0,
            "graphdata" => array(),
            "graphhtml" => ''
        );
    }
    public function getNoCustomers() {
        $param = $this->param;
        //$res1 = executeQuery($this->query["customers"]);
        $res1 = getClientIP();
        if ($res1) {
            $this->jsondata["customers"] = $res1;
            $this->jsondata["customersdata"] = $res1;
            $this->jsondata["customershtml"] = '<strong>' . $res1 . '</strong>';
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
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' . $this->jsondata["todayslotdata"][$i]["id"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["emp_id"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["prd_hrs"] . '</td>
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
                "html" => str_replace($this->order, $this->replace, $this->jsondata["todayslothtml"])
            );
        }
    }
    public function getLastWeekProjects() {
        $param = $this->param;
        $res6 = executeQuery($this->query["Graph"]);
        if ($res6) {
            if (mysql_num_rows($res6) > 0) {
                $this->jsondata["graph"] = mysql_num_rows($res6);
                while ($row = mysql_fetch_assoc($res6)) {
                    array_push($this->jsondata["graphdata"], $row);
                }
                $this->jsondata["graphhtml"] = array();
                for ($i = 0; $i < sizeof($this->jsondata["graphdata"]); $i++) {
                    array_push($this->jsondata["graphhtml"], array(
                        "y" => $this->jsondata["graphdata"][$i]["project_name"],
                        "a" => $this->jsondata["graphdata"][$i]["TotalWorkingHrs"]
                    ));
                }
            }
        }
        if ($param == 'data') {
            return array(
                "count" => $this->jsondata["graph"],
                "data" => (array) $this->jsondata["graphhtml"]
            );
        } else {
            return array(
                "count" => $this->jsondata["graph"],
                "data" => (array) $this->jsondata["graphhtml"]
            );
        }
    }
    public function dashMe() {
        $param = $this->param;
        $res1 = getClientIP();
        $res2 = executeQuery($this->query["upcomming"]);
        $res3 = executeQuery($this->query["inline"]);
        $res4 = executeQuery($this->query["completed"]);
        $res5 = executeQuery($this->query["todayslot"]);
        $res6 = executeQuery($this->query["Graph"]);
        if ($res1) {
            $this->jsondata["customers"] = $res1;
            $this->jsondata["customersdata"] = $res1;
            $this->jsondata["customershtml"] = '<strong>' . $res1 . '</strong>';
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
                    $this->jsondata["todayslothtml"] .= '<tr id="row-' . $this->jsondata["todayslotdata"][$i]["id"] . '">
                        <td>' . ($i + 1) . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["emp_id"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["user_name"] . '</td>
                        <td>' . $this->jsondata["todayslotdata"][$i]["prd_hrs"] . '</td>
                        </tr>';
                }
            }
        }
        if ($res6) {
            if (mysql_num_rows($res6) > 0) {
                $this->jsondata["graph"] = mysql_num_rows($res6);
                while ($row = mysql_fetch_assoc($res6)) {
                    array_push($this->jsondata["graphdata"], $row);
                }
                $this->jsondata["graphhtml"] = array();
                for ($i = 0; $i < sizeof($this->jsondata["graphdata"]); $i++) {
                    array_push($this->jsondata["graphhtml"], array(
                        "y" => $this->jsondata["graphdata"][$i]["project_name"],
                        "a" => $this->jsondata["graphdata"][$i]["TotalWorkingHrs"]
                    ));
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
            "shtml" => str_replace($this->order, $this->replace, $this->jsondata["todayslothtml"]),
            "gcount" => $this->jsondata["graph"],
            "gdata" => (array) $this->jsondata["graphhtml"]
        );
    }
}
?>