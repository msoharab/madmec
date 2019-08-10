<?php

class followup {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function fetchfollowups() {
        $header = '<div class="panel panel-warning">
                                <div class="panel-heading"> <strong>Follow up</strong>&nbsp; </div>
                                ';
        $tableheader = '<div class="panel-body"> <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="followupduescurr-example">';
        $tableheader1 = '<div class="panel-body"> <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="followupduespen-example">';
        $tableheader2 = '<div class="panel-body"> <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="followupduesexp-example">';
        $tablehead = ' <thead>
                          <tr>
                          <th>#</th>
                          <th>Project Names</th>
                          <th>Client Name</th>
                          <th>Total Amount</th>
                          <th>Due</th>
                          <th>Due Date</th>
                          </tr>
                          </thead>
                          <tbody>';
        $footer = '</tbody></table></div></div></div>';
        $followups = array();
        $followups1 = array();
        $followups2 = array();
        $jsonfollow = array();
        $currentfollow = '';
        $pendingfollow = '';
        $expiredfollow = '';
        $query = 'SELECT fu.`followup_dates`, p.`name`,up.`user_name`,qt.net_total AS grd_total,du.`due_amount`
                    FROM `follow_up` fu,`project` p,`requirements` r,`user_profile` up,`due` du, quotation qt
                    WHERE
                    fu.`incoming_proj_id`=p.id AND r.`id`=p.`requi_id`
                    AND r.`from_pk`=up.`id` AND du.`id`=fu.`due_id` AND qt.requi_id=r.id
                    AND fu.`followup_dates` > CURRENT_DATE AND fu.`status_id`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $followups[] = $row;
            }
        }
        if (is_array($followups))
            $num = sizeof($followups);
        if ($num) {
            $j = 1;
            for ($i = 0; $i < $num; $i++) {
                $pendingfollow .= '<tr><th>' . $j . '</th><th>' . $followups[$i]["name"] . '</th><th>' . $followups[$i]["user_name"] . '</th>'
                        . '<th>' . $followups[$i]["grd_total"] . '</th><th>' . $followups[$i]["due_amount"] . '</th><th>' . $followups[$i]["followup_dates"] . '</th></tr>';
                $j++;
            }
        } else {
            $pendingfollow = '';
        }
        $query1 = 'SELECT fu.`followup_dates`, p.`name`,up.`user_name`,qt.net_total AS grd_total,du.`due_amount`
                    FROM `follow_up` fu,`project` p,`requirements` r,`user_profile` up,`due` du, quotation qt
                    WHERE
                    fu.`incoming_proj_id`=p.id AND r.`id`=p.`requi_id`
                    AND r.`from_pk`=up.`id` AND du.`id`=fu.`due_id` AND qt.requi_id=r.id
                    AND fu.`followup_dates` = CURRENT_DATE AND fu.`status_id`=4';

        $result1 = executeQuery($query1);
        if (mysql_num_rows($result1) > 0) {
            while ($row = mysql_fetch_assoc($result1)) {
                $followups1[] = $row;
            }
        }
        if (is_array($followups1))
            $num = sizeof($followups1);
        if ($num) {
            $j = 1;
            for ($i = 0; $i < $num; $i++) {
                $currentfollow .= '<tr><th>' . $j . '</th><th>' . $followups1[$i]["name"] . '</th><th>' . $followups1[$i]["user_name"] . '</th>'
                        . '<th>' . $followups1[$i]["grd_total"] . '</th><th>' . $followups1[$i]["due_amount"] . '</th><th>' . $followups1[$i]["followup_dates"] . '</th></tr>';
                $j++;
            }
        } else {
            $currentfollow = '';
        }
        $query2 = 'SELECT fu.`followup_dates`, p.`name`,up.`user_name`,qt.net_total AS grd_total,du.`due_amount`
                    FROM `follow_up` fu,`project` p,`requirements` r,`user_profile` up,`due` du, quotation qt
                    WHERE
                    fu.`incoming_proj_id`=p.id AND r.`id`=p.`requi_id`
                    AND r.`from_pk`=up.`id` AND du.`id`=fu.`due_id` AND qt.requi_id=r.id
                    AND fu.`followup_dates` < CURRENT_DATE AND fu.`status_id`=4';
        $result2 = executeQuery($query2);
        if (mysql_num_rows($result2) > 0) {
            while ($row = mysql_fetch_assoc($result2)) {
                $followups2[] = $row;
            }
        }
        if (is_array($followups2))
            $num = sizeof($followups2);
        if ($num) {
            $j = 1;
            for ($i = 0; $i < $num; $i++) {
                $expiredfollow .= '<tr><th>' . $j . '</th><th>' . $followups2[$i]["name"] . '</th><th>' . $followups2[$i]["user_name"] . '</th>'
                        . '<th>' . $followups2[$i]["grd_total"] . '</th><th>' . $followups2[$i]["due_amount"] . '</th><th>' . $followups2[$i]["followup_dates"] . '</th></tr>';
                $j++;
            }
        } else {
            $expiredfollow = '';
        }
        $jsonfollow = array(
            "header" => $header,
            "tableheader" => $tableheader,
            "tableheader1" => $tableheader1,
            "tableheader2" => $tableheader2,
            "tablehead" => $tablehead,
            "footer" => $footer,
            "currentfollow" => $currentfollow,
            "pendingfollow" => $pendingfollow,
            "expiredfollow" => $expiredfollow
        );
        return $jsonfollow;
    }

}
