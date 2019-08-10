<?php

class receipts {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    function __construct($para = false) {
        $this->parameters = $para;
    }

    function loadReceipts() {
        //~ $name_o_email=$this->parameters["nameemail"];
        //~ $date=$this->parameters["bydate"];
        $rec = array();
        if (!empty($this->parameters["nameemail"]) || !empty($date)) {
            $sub1 = (strlen($this->parameters["nameemail"]) > 1) ?
                    " (b.`name` LIKE '" . mysql_real_escape_string($this->parameters["nameemail"]) . "%' OR b.`email` LIKE '" . mysql_real_escape_string($this->parameters["nameemail"]) . "%' )" : "(a.`customer_pk` IS NOT NULL)";
            $sub2 = (strlen($this->parameters["bydate"]) > 1) ?
                    " AND c.`pay_date` LIKE '" . mysql_real_escape_string($this->parameters["bydate"]) . "%' " : "";
            $query = "SELECT a. * ,b.`email` AS email1, b.`name` AS 'user_name', b.`cell_number` , c.`pay_date` AS recp_date, c.`receipt_no` AS recp_no, c.`total_amount` AS amt, p.`ver2`
						FROM `invoice` AS a
						JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						LEFT  JOIN  `photo` AS p ON p.`original_pic` = b.`photo_id`
						JOIN `money_transactions` AS c ON c.`id` = a.`transaction_id`
						WHERE  
						" . $sub1 . $sub2 . "
						ORDER BY `id` DESC
						";
        } else {
            $query = "SELECT a. * ,b.`email` AS email1, b.`name` AS 'user_name', b.`cell_number` , c.`pay_date` AS recp_date, c.`receipt_no` AS recp_no, c.`total_amount` AS amt, p.`ver2`
						FROM `invoice` AS a
						JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						LEFT  JOIN  `photo` AS p ON p.`original_pic` = b.`photo_id`
						JOIN `money_transactions` AS c ON c.`id` = a.`transaction_id`
						ORDER BY `id` DESC
						";
        }
        $res = executeQuery($query);
        if (get_resource_type($res) == 'mysql result') {
            if (mysql_num_rows($res) > 0) {
                echo '<div class="row">';
                $i = 1;
                while ($row = mysql_fetch_assoc($res)) {
                    $rec[$i]['id'] = $row['id'];
                    $rec[$i]['customer_pk'] = $row['customer_pk'];
                    $rec[$i]['email1'] = $row['email1'];
                    $rec[$i]['name'] = $row['name'];
                    $rec[$i]['location'] = $row['location'];
                    $rec[$i]['user_name'] = $row['user_name'];
                    $rec[$i]['cell_number'] = $row['cell_number'];
                    /* Photo */
                    if ($row['ver2'])
                        $rec[$i]['photo'] = URL . DIRS . $row['ver2'];
                    else
                        $rec[$i]['photo'] = USER_ANON_IMAGE;
                    $rec[$i]['recp_no'] = $row['recp_no'];
                    $rec[$i]['recp_date'] = $row['recp_date'];
                    $rec[$i]['amt'] = $row['amt'];
                    $i++;
                }
            }
            else {
                $rec = NULL;
            }
        }
        return $rec;
    }

    function DisplayMsg($rec, $begin, $end) {
        $x = sizeof($rec);
        $end = ($x <= $end) ? $x : $end;
        $classes = array('panel-primary', 'panel-green', 'panel-yellow', 'panel-red');
        for ($i = $begin; $i <= $end; $i++) {
            if (!empty($rec[$i])) {
                $recp_date = date('F j, Y, g:i a', strtotime($rec[$i]['recp_date']));
                echo '<div class="col-lg-3 col-md-6">
					<div class="panel ' . $classes[rand(0, 3)] . '">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<img class="img-circle" src="' . $rec[$i]['photo'] . '" width="60" height="60" />
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><i class="fa fa-rupee fa-fw"></i></div>
									<div>' . $rec[$i]['amt'] . '</div>
								</div>
							</div>
						</div>
						<a href="javascript:void(0);" onClick="window.open(\'' . $rec[$i]['location'] . '\')">
							<div class="panel-footer">
								<span class="pull-left">' . $rec[$i]['user_name'] . '<br />' . $rec[$i]['email1'] . '<br />' . $rec[$i]['recp_no'] . '<br /></span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>';
            }
        }
        echo '</div>';
    }

    function dates($date_time) {
        $month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $temp = explode(' ', $date_time);
        $date = explode('-', $temp[0]);
        $i = ($date[1] - 1);
        $m = $month[$i];
        return $date[2] . "-" . $m . "-" . $date[0];
    }

    function fetch_img($customer_pk) {
        $query2 = "SELECT a.`photo_id`,b.`ver3` FROM `customer` AS a 
		JOIN `photo` b ON a.`photo_id` = b.`picture_id`
		WHERE `id`  = '" . mysql_real_escape_string($customer_pk) . "'
		";
        $res2 = executeQuery($query2);
        if (mysql_num_rows($res2) > 0) {
            $row2 = mysql_fetch_assoc($res2);
            $img = URL . DIRS . $row2['ver3'];
        } else {
            $img = URL . DIRS . 'images/anonymous.png';
        }
        return $img;
    }

    /* Datatable for search reciepts */

    public function DisplayMsgTable($rec) {
        $total = sizeof($rec);
        $html = '';
        for ($i = 1; $i <= $total; $i++) {
            $html .= '<tr>
						<td>' . ($i) . '</td>
						<td class="text-right">' . $rec[$i]["user_name"] . '</td>
						<td class="text-right">' . $rec[$i]["email1"] . '</td>
						<td class="text-right">' . $rec[$i]["amt"] . '</td>
						<td class="text-right"><a href="javascript:void(0);" onClick="window.open(\'' . $rec[$i]["location"] . '\')">' . $rec[$i]["recp_no"] . '</a></td>
					</tr>';
        }
        return $html;
    }

}

?>
